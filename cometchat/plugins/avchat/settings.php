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

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	global $getstylesheet;
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
	
	$curl = 0;
	$errorMsg = '';

	$schkd = '';
	$rchkd = '';
	$fchkd = '';
	$ochkd = '';
	$alchkd = '';
	$zchkd = '';
	$wchkd = '';

	$hideFMSSettings = '';
	$hideRed5Settings = '';
	$hideOTASettings = '';
	$hideAddLiveSettings = '';
    $commonSettingsHide = '';
    $hideFMSSettingsMain= '';
	$hideZoomSettings= '';

	$commonSettings = '';

	if ($videoPluginType == '4') {
		$alchkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$commonSettingsHide  = 'style="display:none;"';
        $hideOTASettings = 'style="display:none;"'; 
        $hideFMSSettingsMain = 'style="display:none;"'; 
	} else if ($videoPluginType == '3') {
		$ochkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$commonSettings = 'display:none;';
		$hideAddLiveSettings = 'style="display:none;"';
        $hideFMSSettingsMain = 'style="display:none;"'; 
                if(!checkcURL()) {
			$curl = 1;
			$hideOTASettings = 'style="display:none;"';
			$errorMsg = "<h2 id='errormsg' style='font-size: 11px; color: rgb(255, 0, 0);'>cURL extension is disabled on your server. Please contact your webhost to enable it. cURL is required for CometChat Server.</h2>";
		}
	} else if ($videoPluginType == '2') {
		$fchkd = "selected";
		$hideRed5Settings = 'style="display:none;"';
		$hideOTASettings = 'style="display:none;"';
		$hideAddLiveSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$errorMsg = '';
                $commonSettingsHide = '';
	} else if ($videoPluginType == '1') {
		$rchkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideOTASettings = 'style="display:none;"';
		$hideAddLiveSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$errorMsg = '';
                $commonSettingsHide = '';
	}  else if ($videoPluginType == '5') {
	
		$zchkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideFMSSettingsMain = 'style="display:none;"';
		$hideOTASettings = 'style="display:none;"';
		$hideAddLiveSettings = 'style="display:none;"';
		$hideRed5Settings = 'style="display:none;"';
		$commonSettings = 'display:none;';
		$commonSettings = 'display:none;';
		$errorMsg = '';
                $commonSettingsHide = '';
	}else if ($videoPluginType == '6') {
	
		$wchkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$commonSettings = 'display:none;';
		$hideAddLiveSettings = 'style="display:none;"';
        $hideFMSSettingsMain = 'style="display:none;"'; 
		
	} else {
		$schkd = "selected";
		$hideFMSSettings = 'style="display:none;"';
		$hideOTASettings = 'style="display:none;"';
		$hideAddLiveSettings = 'style="display:none;"';
		$hideZoomSettings = 'style="display:none;"';
		$errorMsg = '';
        $hideFMSSettingsMain = 'style="display:none;"'; 
                $commonSettingsHide = '';
	}

	$message = "<h3 id='data'></h3>";

	
echo <<<EOD
<!DOCTYPE html>

