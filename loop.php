<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<?php
if ( is_home() ) {
	$is_home = 1;
} else {
	$is_home = 0;
	// show 25 posts per page on archive pages
	query_posts( 'posts_per_page=25' );
}
?>

<?php
	if (have_posts()) :
	while (have_posts()) : the_post();
?>

<?php
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
	<h2><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h2>
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
	<?php if ( $is_home ): ?>
		<?php the_content('<p class="more">Keep reading...</p>'); ?>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	<?php else: ?>
		<p><?php the_excerpt_rss(); /* just like the_excerpt, but really strips all the HTML, including BR tags */ ?></p>
	<?php endif; ?>
</div>

<div class="metadata">
	<?php
		echo "<p class=\"folksonomy\"><small>Filed under ";
		the_category(', ');
		if (get_the_tags()) the_tags(', ',', ');
		echo ".</small></p>";
	?>
</div>

</div><!-- end entry -->

<hr />

<?php endwhile; ?>

<?php include_once("navigation.php"); ?>

<?php else: ?>

<div class="error">
	<h1>Not Found</h1>
	<p>Sorry, we couldn't find the content you were looking for. Perhaps you'd like to search for it?</p>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>

<?php endif; ?>
