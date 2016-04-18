<?php
	// Get all Social Media Accounts
	global $wp_query;
	$social = get_posts(array(
		'post_type' => 'someaccs',
	));

	foreach($social as $acc) :
		$title = $acc->post_title;
		$icon = get_post_meta($acc->ID, 'ct_some_icon' );
		$link = get_post_meta($acc->ID, 'ct_some_link' );
?>
<table align="left" border="0" cellpadding="0" cellspacing="0">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                    <a href="<?=$link[0];?>" title="<?=$title;?>" target="_blank"><img src="http://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-<?= strtolower($title) ?>-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
<?php endforeach; ?>
<?php wp_reset_postdata();?>