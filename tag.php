<?php
/**
 * The template for displaying Tag Archive pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<!-- template file: tag.php -->

<h1 class="page-title"><?php printf( __( 'Archives for %s', 'twentyten' ), '<span>&#8220;' . single_tag_title( '', false ) . '&#8221;</span>' ); ?></h1>

<?php
	/* Run the loop for the tag archive to output the posts
	 * If you want to overload this in a child theme then include a file
	 * called loop-tag.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'tag' );
?>

<?php get_footer(); ?>