<html>
<head>
	<script type="text/javascript" src="../js.php?admin=1"></script>
	<script type="text/javascript" language="javascript">
	
		$(document).ready(function() {

			var selected = $("#pluginTypeSelector :selected").val();
			if(selected=="0" || selected=="1" || selected=="2") {
				$('h3').show();
				$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 440 and height is 330.');
			} else if(selected=="3") {
				$('h3').show();
				$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 220 and height is 165.');
			} else if(selected=="4") {
				$('h3').show();
				$('#data').html('Make sure that the width and height are in the ratio 16:9. Default width is 650 and height is 365.');
			} else if (selected=="6") {
				$('h3').show();
				$('#data').html('WebRTC is currently supported by Chrome,Opera and Firefox.');
			}
				
			$("#pluginTypeSelector").change(function() {
				var selected = $("#pluginTypeSelector :selected").val();
				var errorMsg = 0;
				if(selected=="1") {					
					$("#lccsSettings").hide();
					$("#fmsSettings").show();
					$("#zmSettings").hide();
					$("#centernav").show();
                    $(".commonSettingsHide").show();    
					$("#centernavot").hide();
					$("#AddLiveSettings").hide();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 440 and height is 330.');
				} else if(selected=="2") {
					$("#lccsSettings").hide();
					$("#zmSettings").hide();
					$("#fmsSettings").show();
					$("#centernav").show();
                                        $(".commonSettingsHide").show();    
					$("#centernavot").hide();
					$("#AddLiveSettings").hide();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 440 and height is 330.');
				} else if(selected=="0") {
					$("#lccsSettings").hide();
					$("#fmsSettings").hide();
					$("#zmSettings").hide();
					$("#centernav").show();
                                        $(".commonSettingsHide").show();        
					$("#centernavot").hide();
					$("#AddLiveSettings").hide();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 440 and height is 330.');
				} else if(selected=="3") {
					$("#fmsSettings").hide();
					$("#lccsSettings").hide();
					$("#centernav").hide();
					$("#zmSettings").hide();
					if(errorMsg == {$curl}) {
						$("#otaSettings").show();
						$("#centernavot").show();
					} else {
						$('#errormsg').show();
					}
					$("#AddLiveSettings").hide();
					$('h3').show();
					$('#data').html('Make sure that the width and height are in the ratio 4:3. Default width is 220 and height is 165.');
				} else if(selected=="4") {
					$("#fmsSettings").hide();
					$("#lccsSettings").hide();
					$(".commonSettingsHide").hide();
					$("#otaSettings").hide();
					$("#centernavot").hide();
					$("#zmSettings").hide();
					$("#AddLiveSettings").show();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('Make sure that the width and height are in the ratio 16:9. Default width is 650 and height is 365.');
				} else if(selected=="5") {
					$("#fmsSettings").hide();
					$("#lccsSettings").hide();
					$(".commonSettingsHide").hide();
					$("#otaSettings").hide();
					$("#centernavot").hide();
					$("#AddLiveSettings").hide();
					$("#centernav").hide();
					$("#zmSettings").show();
					$("#centernavzm").show();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('<h5>Video plugin Zoom.us is configured to use with one on one chat and will not work in chatrooms. </h5></br>Make sure that email you have entered is case-sencitive.');
				}else if(selected=="6") {
					$("#fmsSettings").hide();
					$("#lccsSettings").hide();
					$("#centernav").hide();
					$("#zmSettings").hide();
					$("#AddLiveSettings").hide();
					$('h3').show();
					$('#data').html('WebRTC is currently supported by Chrome,Opera and Firefox.');
				}
				resizeWindow();
			});
			setTimeout(function(){
				resizeWindow();
			},200);
		});
		function resizeWindow() {
			window.resizeTo(($("form").outerWidth()+window.outerWidth-$("form").outerWidth()), ($('form').outerHeight()+window.outerHeight-window.innerHeight));
		}
	</script>

	$getstylesheet

</head>

