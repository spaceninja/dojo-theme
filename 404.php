<?php
/**
 * The template for displaying 404 pages (Not Found).
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<!-- template file: 404.php -->

<div id="post-0" class="post error404 not-found">
	<h1 class="entry-title"><?php _e( '404: Page Not Found', 'twentyten' ); ?></h1>
	<div class="entry-content">
		<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'twentyten' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</div><!-- #post-0 -->

<?php get_footer(); ?>