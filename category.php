<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<!-- template file: category.php -->

<h1 class="page-title"><?php printf( __( 'Archives for %s', 'twentyten' ), '<span>&#8220;' . single_cat_title( '', false ) . '&#8221;</span>' ); ?></h1>
<?php
	$category_description = category_description();
	if ( ! empty( $category_description ) )
		echo '<div class="archive-meta">' . $category_description . '</div>';
?>

<?php
	/* Run the loop for the category page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-category.php and that will be used instead.
	 */
	get_template_part( 'loop', 'category' );
?>

<?php get_footer(); ?>
