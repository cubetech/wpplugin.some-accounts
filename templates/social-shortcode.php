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
<a href="<?=$link[0];?>" title="<?=$title;?>" target="_blank"><i class="fa fa-<?=$icon[0];?>"></i><?=$title;?></a>
<?php endforeach; ?>
<?php wp_reset_postdata();?>