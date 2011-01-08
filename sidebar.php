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
				<?php // In a perfect world, we would wrap popular tags in more and more EMs, but this will do for now. ?>
				<?php wp_tag_cloud('smallest=.75&largest=1.75&unit=em&format=list&number=20'); ?>
			</div><!-- end tag_cloud -->

			<?php if (function_exists('get_flickrRSS')) { ?>
				<div id="flickr-rss-dojo-version" class="widget widget_dojo_flickrRSS">
					<h4>Recent Photos</h4>
					<ul><?php
						$flickrRSS_settings = array(
							'html' => '<li><a href="%flickr_page%"><img src="%image_square%" alt="%title%"/></a></li>'
						);
						get_flickrRSS( $flickrRSS_settings );
					?></ul>
				</div><!-- end flickr -->
			<?php } ?>

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

			<?php if (function_exists('blc_latest_comments')) { ?>
				<div id="bryans-latest-comments-dojo-version" class="widget widget_dojo_blc_latest_comments">
					<h4>Recent Comments</h4>
					<ul><?php blc_latest_comments('5', '5', true, '<li>', '</li>', false); ?></ul>
				</div><!-- end recentcomments -->
			<?php } else {
				if (function_exists('widget_dojo_dashboard_recent_comments')) {
					$widget_settings = array(
						'name' => '',
						'before_widget' => '<div id="admin-recent-comments-dojo-version" class="widget widget_dojo_dashboard_recent_comments">',
						'after_widget' => '</div><!-- end recentcomments -->',
						'before_title' => '<h4>',
						'after_title' => '</h4>',
					);
					widget_dojo_dashboard_recent_comments( $widget_settings );
				}
			} ?>

			<div id="subscribe-dojo" class="widget widget_dojo_subscribe">
				<h4>Subscribe</h4>
				<p>Grab an Atom feed:</p>
				<ul class="rss">
					<li><a href="<?php bloginfo('atom_url'); ?>">Full Entries</a></li>
					<li><a href="<?php bloginfo('comments_atom_url'); ?>">All Comments</a></li>
					<?php
						// add comments feed on single-post pages
						if (is_single()) {
							while (have_posts()) : the_post();
								if ('open' == $post->comment_status) : /* If comments are open */
					?>
					<li><a href="<?php bloginfo('url'); ?>/index.php?feed=atom&amp;p=<?php the_ID(); ?>">Comments on &ldquo;<?php the_title(); ?>&rdquo;</a></li>
					<?php
								endif;
							endwhile;
							rewind_posts();
						// add category feed on category archives
						} else if (is_category()) {
							$category = get_the_category(); 
					?>
					<li><a href="<?php echo get_category_feed_link( $category[0]->cat_ID, 'atom' ); ?>">Posts in the &ldquo;<?php echo $category[0]->cat_name; ?>&rdquo; category</a></li>
					<?php
						// add tag feed on tag archives
						} else if (is_tag()) {
					?>
					<li><a href="<?php echo get_tag_feed_link( get_query_var('tag_id'), 'atom' ); ?>">Posts tagged with &ldquo;<?php single_tag_title(); ?>&rdquo;</a></li>
					<?php
						// add author feed on author pages
						} else if (is_author()) {
							if(isset($_GET['author_name'])) :
							$curauth = get_userdatabylogin($author_name);
							else :
							$curauth = get_userdata(intval($author));
							endif;
							$authorfeedlink = get_author_feed_link( $curauth->ID, 'atom' );
					?>
					<li><a href="<?php echo $authorfeedlink; ?>">Posts by <?php echo $curauth->display_name; ?></a></li>
					<?php
						}
					?>
				</ul>
			</div><!-- end subscribe -->

			<?php wp_list_bookmarks('title_before=<h4>&title_after=</h4>&category_before=<div id="%id" class="widget widget_links %class">&category_after=</div><!-- end linkcat -->'); ?>

		<?php endif; ?>
	</div> <!-- end column2 -->

</div> <!-- end sidebar -->