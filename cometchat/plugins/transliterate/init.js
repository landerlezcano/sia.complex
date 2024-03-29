<?php

		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");

		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
		} 

		foreach ($transliterate_language as $i => $l) {
			$transliterate_language[$i] = str_replace("'", "\'", $l);
		}
?>

/*
 * CometChat
 * Copyright (c) 2014 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.cctransliterate = (function () {

		var title = '<?php echo $transliterate_language[0];?>';
		
        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				<?php if($type=='module'&&$name=='chatrooms'): ?>
					baseUrl = $.cometchat.getBaseUrl();
					basedata = $.cometchat.getBaseData();
					$[$.cometchat.getChatroomVars('calleeAPI')].loadCCPopup(baseUrl+'plugins/transliterate/index.php?chatroommode=1&id='+id+'&basedata='+basedata, 'transliterate',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=0, width=430,height=220",430,175,'<?php echo $transliterate_language[0];?>');
				<?php else: ?>
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					loadCCPopup(baseUrl+'plugins/transliterate/index.php?id='+id+'&basedata='+baseData, 'transliterate',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=0, width=430,height=220",430,175,'<?php echo $transliterate_language[0];?>'); 
				<?php endif; ?>
			}

        };
    })();
 
})(jqcc);