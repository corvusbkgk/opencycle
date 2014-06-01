<?php
global $url, $css_dir, $permalink;
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<div class=post-date-wrapper><span class=date><?php the_time(get_option("date_format")); ?></span><span class=time><?php the_time(); ?></span><br><?php
$days_str = get_post_meta(get_the_ID(),  'days', true); 
if ($days_str){
	echo "<span class=days>";
	$days=explode(',', $days_str);
	if (count($days)==1) {
		echo 'День '.$days[0];
	} else {
		echo 'Дни ';
		for ($i = 0; $i<count($days)-1; $i++) {
			if ($i != 0) echo ', ';
			echo $days[$i];
		}
		echo ' и '.$days[count($days)-1];
	}
	echo "</span>";
} 
?></div>
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?><?php edit_post_link( '<img src="'.$css_dir.'/images/file-edit.png" class="edit-icon" >', '<span class="edit-link">', '</span>' ); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php edit_post_link( '<img src="'.$css_dir.'/images/file-edit.png" class="edit-icon" >', '<span class="edit-link">', '</span>' ); ?>
			</h1>
			<?php endif; // is_single() ?>
			<div class=technical>Автор: <span class="author-name"><?php echo get_the_author_link(); ?></span></div>
			<?php the_post_thumbnail(); ?>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content('<p>Читать далее</p>'); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<?php if ( is_single() ) { 
        		oc_render_social();
		} ?>

		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->

<?php if (!is_single()) {
			echo "<div class=comments><a class=technical href=".get_permalink()."#comments style='margin-right: 40px;'>Комментарии (".get_comments_number().")</a><a class=technical href=".get_permalink()."#respond>Оставить комментарий</a></div>";
		} ?> 