<?php

	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");
	$adCode = str_replace("'", "\'", $adCode);
	$adCode = str_replace("\r\n", "", $adCode);
?>

/*
 * CometChat
 * Copyright (c) 2014 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccads = (function () {

		var title = 'Advertisements Extension';
		var height = '<?php echo $adHeight;?>';

        return {

			getTitle: function() {
				return title;	
			},

			init: function () {

				$("#cometchat_chatboxes_wide").find(".cometchat_tab").live("click", function(event){
					var activeId = $.cometchat.getActiveId();
					if(typeof (activeId) == 'object' && activeId.length > 0) {
						baseUrl = $.cometchat.getBaseUrl();
						var totalActiveIds = activeId.length;
						for (var i=0;i<totalActiveIds;i++){
							if($('#cometchat_user_'+activeId[i]+'_popup').find("div.cometchat_ad").length == 0){
								var ad = '<iframe src="'+baseUrl+'extensions/ads/embed.php" frameborder="0" width="218" height="'+height+'">';
								$('<div class="cometchat_tabsubtitle cometchat_ad">'+ad+'</div>').insertBefore('#cometchat_user_'+activeId[i]+'_popup .cometchat_tabsubtitle');
							}
						}
					} else if (activeId != '' && $('#cometchat_user_'+activeId+'_popup').find("div.cometchat_ad").length == 0) {
							baseUrl = $.cometchat.getBaseUrl();
							var ad = '<iframe src="'+baseUrl+'extensions/ads/embed.php" frameborder="0" width="218" height="'+height+'">';
							$('<div class="cometchat_tabsubtitle cometchat_ad">'+ad+'</div>').insertBefore('#cometchat_user_'+activeId+'_popup .cometchat_tabsubtitle'); 

					}
				});
			}


        };
    })();
 
})(jqcc);