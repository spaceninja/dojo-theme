<?
/**
 * Sidebar template
 * Three dynamic widget areas
 */

// Get custom theme options set in the admin area, or use the defaults
global $dojomenu_options;
foreach ($dojomenu_options as $value) {
	if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); } }

?>

<hr />
<aside id="sidebar1" class="sidebar" role="complimentary">
	<?php
		if ( ! dynamic_sidebar('sidebar1') ) :
		/**
		 * Default Sidebar Content
		 * What follows is some predefined sidebar content to be displayed 
		 * if the user hasn't set up any sidebar widgets.
		 */
	?>

	<section id="about" class="widget widget_text">
		<?php
			// About Blurb
			// TODO: Make this load from the admin options page
			// This is populated under "Dojo Options" in the admin area.
		?>
		<h4><?php echo stripslashes( $dojo_about_blurb_title ); ?></h4>
		<p><?php echo stripslashes( $dojo_about_blurb ); ?></p>
	</section><!-- end about -->

	<section id="search" class="widget widget_search">
		<h4>Search</h4>
		<?php get_search_form(); ?>
	</section><!-- end search -->

	<?php
		/**
		 * Recent Comments
		 * This will use the Bryan's Latest Comments plugin if available, 
		 * and then fall back to the included recent comments widget from 
		 * functions.php, which I copied from the WP admin dashboard.
		 */
		if ( function_exists( 'blc_latest_comments' ) ) : ?>
			<section id="bryans-latest-comments" class="widget widget_dojo_blc_latest_comments">
				<h4>Recent Comments</h4>
				<ul><?php blc_latest_comments( '5', '5', true, '<li>', '</li>', false ); ?></ul>
			</section><!-- end recent-comments -->
		<?php elseif ( function_exists( 'widget_dojo_dashboard_recent_comments' ) ) :
			$widget_settings = array(
				'name' => '',
				'before_widget' => '<section id="recent-comments" class="widget widget_dojo_dashboard_recent_comments">',
				'after_widget' => '</section><!-- end recent-comments -->',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
				);
			widget_dojo_dashboard_recent_comments( $widget_settings );
		endif; ?>

	<?php
		// Subscribe - from functions.php
		if ( function_exists( 'widget_dojo_subscribe' ) ) {
			$widget_settings = array(
				'before_widget' => '<section id="dojo-subscribe" class="widget widget_dojo_subscribe">',
				'after_widget' => '</section><!-- end subscribe -->',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			);
			widget_dojo_subscribe( $widget_settings );
		} ?>

	<?php
		// Linkroll
		$widget_settings = array(
			'category_before' => '<section id="%id" class="widget widget_links %class">',
			'category_after' => '</section><!-- end links -->',
			'title_before' => '<h4>',
			'title_after' => '</h4>',
		);
		wp_list_bookmarks( $widget_settings ); // added in 2.1
	?>

	<?php
		// Meta - login, register, post counts
		$posts_count = wp_count_posts(); // added in 2.5
		$comments_count = wp_count_comments(); // added in 2.5
		$total_posts = $posts_count->publish;
		$total_comments = $comments_count->approved;
	?>
	<section id="meta" class="widget widget_meta">
		<h4>Meta</h4>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><? echo "$total_posts" ?> entries</li>
			<li><? echo "$total_comments" ?> comments</li>
			<?php wp_meta(); ?>
		</ul>
	</section><!-- end meta -->

	<?php endif; // end dynamic sidebar section ?>
</aside> <!-- /#sidebar1 -->

<?php if ( is_active_sidebar( 'sidebar2' ) ) : ?>
	<hr />
	<aside id="sidebar2" class="sidebar" role="complimentary">
		<?php dynamic_sidebar( 'sidebar2' ); ?>
	</aside> <!-- /#sidebar2 -->
<?php endif; ?>

<?php if ( is_active_sidebar( 'sidebar3' ) ) : ?>
	<hr />
	<aside id="sidebar3" class="sidebar" role="complimentary">
		<?php dynamic_sidebar( 'sidebar3' ); ?>
	</aside> <!-- /#sidebar3 -->
<?php endif; ?>
