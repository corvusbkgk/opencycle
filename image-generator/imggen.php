<?php
/*
Plugin name: Image Generator
*/

function ig_get_image($post_id) {
$args = array(
   'post_type' => 'attachment',
   'numberposts' => 1,
   'post_status' => null,
   'post_parent' => $post_id,
   'orderby' => 'rand'
  );

	$attachments = get_posts( $args );
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			return wp_get_attachment_image_src($attachment->ID, 'medium');
		}
	}
}

$img_gen_list = array();

function ig_get_images() {
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'numberposts' => 20
	);

	global $img_gen_list;
	$i=0;

	$posts = get_posts( $args );
	if ($posts ) {
		foreach ( $posts as $p ) {
			$img_gen_list[$i] = ig_get_image($p->ID);
			$i++;
		}
	}
}

function ig_generate() {
	global $img_gen_list;
	$imgs = array();
	$c_w = 0;
	$c_h = 80;

	foreach ( $img_gen_list as $a ) {
		if ($a[2]==0) { continue; }
		$c_w += $a[1] / ($a[2] / $c_h);
	}

	$canvas = imagecreatetruecolor($c_w, $c_h);

	$cur_x = 0;
	foreach ( $img_gen_list as $a ) {
		if ($a[2]==0) { continue; }
		$img = imagecreatefromjpeg($a[0]);
		$i_h = $c_h;
		$i_w = $a[1] / ($a[2] / $c_h);
		imagecopyresized($canvas, $img, $cur_x, 0, 0, 0, $i_w, $i_h, $a[1], $a[2]);
		$cur_x += $i_w;
	}

	imagejpeg($canvas, '../../cms/wp-content/themes/opencycle/images/header.jpg', 100);
}

function ig_do_all() {
	ig_get_images();
	ig_generate();
}

register_activation_hook(__FILE__, "ig_do_all");
add_action('published_post', 'ig_do_all');
?>