<body>
	<form style="height:100%" action="?module=dashboard&action=loadexternal&type=plugin&name=avchat&process=true" method="post">
	<div id="content" style="width:auto">
			<h2>Audio/Video Chat Settings</h2><br />
					{$message}
			<div style="margin-bottom:10px;">
					<div class="title">Use :</div>
					<div class="element" id="">
						<select name="videoPluginType" id="pluginTypeSelector">
							<option value="5" $zchkd>Zoom.us</option>	
							<option value="4" $alchkd>AddLive</option>	
							<option value="3" $ochkd>CometChat Server</option>							
							<option value="1" $rchkd>RED5 or FMS (RTMP)</option>
							<option value="2" $fchkd>FMS (RTMFP)</option>
							<option value="0" $schkd>Stratus</option>
							<option value="6" $wchkd>WebRTC</option>
						</select>
					</div>
					<div style="clear:both;padding:5px;"></div>
					{$errorMsg}
					<div id="otaSettings" $hideOTASettings>
						
					<div>
						<div id="centernavot" style="width:380px">
							<div class="title">Video Width:</div><div class="element"><input type="text" class="inputbox" name="vidWidth" value="$vidWidth"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Video height:</div><div class="element"><input type="text" class="inputbox" name="vidHeight" value="$vidHeight"></div>
							<div style="clear:both;padding:5px;"></div>

						</div>
					</div>
				</div>
				<div id="AddLiveSettings" $hideAddLiveSettings>
					<div>
						<div id="centernal" style="width:380px">
								<div>Don&#39;t have the API keys? <a href="https://developer.addlive.com/cometchat" target="_blank">Create a new AddLive account</a>.</div>
								<div style="clear:both;padding:5px;"></div>
								<div class="title">Application ID:</div><div class="element"><input type="text" class="inputbox" name="applicationid" value="$applicationid"></div>
								<div style="clear:both;padding:5px;"></div>
								<div class="title">Application Auth Secret key:</div><div class="element"><input type="text" class="inputbox" name="appAuthSecret" value="$appAuthSecret"></div>
								<div style="clear:both;padding:5px;"></div>
							</div>
						</div>
				</div>

				<div style="clear:both;padding:5px;"></div>					
			</div>
				<div id="centernav" style="width:380px; $commonSettings ">
                <div class="commonSettingsHide" $commonSettingsHide>
					<div class="title" >Maximum Participants:</div><div class="element"><input type="text" class="inputbox" name="maxP" value="$maxP"></div>
					<div style="clear:both;padding:5px;"></div>
					<div class="title" >Quality:</div><div class="element"><input type="text" class="inputbox" name="quality" value="$quality"></div>
					<div style="clear:both;padding:5px;"></div>
                                                </div>
					<div class="title">Popup Width:</div><div class="element"><input type="text" class="inputbox" name="winWidth" value="$winWidth"></div>
					<div style="clear:both;padding:5px;"></div>
					<div class="title">Popup Height:</div><div class="element"><input type="text" class="inputbox" name="winHeight" value="$winHeight"></div>
					<div style="clear:both;padding:5px;"></div>
				</div>
			
				
				<div id="fmsSettings" $hideFMSSettingsMain>
					<div>
						<div id="centernavfms" style="width:380px">
							<div class="title">Connect URL:</div><div class="element_fms_red5"><input type="text" class="inputbox" name="connectUrl" value="$connectUrl"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Camera Width:</div><div class="element"><input type="text" class="inputbox" name="camWidth" value="$camWidth"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Camera Height:</div><div class="element"><input type="text" class="inputbox" name="camHeight" value="$camHeight"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Frames Per Second:</div><div class="element"><input type="text" class="inputbox" name="fps" value="$fps"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Sound Quality:</div><div class="element"><input type="text" class="inputbox" name="soundQuality" value="$soundQuality"></div>
							<div style="clear:both;padding:5px;"></div>
						</div>
					</div>
				</div>
				
				<div id="zmSettings" $hideZoomSettings>
					<div>
						<div id="centernavzm" style="width:380px">
							<div>Don&#39;t have the API keys? <a href="https://zoom.us/account/api" target="_blank">Create a new Zoom account</a>.</div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Application ID:</div><div class="element"><input type="text" class="inputbox" name="zoomapplicationid" value="$zoomapplicationid"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">Application Secret key:</div><div class="element"><input type="text" class="inputbox" name="zoomappAuthSecret" value="$zoomappAuthSecret"></div>
							<div style="clear:both;padding:5px;"></div>
							<div class="title">E-mail field in your database:</div><div class="element"><input type="text" class="inputbox" name="email" value="$email"></div>
							<div style="clear:both;padding:5px;"></div>
						</div>
					</div>
				</div>				
			<div style="clear:both;padding:7.5px;"></div>
			<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="javascript:window.close();">cancel or close</a>
	</div>
	</form>
</body>
</html>
EOD;
} else {
	
	$data = '';
	foreach ($_POST as $field => $value) {
		$data .= '$'.$field.' = \''.$value.'\';'."\r\n";
	}

	configeditor('SETTINGS',$data,0,dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');	
	header("Location:?module=dashboard&action=loadexternal&type=plugin&name=avchat");
}