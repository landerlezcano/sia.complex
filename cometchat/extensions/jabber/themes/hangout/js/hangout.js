<?php

include_once(dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");

if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
    include_once(dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
}

foreach ($jabber_language as $i => $l) {
$jabber_language[$i] = str_replace("'", "\'", $l);
}

$connectPhrase = $jabber_language[0].' '.$jabber_language[16];
?>
if(typeof(jqcc) === 'undefined'){jqcc = jQuery;};
(function($) {
    var ccjabber = [];
    jqcc.extend(
        jqcc.hangout, {
            jabberInit: function() {
                ccjabber = jqcc.ccjabber.getCcjabberVariable();
                $('<div class="cometchat_tabsubtitle2" id="jabber_login">' + ccjabber.login + '</div>').insertAfter('#cometchat_userstab_popup .cometchat_userstabtitle');
                $('#jabber_login').unbind('click');
                $('#jabber_login').bind('click', function() {
                    jqcc.ccjabber.login();
                });
                var list = '<div id="cometchat_userslist_jabber"></div>';
                $(list).insertAfter('#cometchat_userslist');
                if (jqcc.cookie('cc_jabber') && jqcc.cookie('cc_jabber') == 'true') {
                   jqcc.ccjabber.process();
                }
            },
            jabberLogout: function() {
                $.cometchat.updateJabberOnlineNumber(0);
                $('.cometchat_subsubtitle_siteusers').remove();
                $('.cometchat_subsubtitle_jabber').remove();
                hash = '';
                $('#jabber_login').html(ccjabber.login);
                $('#cometchat_userslist_jabber').html('');
                ccjabber.heartbeatCount = 1;
                clearTimeout(ccjabber.messageTimer);
                ccjabber.heartbeatTime = ccjabber.minHeartbeat;
                jqcc.ccjabber.jabberLogout();               
                $('#jabber_login').unbind('click');
                $('#jabber_login').bind('click', function() {
                        jqcc.ccjabber.login();
                });
            },
            jabberProcess: function() {
                if ($('.cometchat_subsubtitle').first().length == 0) {
                        var head = '<div class="cometchat_subsubtitle cometchat_subsubtitle_top cometchat_subsubtitle_siteusers"><hr class="hrleft"><?php echo $jabber_language[10];?><hr class="hrright"></div>';
                        $(head).insertBefore('#cometchat_userslist');
                }

                var head = '<div class="cometchat_subsubtitle cometchat_subsubtitle_jabber"><hr class="hrleft"><?php echo $jabber_language[11];?><hr class="hrright"></div>';

                if (jqcc.cookie('cc_jabber_type') == 'gtalk') {
                        head = '<div class="cometchat_subsubtitle cometchat_subsubtitle_jabber"><hr class="hrleft"><?php echo $jabber_language[16];?><?php echo $jabber_language[12];?><hr class="hrright"></div>';
                }

                $(head).insertBefore('#cometchat_userslist_jabber');

                $('#cometchat_searchbar').css('display', 'block');

                hash = '';
                $('#jabber_login').html(jqcc.ccjabber.getJabberVariableLogout(jqcc.cookie('cc_jabber_type')));

                $('#jabber_login').unbind('click');
                $('#jabber_login').bind('click', function() {
                        jqcc.ccjabber.logout();
                });

                jqcc.ccjabber.getFriendsList(1);
            },
            getRecentDataAjaxSuccess:  function(data , id , originalid) {
                var temp = '';
                $.each(data, function(id, message) {
                    var sent = 0;
                    var selfstyle = ' cometchat_other';
                    var selfstyleCont = ' cometchat_other_content';
                    var selfstyleAvatar = '';
                    var fromname = $.cometchat.getName(jqcc.ccjabber.encodeName(message.from));
                    if (message.type == 'sent') {
                        sent = 1;
                        fromname = '<?php echo $language[10];?>';
                        selfstyle = ' cometchat_self';
                        selfstyleCont = ' cometchat_self_content';
                        selfstyleAvatar = ' cometchat_self_avatar';
                    }
                    if (fromname.indexOf(" ") != -1) {
                        fromname = fromname.slice(0, fromname.indexOf(" "));
                    }
                    
                    fromname = fromname.split("@")[0];                   
                    message.from = jqcc.ccjabber.encodeName(message.from);
                    message.msg = message.msg.replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    if(message.type == 'sent') {
                        if($('#cometchat_tabcontenttext_'+originalid+' .cometchat_chatboxmessage:last').hasClass('self')){
                            $('#cometchat_tabcontenttext_'+originalid+' .cometchat_chatboxmessage:last .cometchat_ts').before('<div id="cometchat_message_' + message.time + '" class="'+selfstyle+' cometchat_other_noarrow">'+message.msg+'</div>');
                        } else {
                            $('#cometchat_tabcontenttext_'+originalid).append('<div class="cometchat_chatboxmessage self"><div class="cometchat_chatboxmessagecontent '+selfstyleCont+'"><div id="cometchat_message_' + message.time + '" class="'+selfstyle+'">'+message.msg+'</div><span class="cometchat_ts"></span></div><div class="cometchat_chatboxmessagefrom '+selfstyleAvatar+'"><a href="'+ jqcc.cometchat.getThemeArray("buddylistLink",jqcc.cometchat.getThemeVariable("userid"))+'"><img src="'+jqcc.cometchat.getThemeArray('buddylistAvatar',jqcc.cometchat.getThemeVariable('userid'))+'" title="'+fromname+'"/></a></div></div>');
                        }
                    } else {
                        if($('#cometchat_tabcontenttext_'+originalid+' .cometchat_chatboxmessage:last').hasClass('other')){
                            $('#cometchat_tabcontenttext_'+originalid+' .cometchat_chatboxmessage:last .cometchat_message_name').before('<div id="cometchat_message_' + message.time + '" class="'+selfstyle+' cometchat_other_noarrow">'+message.msg+'</div>');
                        } else {
                            $('#cometchat_tabcontenttext_'+originalid).append('<div class="cometchat_chatboxmessage other" ><div class="cometchat_chatboxmessagefrom '+selfstyleAvatar+'"><a href="'+ jqcc.cometchat.getThemeArray('buddylistLink',originalid)+'"><img src="'+jqcc.cometchat.getThemeArray('buddylistAvatar',originalid)+'" title="'+fromname+'"/></a></div><div class="cometchat_chatboxmessagecontent '+selfstyleCont+'"><div id="cometchat_message_' + message.time + '" class="'+selfstyle+'">'+message.msg+'</div><span class="cometchat_message_name">'+fromname+'</span><span class="cometchat_ts"></span></div></div>');
                        }
                    }
                });
                if (temp != '') {
                    $.cometchat.updateHtml(originalid, temp);
                }
            },
            jabberGetFriendsList: function(first) {
                if ($('#cometchat_userslist_jabber').html() == '') {
                    $('#cometchat_userslist_jabber').html('<div class="cometchat_subsubtitle" style="margin-left:10px;" >Loading...</div>');
                }
                jqcc.ccjabber.getFriendsListAjax(first);
            },
            getFriendsListAjaxSuccess: function(data , first) {
                if (data[0] && data[0].error == '1') {
                    jqcc.ccjabber.logout();
                } else {
                    var buddylisttemp = '';
                    var buddylisttempavatar = '';
                    var md5updated = 0;
                    var onlineNumber = 0;
                    var type = 0;
                    $.each(data, function(id, user) {
                       
                        if (user.id) {
                            var numericid = ((user.id).split('@')[0]).split('-')[1];
                            var found = user.id.indexOf('facebook');
                            ++onlineNumber;
                            user.id = jqcc.ccjabber.encodeName(user.id);
                            shortname = $.cometchat.getName(user.id);
                            if(found > 0) {
                                type = 1;
                            }
                            if (typeof (user.n) === "undefined" && type == 1) {
                                $.ajax({
                                    url : "//graph.facebook.com/" + numericid,
                                    dataType : "json",
                                    type : "GET",
                                    async : false,
                                    success : function(output) {
                                        user.n = output.name;
                                    }
                                });
                            }
                            if (user.n != '') {    
                                var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                                var test = '';
                                test = pattern.test(user.n);
                                if(test) {
                                    user.n = user.n.split("@")[0];
                                }
                                if (typeof (shortname) === "undefined") {
                                    shortname = user.n;
                                }
                            }
                            user.a = (user.a).replace('http://',window.location.protocol+'//').replace('https://',window.location.protocol+'//');
                            buddylisttemp += '<div id="cometchat_userlist_' + user.id + '" class="cometchat_userlist" onmouseover="jqcc(this).addClass(\'cometchat_userlist_hover\');" onmouseout="jqcc(this).removeClass(\'cometchat_userlist_hover\');"><span class="cometchat_userscontentname">' + shortname + '</span><span class="cometchat_userscontentdot cometchat_' + user.s + '"></span></div>';
                            buddylisttempavatar += '<div id="cometchat_userlist_' + user.id + '" class="cometchat_userlist" onmouseover="jqcc(this).addClass(\'cometchat_userlist_hover\');" onmouseout="jqcc(this).removeClass(\'cometchat_userlist_hover\');"><span class="cometchat_userscontentavatar cometchat_buddy_'+user.s+'"><img class="cometchat_userscontentavatarimage" original="' + user.a + '"></span><span class="cometchat_userscontentname">' + shortname + '</span></div>';
                            $.cometchat.userAdd(user.id, user.s, user.m, user.n, user.a, '');
                        }
                        if (user.md5) {
                            hash = user.md5;
                            md5updated = 1;
                        }
                    });
                    if (onlineNumber == 0) {
                        buddylisttempavatar = ("<div class='cometchat_nofriends' style='margin-bottom:10px'><?php echo $jabber_language[14];?></div>");	   
                    }
                    if (md5updated) {
                        if (jqcc.cookie('cc_jabber') && jqcc.cookie('cc_jabber') == 'true') {
                            $.cometchat.updateJabberOnlineNumber(onlineNumber);
                            $.cometchat.replaceHtml('cometchat_userslist_jabber', '<div>' + buddylisttempavatar + '</div>');
                            $('.cometchat_userlist').unbind('click');
                            $('.cometchat_userlist').bind('click', function(e) {
                                $.cometchat.userClick(e.target);
                            });
                            if ($.cometchat.getSessionVariable('buddylist') == 1) {
                                $(".cometchat_userscontentavatar img").each(function() {
                                    if ($(this).attr('original')) {
                                        $(this).attr("src", $(this).attr('original'));
                                        $(this).removeAttr('original');
                                    }
                                });
                            }
                            $('#cometchat_search').keyup();
                        }
                    }
                    clearTimeout(ccjabber.friendsTimer);
                    ccjabber.friendsTimer = setTimeout(function() {
                        jqcc.ccjabber.getFriendsList();
                    }, 60000);
                    if (first) {
                        jqcc.ccjabber.getMessages();
                    }
                }
            }
        });
})(jqcc);