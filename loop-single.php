<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?
	// set the post date to variables for use in link functions below
	$arc_year = get_the_time('Y');
	$arc_month = get_the_time('m');
	$arc_day = get_the_time('d');
?>

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
	<p class="byline"><small>
		Posted 
		by <?php the_author_posts_link(); ?>
		on <?php the_time('l'); ?>,
		<a href="<?php echo get_month_link("$arc_year", "$arc_month"); ?>"><?php the_time('F j'); ?></a>,
		<a href="<?php echo get_year_link("$arc_year"); ?>"><?php the_time('Y'); ?></a>
		at <?php the_time(); ?>.
		<?php comments_popup_link('<strong>0</strong> Comments.', '<strong>1</strong> Comment.', '<strong>%</strong> Comments.', 'commentlink', 'Comments are off.'); ?>
		<?php edit_post_link('Edit this entry.'); ?>
	</small></p>
</div>

<div class="content">
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
</div>

<div class="metadata">
	<?php
		echo '<p class="folksonomy"><small>Filed under ';
		the_category(', ');
		if (get_the_tags()) the_tags(', ',', ');
		echo ".</small></p>";
	?>
</div>

</div><!-- end entry -->

<?php comments_template(); ?>

<hr />

<?php if ( function_exists('st_related_posts') ) { ?>
	<div class="related">
		<?php st_related_posts('&xformat=<a href="%post_permalink%">%post_title%</a>'); ?>
	</div>
<?php } ?>

<?php include_once("navigation.php"); ?>

<?php endwhile; else: ?>

<div class="error">
	<h1>Not Found</h1>
	<p>Sorry, we couldn't find the entry you were looking for. Perhaps you'd like to search for it?</p>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>

<?php endif; ?>