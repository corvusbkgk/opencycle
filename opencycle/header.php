<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 
global $url, $css_dir, $permalink;
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="<?php if ( is_single() ) {
        the_post(); echo get_the_excerpt(); rewind_posts();
    } else {
        bloginfo('name'); echo " - "; bloginfo('description');
    }
    ?>" />
<title><?php bloginfo('name'); wp_title(':', true); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic&subset=cyrillic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=cyrillic' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="<?php echo $css_dir; ?>/style.css">
    <script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
    <script type="text/javascript" src="<?php echo $css_dir; ?>/js/common.js" charset="windows-1251"></script>
</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<div id="header">
        <?php wp_nav_menu( array( 'container_class' => 'header-menu', 'theme_location' => 'main-menu' ) ); ?>
    
        <a href="<?php echo $url; ?>"><img src="<?php echo $css_dir; ?>/images/logo-with-text-dark.png" height="70" id="header-logo"></a>
    </div>
    <div id=header-slider>
    </div>
    <div class="header-shadow">
    	&nbsp;
    </div>
	<div id="main" class="wrapper">
    <aside id="social-sidebar">
	<a href="http://vk.com/opencycle" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/vk.png"></a>
	<a href="http://www.facebook.com/oce2013" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/fb.png"></a>
	<a href="http://opencycle.livejournal.com/" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/lj2.png"></a>
	<a href="<?php echo $url; ?>/feed" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/rss.png"></a>
	<a href="https://twitter.com/opencycle_ru" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/twi.png"></a>
	<a href="http://www.youtube.com/channel/UCVjLoGEIhJf_HRwEwdz_7CQ" target="_blank"><img class="logo grayscale" src="<?php echo $css_dir; ?>/images/icons/yt.png"></a>
    </aside>