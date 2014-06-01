<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $permalink, $wp_query;
get_header(); ?>
		<?php if ( have_posts() ) { 
		 /* Start the Loop */ 
				while ( have_posts() ) : the_post(); 
					get_template_part( 'content', get_post_format() ); 
				endwhile; 

	if ($wp_query->max_num_pages > 1) {
		global $permalink;
		$unpaged_link = preg_replace('/\\/page\\/[0-9]+\\//', '', $permalink, -1 );
		$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
				echo '<div class=post>';
		oc_paginate($unpaged_link, $wp_query->max_num_pages, $current_page);
				echo '</div>';
	}
		
}
 get_footer(); ?>