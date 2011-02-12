<?php
/**
 * Header template
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
		/**
		 * Build a dynamic page title
		 */

		// Add the page title
		wp_title( '-', true, 'right' );

		// Add the site name.
		bloginfo( 'name' );

		// Add the site description for the home/front page.
		// is_front_page - added in 2.5
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_front_page() ) ) {
			print " - $site_description";
		}

		// Add a page number if necessary:
		global $page, $paged;
		if ( $paged >= 2 || $page >= 2 ) {
			print ' - ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
		}

	?></title>
	<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Full Posts" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Comments" href="<?php bloginfo('comments_atom_url'); ?>" />
	<?php

		/**
		 * Add extra feeds on appropriate pages
		 * 
		 * get_post_comments_feed_link - added in 2.2
		 * get_category_feed_link - added in 2.5
		 * get_tag_feed_link - added in 2.5
		 * get_author_feed_link - added in 2.5
		 */

		if (is_single()) {
			// add comments feed on single-post pages
			print '<link rel="alternate" type="application/atom+xml" title="Comments on ' . $wp_query->queried_object->post_title . '" href="' . get_post_comments_feed_link( $wp_query->queried_object->ID, 'atom' ) . '" />';

		} elseif (is_category()) {
			// add category feed on category archives
			print '<link rel="alternate" type="application/atom+xml" title="Posts in the ' . $wp_query->queried_object->name . ' category" href="' . get_category_feed_link( $wp_query->queried_object->term_id, 'atom' ) . '" />';

		} elseif (is_tag()) {
			// add tag feed on tag archives
			print '<link rel="alternate" type="application/atom+xml" title="Posts tagged with ' . $wp_query->queried_object->name . '" href="' . get_tag_feed_link( $wp_query->queried_object->term_id, 'atom' ) . '" />';

		} elseif (is_author()) {
			// add author feed on author pages
			print '<link rel="alternate" type="application/atom+xml" title="Posts by ' . $wp_query->queried_object->display_name . '" href="' . get_author_feed_link( $wp_query->queried_object->ID, 'atom' ) . '" />';
		}

		// threaded comment support - added in 2.7
		// ref: http://codex.wordpress.org/Migrating_Plugins_and_Themes_to_2.7/Enhanced_Comment_Display
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		// required for plugin support
		wp_head();

	?>
</head>
<?php
  /**
   * To get a dynamic layout, we're adding a new class to body, depending on 
   * the number of sidebars that are active. This allows the user to switch 
   * between three different layouts just by moving widgets around.
   */

	// get the number of active sidebars
	// is_active_sidebar - added in 2.8
	$sidebar_count = 1; // sidebar1 is always active
	if ( is_active_sidebar( 'sidebar2' ) ) {
		$sidebar_count++;
	}
	if ( is_active_sidebar( 'sidebar3' ) ) {
		$sidebar_count++;
	}
	
	// set our class name to add later
	$sidebar_class = 'one-sidebar';
	if ( $sidebar_count == 2 ) {
		$sidebar_class = 'two-sidebars';
	} elseif ( $sidebar_count == 3 ) {
		$sidebar_class = 'three-sidebars';
	}

?>
<body <?php if ( function_exists( 'body_class' ) ) { body_class( $sidebar_class ); } // added in 2.8 ?>>

	<div id="page">

		<header id="header" role="banner">

			<?php if ( function_exists( 'home_url' ) ) : // added in 3.0 ?>
				<h1 id="blogname"><a href="<?php print home_url( '/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<h1 id="blogname"><a href="<?php bloginfo('url'); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php endif; ?>

			<?php if ( get_bloginfo( 'description' ) ) : // do we have a description? ?>
				<p id="tagline"><em><?php bloginfo( 'description' ); ?></em></p>
			<?php endif; ?>

			<p id="skip-link"><em><a href="#content"><?php  _e( 'Skip to content', 'dojo' ); ?></a></em> &darr;</p>

			<?php if ( function_exists( 'wp_nav_menu' ) ) : // added in 3.0 ?>
				<hr />

				<nav id="navigation" role="navigation">
					<?php

						/**
						 * Our navigation menu.  If one isn't filled out, wp_nav_menu 
						 * falls back to wp_page_menu.  The menu assiged to the primary 
						 * position is the one used.  If none is assigned, the menu with 
						 * the lowest ID is used.
						 */

						wp_nav_menu( array( 'theme_location' => 'primary' ) );

					?>
				</nav> <!-- /#main-menu -->
			<?php endif; ?>

		</header> <!-- /#header -->

		<hr />

		<div id="main">

			<div id="content">