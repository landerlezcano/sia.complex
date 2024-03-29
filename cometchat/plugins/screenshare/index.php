<?php

/*

CometChat
Copyright (c) 2014 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
}

if ($p_<4) exit;

checkScreenshareConfig();

if($screensharePluginType== 2){
	$alertmessage = 0;
	$useremailid = '';
	if (isset($_REQUEST['chatroommode'])) {
		$_REQUEST['callback'] = time();
	}
	
	if ($_GET['action'] == 'request') {

		$sql ="SELECT ".$email." FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE `".DB_USERTABLE_USERID."` ='".$userid."'";
		$query = mysqli_query($GLOBALS['dbh'],$sql);
		$result = mysqli_fetch_assoc($query);
		$url="https://api.zoom.us/v1/user/list";
		$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&page_size=30&page_number=1";
		$response  = json_decode(checkcURL(0,$url,$params,1), true);
		$flag = 0;

		foreach ($response['users'] as $user) {
			if ($user['email'] == $result['email']) {
				$url="https://api.zoom.us/v1/meeting/create";
				$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&host_id=".$user['id']."&topic=screenshare&type=3&option_jbh=true&option_start_type=screen_share";
				$response = json_decode(checkcURL(0,$url,$params,1), true);
				$grp = $_REQUEST['to'];
				if (!empty($response['start_url']) && !isset($_REQUEST['chatroommode'])) {
					sendMessage($_REQUEST['to'],$screenshare_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$grp."','".$response['join_url']."','".$response['start_url']."');\">".$screenshare_language[3]."</a> ".$screenshare_language[4],1);
					
					$temp_callback = $_REQUEST['callback'];
					$_REQUEST['callback'] = time();
					
					sendMessage($_REQUEST['to'],$screenshare_language[5]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept_fid('".$userid."','".$response['start_url']."');\">".$screenshare_language[11]."</a>",2);
					$_REQUEST['callback'] = $temp_callback;
				} else if (!empty($response['start_url'])) {
					sendChatroomMessage($grp,$screenshare_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$grp."','".$response['join_url']."','".$response['start_url']."', 'chatroommode');\">".$screenshare_language[3]."</a>",0);
				}
				$flag = 0;
					break;
			}
			$flag++;
		}
		if ($flag != 0 && !isset($_REQUEST['chatroommode'])) {
			$url="https://api.zoom.us/v1/user/create";
			$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&email=".$result['email']."&type=1";
			json_decode(checkcURL(0,$url,$params,1), true);
			sendMessage($_REQUEST['to'],$screenshare_language[12]." ".$result['email'],2);
		} else if($flag != 0 && isset($_REQUEST['chatroommode'])) {
			$url="https://api.zoom.us/v1/user/create";
			$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&email=".$result['email']."&type=1";
			json_decode(checkcURL(0,$url,$params,1), true);
			$alertmessage = 1;
			$useremailid = $result['email'];
		}
	}

	if ($_GET['action'] == 'accept') {
		
		$sql ="SELECT ".$email." FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE `".DB_USERTABLE_USERID."` ='".$userid."'";
		$query = mysqli_query($GLOBALS['dbh'],$sql);
		$result = mysqli_fetch_assoc($query);
		
		$url="https://api.zoom.us/v1/user/list";
		$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&page_size=30&page_number=1";
		$response = json_decode(checkcURL(0,$url,$params,1), true);		
		$flag = 0;
		foreach ($response['users'] as $user) {
			if ($user['email'] == $result['email']) {
				$flag = 0;
				break;
			}
			$flag++;
		}
		if($flag != 0 && !isset($_REQUEST['chatroommode'])) {
			$url="https://api.zoom.us/v1/user/create";
			$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&email=".$result['email']."&type=1";
			json_decode(checkcURL(0,$url,$params,1), true);
			sendMessage($_REQUEST['to'],$screenshare_language[12]." ".$result['email'],2);
		} else if ($flag != 0 && isset($_REQUEST['chatroommode'])) {
			$url="https://api.zoom.us/v1/user/create";
			$params="api_key=".$zoomapplicationid."&api_secret=".$zoomappAuthSecret."&data_type=JSON&email=".$result['email']."&type=1";
			json_decode(checkcURL(0,$url,$params,1), true);
			$alertmessage = 1;
			$useremailid = $result['email'];
		}
	}
	if (isset($_REQUEST['chatroommode'])) {
		echo $alertmessage.'^'.$useremailid;
	}
	exit;
} else {
	if ($_GET['action'] == 'request') {

		$grp = $_REQUEST['id'];
                if (isset($_REQUEST['chatroommode'])) {
                    sendChatroomMessage($_REQUEST['to'],$screenshare_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept('".$_REQUEST['to']."','".$grp."','','', 'chatroommode');\">".$screenshare_language[3]."</a>",0);
                } else {
                    sendMessage($_REQUEST['to'],$screenshare_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$grp."');\">".$screenshare_language[3]."</a> ".$screenshare_language[4],1);
                    $temp_callback = $_REQUEST['callback'];
                    $_REQUEST['callback'] = time();
                    sendMessage($_REQUEST['to'],$screenshare_language[5],2);
                    $_REQUEST['callback'] = $temp_callback;
                }

		if (!empty($_GET['callback'])) {
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'].'()';
		}
	}

	if ($_GET['action'] == 'accept') {
		sendMessage($_REQUEST['to'],$screenshare_language[6],1);
		
		if (!empty($_GET['callback'])) {
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'].'()';
		}
	}

	if ($_GET['action'] == 'screenshare') {
		global $lightboxWindows;

		$id = $_GET['id'];
		$type = $_GET['type'];

		if (!empty($_GET['chatroommode'])) {
			sendChatroomMessage($_GET['roomid'],$screenshare_language[2]." <a href='javascript:void(0);' onclick=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$_GET['id']."');\">".$screenshare_language[3]."</a>",0);
		}

		ini_set('display_errors', 0);
		
		$connectUrl = "rtmp://" . $hostAddress . "/" . $application;

	if ($screensharePluginType == '0') {
		if ($type == 1) {
			echo <<<EOD
				<!DOCTYPE html>
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
				<title>{$screenshare_language[0]}</title> 
				<style>
				html, body, div, span, applet, object, iframe,
				h1, h2, h3, h4, h5, h6, p, blockquote, pre,
				a, abbr, acronym, address, big, cite, code,
				del, dfn, em, font, img, ins, kbd, q, s, samp,
				small, strike, strong, sub, sup, tt, var,
				dl, dt, dd, ol, ul, li,
				fieldset, form, label, legend,
				table, caption, tbody, tfoot, thead, tr, th, td {
					margin: 0;
					padding: 0;
					border: 0;
					outline: 0;
					font-weight: inherit;
					font-style: inherit;
					font-size: 100%;
					font-family: inherit;
					vertical-align: baseline;
					text-align: center;
				}

				html {
				  height: 100%;
				  overflow: hidden; /* Hides scrollbar in IE */
				}

				body {
				  height: 100%;
				  margin: 0;
				  padding: 0;
				  background:#000000;
				}

				#flashcontent {
				  height: 100%;
				}
				</style>
				</head>
				<body>
					<applet name="Screensharing" code="screenshare.ScreenShare.class" archive="ScreenShare.jar" width="430" height="100">
						<param name="streamId" value="{$id}"/>
						<param name="host" value="{$hostAddress}"/>
						<param name="application" value="{$application}"/>
					</applet>
				</body>
				</html>
