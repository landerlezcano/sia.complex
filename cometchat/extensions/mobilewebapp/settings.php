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

	$chatroom = '';
	$private = '';
	$none = '';

	if ($enableType == '0') {
		$none = "selected";
	} else if ($enableType == '1') {
		$chatroom = "selected";
	} else if ($enableType == '2') {
		$private = "selected";
	}

	$message = "<h3 id='data'></h3>";

	
echo <<<EOD
<!DOCTYPE html>

<html>
<head>
$getstylesheet
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
function resizeWindow() {
	window.resizeTo(($("form").outerWidth()+window.outerWidth-$("form").outerWidth()), ($('form').outerHeight()+window.outerHeight-window.innerHeight));
}
</script>
</head>

<body>
	<form style="height:100%;" action="?module=dashboard&action=loadexternal&type=extension&name=mobilewebapp&process=true" method="post">
	<div id="content" style="width:auto;">
			<h2>Settings</h2><br />
			<h3 id='data'>You can enable/disable Private chat or Chatroom.</h3>
					
			<div style="margin-bottom:10px;">
					<div class="title">Enable :</div>
					<div class="element" id="">
						<select name="enableType" id="TypeSelector">
							<option value="0" $none>Both</option>	
							<option value="1" $chatroom>Only Chatroom</option>							
							<option value="2" $private>Only One-on-one Chat</option>
							
						</select>
					</div>
					<div style="clear:both;padding:5px;"></div>
					


				<div style="clear:both;padding:5px;"></div>					
			</div>
			<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="javascript:window.close();">cancel or close</a>
	</div>
	</form>
<script type="text/javascript" language="javascript">
	$(document).ready(function() { 
		setTimeout(function(){
				resizeWindow();
			},200);
	});
</script>
</body>
</html>
EOD;
} else {
	
	$data = '';
	foreach ($_POST as $field => $value) {
		$data .= '$'.$field.' = \''.$value.'\';'."\r\n";
	}

	configeditor('SETTINGS',$data,0,dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');	
	header("Location:?module=dashboard&action=loadexternal&type=extension&name=mobilewebapp");
}