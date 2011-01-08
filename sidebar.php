<?
// Count the posts on your blog
$numposts = $wpdb->get_var("SELECT COUNT(1) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type != 'page'");
if (0 < $numposts) $numposts = number_format($numposts); 

// Count the comments on your blog
$numcomms = $wpdb->get_var("SELECT COUNT(1) FROM $wpdb->comments WHERE comment_approved = '1'");
if (0 < $numcomms) $numcomms = number_format($numcomms);

// Get custom theme options set in the admin area, or use the defaults
global $dojomenu_options;
foreach ($dojomenu_options as $value) {
	if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); } }
?>
<hr />
<div id="sidebar">

<?php ?>

	<div id="columncap">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('columncap') ) : ?>
			<div id="about" class="widget widget_text">
				<?php // This is populated under "Dojo Options" in the admin area. ?>
				<h4><?php echo stripslashes($dojo_about_blurb_title); ?></h4>
				<p><?php echo stripslashes($dojo_about_blurb); ?></p>
			</div><!-- end about -->
		<?php endif; ?>
	</div><!-- end columncap -->
	
	<hr />

	<div id="column1">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('column1') ) : ?>

			<div id="search" class="widget widget_search">
				<h4>Search</h4>
				<?php get_search_form(); ?>
			</div><!-- end search -->

			<div id="pages" class="widget widget_pages">
				<h4>Pages</h4>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</div><!-- end pages -->

			<div id="tag_cloud" class="widget widget_tag_cloud">
				<h4>Popular Tags</h4>
				<?php wp_tag_cloud('smallest=.75&largest=1.75&unit=em&format=list&number=20'); ?>
			</div><!-- end tag_cloud -->

			<?php if (function_exists('widget_dojo_flickrRSS')) {
				// Dojo FlickrRSS widget
				$widget_settings = array(
					'before_widget' => '<div id="flickr-rss-dojo-version" class="widget widget_dojo_flickrRSS">',
					'after_widget' => '</div><!-- end widget -->',
					'before_title' => '<h4>',
					'after_title' => '</h4>',
				);
				widget_dojo_flickrRSS( $widget_settings );
			} ?>

			<div id="meta" class="widget widget_meta">
				<h4>Meta</h4>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><? echo "$numposts" ?> entries</li>
					<li><? echo "$numcomms" ?> comments</li>
					<?php wp_meta(); ?>
				</ul>
			</div><!-- end meta -->

		<?php endif; ?>
	</div> <!-- end column1 -->
	
	<hr />
	
	<div id="column2">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('column2') ) : ?>

			<?php if (function_exists('widget_dojo_blc_latest_comments')) {
				// if the Bryan's Latest Comments widget is available, then use it
				$widget_settings = array(
					'before_widget' => '<div id="recent-comments" class="widget widget_dojo_blc_latest_comments">',
					'after_widget' => '</div><!-- end widget -->',
					'before_title' => '<h4>',
					'after_title' => '</h4>',
				);
				widget_dojo_blc_latest_comments( $widget_settings );
			} else if (function_exists('widget_dojo_dashboard_recent_comments')) {
				// if not, then use the Dashboard Recent Comments widget
				$widget_settings = array(
					'before_widget' => '<div id="recent-comments" class="widget widget_dojo_dashboard_recent_comments">',
					'after_widget' => '</div><!-- end widget -->',
					'before_title' => '<h4>',
					'after_title' => '</h4>',
				);
				widget_dojo_dashboard_recent_comments( $widget_settings );
			} ?>

			<?php if (function_exists('widget_dojo_subscribe')) {
				// Dojo Subscribe widget
				$widget_settings = array(
					'before_widget' => '<div id="dojo-subscribe" class="widget widget_dojo_subscribe">',
					'after_widget' => '</div><!-- end widget -->',
					'before_title' => '<h4>',
					'after_title' => '</h4>',
				);
				widget_dojo_subscribe( $widget_settings );
			} ?>

			<?php
				// Linkroll
				$widget_settings = array(
					'category_before' => '<div id="%id" class="widget widget_links %class">',
					'category_after' => '</div><!-- end widget -->',
					'title_before' => '<h4>',
					'title_after' => '</h4>',
				);
				wp_list_bookmarks( $widget_settings );
			?>

		<?php endif; ?>
	</div> <!-- end column2 -->

</div> <!-- end sidebar -->