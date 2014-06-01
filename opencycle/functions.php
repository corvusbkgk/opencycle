<?php 
	add_theme_support( 'post-thumbnails' );
	add_post_type_support( 'page', 'excerpt' );
if (user_can('edit_posts', false)) {
	show_admin_bar(false);
}

add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
	
add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

	$css_dir = get_bloginfo('template_url');
	$url = get_bloginfo('url');
	if( is_page() ) { 
		global $post;
        /* Get an array of Ancestors and Parents if they exist */
		$parents = get_post_ancestors( $post->ID );
        /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
		$parent_id = ($parents) ? $parents[count($parents)-1]: $post->ID;
	}
function current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

	$permalink = current_page_url();
	

add_filter('comment_form_default_fields','custom_fields');
add_filter( 'pre_comment_on_post', 'verify_comment_data' );
add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );

function additional_fields () {
		echo '<input id="bot" name="bot" type="hidden" value="" size="30"  tabindex="3" /><script>$(document).ready(function(){$("#comment").focus(function(){$("#bot").val("wrong!")})});</script>';
}
function custom_fields($fields) {

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$fields[ 'author' ] = '<p class="comment-form-item">'.
			'<label for="author">' . __( 'Name' ) . '</label>'.
			( $req ? '<span class="required">*</span>' : '' ).
			'<input id="author" name="author" type="text" value="'. esc_attr( $commenter['comment_author'] ) . 
			'" size="30" tabindex="1"' . $aria_req . ' /></p>';
		
		$fields[ 'email' ] = '<input id="email" name="email" type="hidden" value="" size="30"  tabindex="2"' . $aria_req . ' />';
					
		$fields[ 'url' ] = '<input id="url" name="url" type="hidden" value="" size="30"  tabindex="3" />';
		
		
		//ABTU = anti bot true url =)
			
		$fields[ 'abte' ] = '<p class="comment-form-item">'.
			'<label for="abte">' . __( 'Email' ) . '</label>'.
			( $req ? '<span class="required">*</span>' : '' ).
			'<input id="abte" name="abte" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) . 
			'" size="30"  tabindex="2"' . $aria_req . ' /></p>';
					
		$fields[ 'abtu' ] = '<p class="comment-form-item">'.
			'<label for="abtu">' . __( 'Website' ) . '</label>'.
			'<input id="abtu" name="abtu" type="text" value="'. esc_attr( $commenter['comment_author_url'] ) . 
			'" size="30"  tabindex="3" /></p>';

	return $fields;
}

function verify_comment_data(  $comment_post_ID ) {
	if ( (isset($_POST['url']) && $_POST['url']) || (isset($_POST['email']) && $_POST['email']) ){
		wp_die(  '<b>ERROR</b> You are a spamming bot. That is bad, I hate you.'  );
	}
	if (!isset($_POST['bot'])){
		wp_die(  '<b>ERROR</b> You are a spamming bot. That is bad, I hate you.'  );
	}
	if ( (isset($_POST['bot']) && !$_POST['bot']) ){
		wp_die(  '<b>ОШИБКА</b> Ваш браузер не поддерживает Javascript, разрешите его использование или смените браузер и попробуйте снова.'  );
	}
	if (isset($_POST['abtu'])) { $_POST['url']  = $_POST['abtu']; unset($_POST['abtu']);}
	if (isset($_POST['abte'])) {$_POST['email'] = $_POST['abte']; unset($_POST['abte']);}
	return  $comment_post_ID;
}
	
function register_menus() {
  register_nav_menus(
  		array('main-menu'=> 'Главное меню'));
}
add_action( 'init', 'register_menus' );

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

function oc_render_social(){
	global $permalink;
	$link=get_permalink();
	if (!$link){
		$link = $permalink;
	}
	echo '<div style="clear: both; margin-top: 15px;"><div class="fb-like" data-href="'.$link.'" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-font="verdana" style="float:left; margin-right: 20px;"></div>';
	echo '<div style="float:left; margin-right: 20px;"><script type="text/javascript"><!--
document.write(VK.Share.button("'.$link.'",{type: "round", text: "Поделиться"}));
--></script></div>';
?><div style="float:left;"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $link; ?>" data-lang="ru">Твитнуть</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div></div><div style="clear:both;"></div>
<?php
}

function oc_paginate_by_url ($url) {
	$arr = explode ('/page/', $url);
	if ($arr[1]) {
		$tmp = explode('/', $arr[1]);
	}
}

function oc_paginate ($base_url, $max_pages, $current_page){
	if ($base_url[strlen($base_url)-1]=='/') {
		$base_url = substr($base_url, 0, -1);
	}
	echo '<div class=pagination><b>Страницы</b><span class="spacer">&nbsp;</span>';
	if ($current_page != 1) {
		echo "<a href='$base_url/page/".($current_page-1)."/' class='link gray'>предыдущая</a>";
	} else {
		echo "<span class='link gray'>предыдущая</span>";
	}
	if ($current_page > 3) {
		echo "<a href='$base_url/page/1/' class='link'>1</a>";
		if ($current_page != 4) {
			echo "<span class='link'>...</span>";
		}
	}
	$p_start = ($current_page-2>0?$current_page-2:1);
	for ($j=0; $j<5; $j++){
		if($p_start+$j <= $max_pages){
			if ($p_start+$j != $current_page){
				echo "<a href='$base_url/page/".($p_start+$j)."/' class='link'>".($p_start+$j)."</a>";
			} else {
				echo "<span class='link'>".$current_page."</span>";
			}
		}
	}
	if ($current_page < $max_pages-3) {
		if ($current_page != $max_pages-4) {
			echo "<span class='link'>...</span>";
		}
		echo "<a href='$base_url/page/".$max_pages."/' class='link'>".$max_pages."</a>";
	}
	if ($current_page != $max_pages) {
		echo "<a href='$base_url/page/".($current_page+1)."/' class='link gray'>следующая</a>";
	} else {
		echo "<span class='link gray'>следующая</span>";
	}
	echo '</div>';
}


?>