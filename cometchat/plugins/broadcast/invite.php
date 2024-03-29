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

$embed = '';
$embedcss = '';
$close = "setTimeout('window.close()',2000);";

function invite() {
	global $userid;
	global $broadcast_language;
	global $language;
	global $embed;
	global $embedcss;
	global $lightboxWindows;
	global $guestsMode;
	global $cookiePrefix;
	global $chromeReorderFix;
	global $hideOffline;

	if($lightboxWindows == '1') {
		$embed = 'web';
		$embedcss = 'embed';
	}
	
	$status['available'] = $language[30];
	$status['busy'] = $language[31];
	$status['offline'] = $language[32];
	$status['invisible'] = $language[33];
	$status['away'] = $language[34];

	$id = $_GET['roomid'];

	if (empty($id)) { exit; }

	$time = getTimeStamp();
	$buddyList = array();

	$onlineCacheKey = 'all_online';
	if($userid > 10000000){
		$onlineCacheKey .= 'guest';
	}

	if ($onlineUsers = getCache($cookiePrefix.$onlineCacheKey, 30)) {
		$buddyList = unserialize($onlineUsers);
	} else {
		$sql = getFriendsList($userid,$time);
		if($guestsMode){
	    	$sql = getGuestsList($userid,$time,$sql);
		}
		$query = mysqli_query($GLOBALS['dbh'],$sql);	
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }	
		while ($chat = mysqli_fetch_assoc($query)) {	
			if (((($time-processTime($chat['lastactivity'])) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') || $chat['isdevice'] == 1) {
				if ($chat['status'] != 'busy' && $chat['status'] != 'away') {
					$chat['status'] = 'available';
				}
			} else {
				$chat['status'] = 'offline';
			}
		
			$avatar = getAvatar($chat['avatar']);
	
			if (!empty($chat['username'])) {
				if (function_exists('processName')) {
					$chat['username'] = processName($chat['username']);
				}	
				if ($chat['userid'] != $userid && ($hideOffline == 0||($hideOffline == 1 && $chat['status']!='offline'))) {
					$buddyList[$chromeReorderFix.$chat['userid']] = array('id' => $chat['userid'], 'n' => $chat['username'], 'a' => $avatar, 's' => $chat['status']);
				}
			}
		}
	}
	
	if (DISPLAY_ALL_USERS == 0 && MEMCACHE <> 0) {
		$tempBuddyList = array();
		if ($onlineFrnds = getCache($cookiePrefix.'friend_ids_of_'.$userid, 30)) {
			$friendIds = unserialize($onlineFrnds);
		} else {
			$sql = getFriendsIds($userid);
			$query = mysqli_query($GLOBALS['dbh'],$sql);
			if(mysqli_num_rows($query) == 1 ){
				$buddy = mysqli_fetch_assoc($query);
				$friendIds = explode(',',$buddy['friendid']);
			}else {
				while($buddy = mysqli_fetch_assoc($query)){
					$friendIds[]=$buddy['friendid'];
				}
			}
			setCache($cookiePrefix.'friend_ids_of_'.$userid,serialize($friendIds), 30);
		}
		foreach($friendIds as $friendId) {
			$friendId = $chromeReorderFix.$friendId;
			if (isset($buddyList[$friendId])) {
				$tempBuddyList[$friendId] = $buddyList[$friendId];
			}
		}
		$buddyList = $tempBuddyList;
	}

	if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
		$buddyList = array_merge(hooks_forcefriends(),$buddyList);
	}

	$s['available'] = '';
	$s['away'] = '';
	$s['busy'] = '';
	$s['offline'] = '';

	foreach ($buddyList as $buddy) {
		$s[$buddy['s']] .= '<div class="invite_1"><div class="invite_2" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;"><img height=30 width=30 src="'.$buddy['a'].'"></div><div class="invite_3" onclick="javascript:document.getElementById(\'check_'.$buddy['id'].'\').checked = document.getElementById(\'check_'.$buddy['id'].'\').checked?false:true;">'.$buddy['n'].'<br/><span class="invite_5">'.$status[$buddy['s']].'</span></div><input type="checkbox" name="invite[]" value="'.$buddy['id'].'" id="check_'.$buddy['id'].'" class="invite_4"></div>';
	}
	
	$inviteContent = '';
	$invitehide = '';
	$inviteContent = $s['available']."".$s['away']."".$s['offline'];
	if(empty($inviteContent)) {
		$inviteContent = $broadcast_language[18];
		$invitehide = 'style="display:none;"';
	}

	echo <<<EOD
	<!DOCTYPE html>
	<html>
	<head>
	<title>{$broadcast_language[13]}</title> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
	<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=broadcast" /> 
	</head>
	<body>
	<form method="post" action="invite.php?action=inviteusers&embed={$embed}">
	<div class="container">
	<div class="container_title {$embedcss}">{$broadcast_language[11]}</div>
	<div class="container_body {$embedcss}">
	{$inviteContent}
	<div style="clear:both"></div>
	</div>
	<div class="container_sub" {$invitehide}>
	<input type=submit value="{$broadcast_language[12]}" class="invitebutton">
	</div>
	</div>	
	<input type="hidden" name="roomid" value="$id">
	</form>
	</body>
	</html>
EOD;

}

function inviteusers() {
	global $broadcast_language;
	global $userid;
	global $close;
	global $embedcss;
	global $lightboxWindows;

	if($lightboxWindows == '1') {
		$embedcss = 'embed';
	}
	
	foreach ($_POST['invite'] as $user) {
		$response = sendMessage($user,"{$broadcast_language[14]}<a href=\"javascript:jqcc.ccbroadcast.accept('{$userid}','{$_POST['roomid']}')\">{$broadcast_language[15]}</a>",1);		
	}

	echo <<<EOD
	<!DOCTYPE html>
	<html>
	<head>
	<title>{$broadcast_language[13]}</title> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
	<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=broadcast" /> 
	</head>
	<body onload="{$close}">
	<div class="container">
	<div class="container_title {$embedcss}">{$broadcast_language[11]}</div>
	<div class="container_body {$embedcss}">
	{$broadcast_language[13]}</span>
	<div style="clear:both"></div>
	</div>
	</div>	
	</body>
	</html>
EOD;

}

$allowedActions = array('invite','inviteusers');
$action = 'invite';

if (!empty($_GET['action']) && function_exists($_GET['action']) && in_array($_GET['action'],$allowedActions)) {
	$action = $_GET['action'];
}
call_user_func($action);