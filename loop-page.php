<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
	// use the new post_class() function if it's available - added in 2.7
	if (function_exists('post_class')) {
?>
	<div <?php post_class('entry'); ?> id="post-<?php the_ID(); ?>">
<?php } else { ?>
	<div class="entry" id="post-<?php the_ID(); ?>">
<?php } ?>

<div class="title">
	<h1><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h1>
</div>

<div class="content">
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
</div>

<?php edit_post_link('Edit this page.', '<div class="metadata"><p class="byline"><small>', '</small></p></div>'); ?>

</div><!-- end entry -->

<?php endwhile; else: ?>

<div class="error">
	<h1>Not Found</h1>
	<p>Sorry, we couldn't find the page you were looking for. Perhaps you'd like to search for it?</p>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>

<?php endif; ?>
