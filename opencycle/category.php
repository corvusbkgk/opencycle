<?php
global $css_dir;
get_header(); ?>
		<?php if ( have_posts() ) { 
		 /* Start the Loop */ 
				while ( have_posts() ) : the_post(); 
					get_template_part( 'content', get_post_format() ); 
				endwhile; 
		} else {
			echo '<div class=post><h1>Ничего не найдено</h1>
    <img class=wp-post-image src="'.$css_dir.'/images/emptiness.jpg"> <p>К сожалению, в данной категории постов пока нет.</p></div>';
		}
 get_footer(); ?>