EOD;
		} else {
			echo <<<EOD
			<html>
				<head>
				<title>ScreenViewer</title>
					<script type="text/javascript" src="../../js.php?type=plugin&name=screenshare&subtype=fmsred5"></script>
					<script type="text/javascript">
					var screenViewer = null;
					</script>
				</head>
				<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" onload="setupApp()" onUnload="stopApp()">
				<div id="screenViewerDIV"></div>
				<script type="text/javascript">
						var stream = getPageParameter('stream', '{$id}');
						var url = getPageParameter('url', '{$connectUrl}');
						var control = getPageParameter('control', 'true');

						fo = new SWFObject("ScreenSharing.swf?rtmpUrl=" + url + "&recieverStream=" + stream + "&control=" + control, "screenViewerID", "100%", "100%", "9");
						fo.addParam("swLiveConnect", "true");
						fo.addParam("name", "screenViewerID");
						fo.write("screenViewerDIV");
				</script>
				</body>
				</html>
EOD;
		}
	} else {
		
		if ($type == 1) {
			$data = '<div id="tut8CtrlWrapper" class="controls-wrapper">
					<div class="controls-wrapper">
						<!--Screen capture source selection -->
						<div class="ctrl-wrapper">
							<div class="scr-share-src-wrapper">
								<ul class="scr-share-src-list" id="screenShareSources" style="margin-left: 10px;">
									<img src="loadingwhite.gif" style="position: absolute; top: 30%; left: 43%;">
									<p id="message" style="display:none;margin-top:10px">To use ScreenShare, you need to install a quick plug-in to make it all work. You just need to install this plug-in once.</p><a id="installBtn" class="installBtn" href="#">'.$screenshare_language[10].'</a>
								</ul>
							</div>
							<div class="clearer"></div>
						</div>
						<!-- Control button -->
						<div class="ctrl-wrapper">
							<a id="refreshBtn" style="margin: 0px 10px;" href="javascript://nop" class="btn btn-primary disabled">'.$screenshare_language[8].'</a>'.$screenshare_language[9].'
						</div>
					</div>
				</div><script type="text/javascript">
					window.onresize = function() { window.resizeTo(825,415); }
				</script>
				<!-- End of the user controls section -->';
				} else {
					$data = '<div class="main">
								<div id="renderRemoteUser"><img src="loading.gif" style="position: absolute; top: 40%; left: 43%;">
									<div id="info" style="position: absolute; top: 2%; padding: 0px;">
										<p id="message" style="display:none;margin-left:10px;color:#ffffff">To use ScreenShare, you need to install a quick plug-in to make it all work. You just need to install this plug-in once.</p>
										<a id="installBtn" class="installBtn" href="#" style="margin-left: 10px;">'.$screenshare_language[10].'</a>
									</div>
								</div>
							</div>';
				}

			echo <<<EOD
			<html>
			<head>
				<title>{$screenshare_language[7]}</title>
				<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
				<script type="text/javascript" src="http://api.addlive.com/stable/addlive-sdk.min.js"></script>
				<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
				<script src="../../js.php?type=plugin&name=screenshare&subtype=addlive" type="text/javascript"></script>
				
				<link media="all" rel="stylesheet" type="text/css" href="../../css.php?type=plugin&name=screenshare&subtype=addlive" />
				<script type="text/javascript">
						var scopeid = "{$id}";
						$(document).ready(function(){
							$('.cometchat_loading').hide();
						});
				</script>
			</head>
			<body>
				{$data}
			</body>
			<script>
				function closeEditorWarning() {
					return 'Closing the window will cause screensharing to stop.'
				}
				window.onbeforeunload = closeEditorWarning;
			</script>
			</html>
EOD;
	}
}
}

function checkScreenshareConfig(){

	global $hostAddress, $screensharePluginType , $applicationid , $appAuthSecret;

	$error = "<div style='background:white;'>Please configure this plugin using administration panel before using.<a href='http://www.cometchat.com/documentation/admin/plugins/screensharing-plugin/' target='_blank'>Click here</a> for more information.</div>";

	switch ($screensharePluginType) {
		case '0':
			if (empty($hostAddress)) {
				echo $error; 
				exit;
			}
			break;
		case '1':
			if (empty($applicationid) || empty($appAuthSecret)) {
				echo $error; 
				exit;
			}
			break;
		case '2':
			if (empty($zoomapplicationid) || empty($zoomappAuthSecret)) {
				echo $error; 
				exit;
			}
			break;		
	}
}