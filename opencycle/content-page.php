<?php
global $url, $css_dir, $permalink;
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_page() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?><?php edit_post_link( '<img src="'.$css_dir.'/images/file-edit.png" class="edit-icon" >', '<span class="edit-link">', '</span>' ); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<h1><?php the_permalink(); ?>"><?php the_title(); ?></a><?php edit_post_link( '<img src="'.$css_dir.'/images/file-edit.png" class="edit-icon" >', '<span class="edit-link">', '</span>' ); ?></h1>
			</h1>
			<?php endif; // is_single() ?>
			<?php the_post_thumbnail(); ?>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content('Читать далее'); ?>
			<?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<?php if ( is_page() ) : 
        	oc_render_social();
		 endif; // is_single() ?>

		<footer class="entry-meta">
			
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
