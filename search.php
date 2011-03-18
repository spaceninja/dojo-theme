<?php
/**
 * The template for displaying Search Results pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<!-- template file: search.php -->

<?php if ( have_posts() ) : ?>
	<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>&#8220;' . get_search_query() . '&#8221;</span>' ); ?></h1>
	<?php
		/* Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called loop-search.php and that will be used instead.
		 */
		 get_template_part( 'loop', 'search' );
	?>
<?php else : ?>
	<div id="post-0" class="post no-results not-found">
		<h2 class="entry-title"><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
		<div class="entry-content">
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php get_footer(); ?>
