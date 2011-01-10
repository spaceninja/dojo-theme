<?php get_header(); ?>

<?php
	// Get custom theme options set in the admin area, or use the defaults
	global $dojomenu_options;
	foreach ($dojomenu_options as $value) {
		if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
	}
?>

<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="archive">Archives for &#8220;<?php single_cat_title(); ?>&#8221;</h1>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1 class="archive">Archives for &#8220;<?php single_tag_title(); ?>&#8221;</h1>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1 class="archive">Archives for <?php the_time('F jS, Y'); ?></h1>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="archive">Archives for <?php the_time('F, Y'); ?></h1>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1 class="archive">Archives for <?php the_time('Y'); ?></h1>
<?php /* If this is an author archive */ } elseif (is_author()) {
	if(get_query_var('author_name')) :
		$curauth = get_userdatabylogin(get_query_var('author_name'));
	else :
		$curauth = get_userdata(get_query_var('author'));
	endif; ?>
	<h1>Entries by <?php echo $curauth->display_name; ?></h1>
	<?php if($curauth->description) { echo "<p>" . $curauth->description . "</p>"; }; ?>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="archive">Archives</h1>
<?php } ?>

<?php $posts=query_posts($query_string . '&showposts=3'); ?>
<?php while (have_posts()) : the_post(); ?>

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
	<h2><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h2>
	<?php
		// Prepare the byline, which will be output either here or in the footer
		ob_start(); 
	?>
		<p class="byline"><small>
			<?php if ( $dojo_byline_in_title != 'true' ) { comments_popup_link('<strong>0</strong> Comments.', '<strong>1</strong> Comment.', '<strong>%</strong> Comments.', 'commentlink', 'Comments are off.'); } ?>
			Posted 
			by <?php the_author_posts_link(); ?>
			on <?php the_time('l'); ?>,
			<a href="<?php echo get_month_link("$arc_year", "$arc_month"); ?>"><?php the_time('F j'); ?></a>,
			<a href="<?php echo get_year_link("$arc_year"); ?>"><?php the_time('Y'); ?></a>
			at <?php the_time(); ?>.
			<?php if ( $dojo_byline_in_title == 'true' ) { comments_popup_link('<strong>0</strong> Comments.', '<strong>1</strong> Comment.', '<strong>%</strong> Comments.', 'commentlink', 'Comments are off.'); } ?>
			<?php edit_post_link('Edit this entry.'); ?>
		</small></p>
	<?
		$dojo_byline = ob_get_contents();
		ob_end_clean();	
	?>
	<?php
		// Show or hide the byline based on admin option.
		if ( $dojo_byline_in_title == 'true' ) { echo $dojo_byline; }
	?>
</div>

<div class="content">
	<p><?php the_excerpt_rss(); /* just like the_excerpt, but really strips all the HTML, including BR tags */ ?></p>
</div>

<div class="metadata">
	<?php
		// Show or hide the byline based on admin option.
		if ( $dojo_byline_in_title != 'true' ) { echo $dojo_byline; } 
		// Show or hide the categories based on admin option.
		if ( $dojo_disable_categories != 'true' ) {
			echo "<p class=\"folksonomy\"><small>Filed under ";
			the_category(', ');
			if (get_the_tags()) the_tags(', ',', ');
			echo ".</small></p>";
		} else {
			if (get_the_tags()) the_tags('<p class="folksonomy"><small>Filed under ',', ','.</small></p>');
		}
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

<?php get_footer(); ?>