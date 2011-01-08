<?php
if ( function_exists('register_sidebar') ) {
	// have to register the sidebars separately so I can name them uniquely - SV
	register_sidebar( array(
		'name' => 'column1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><!-- end widget -->',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar( array(
		'name' => 'column2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><!-- end widget -->',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar( array(
		'name' => 'columncap',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><!-- end widget -->',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}

// Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'feed_links', 2 );

/*
	Custom Threaded Comments code to be used with wp_list_comments
*/
function dojo_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<p class="title comment-author vcard">
				<?php echo get_avatar($comment,$size='48' ); ?>
				<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			</p>
			<?php if ($comment->comment_approved == '0') : // If comment is not approved ?>
				<p class="alert"><em><?php _e('Your comment is awaiting moderation.') ?></em></p>
			<?php endif; ?>
			<div class="content">
				<?php comment_text() ?>
			</div>
			<p class="metadata comment-meta commentmetadata"><small>
				Posted on <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>.
				<?php comment_reply_link(array_merge( $args, array('reply_text' => '(Reply)', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				<?php edit_comment_link(__('(Edit)'),'  ','') ?>
			</small></p>
		</div>
	<?php
}

/*
	Recent Comments Widget from the WP 2.5.1 admin dashboard
	Modified from original code in wp-admin/includes/dashboard.php
*/
function widget_dojo_dashboard_recent_comments( $args ) {
	global $comment;
	extract( $args );
	echo "\n$before_widget\n";
	echo $before_title . "Recent Comments" . $after_title . "\n";
	$lambda = create_function( '', 'return 6;' );
	add_filter( 'option_posts_per_rss', $lambda ); // hack - comments query doesn't accept per_page parameter
	$comments_query = new WP_Query('feed=rss2&withcomments=1');
	remove_filter( 'option_posts_per_rss', $lambda );
	$is_first = true;
	if ( $comments_query->have_comments() ) {
		while ( $comments_query->have_comments() ) { $comments_query->the_comment();
			$comment_post_url = get_permalink( $comment->comment_post_ID );
			$comment_post_title = get_the_title( $comment->comment_post_ID );
			$comment_post_link = "<a href='$comment_post_url'>$comment_post_title</a>";
			$comment_meta = sprintf( '<cite><a href="' . get_comment_link() . '">%1$s</a></cite> on %2$s', get_comment_author(), $comment_post_link );
			if ( $is_first ) : $is_first = false; ?>
				<blockquote>
					<p>&#8220;<?php comment_excerpt(); ?>&#8221;
					<br /><small>&#8212; <?php echo $comment_meta; ?></small></p>
				</blockquote>
				<?php if ( $comments_query->comment_count > 1 ) : ?>
				<ul>
				<?php endif; // comment_count
			else : // is_first ?>
					<li><?php echo $comment_meta; ?></li>
			<?php endif; // is_first
		}
		if ( $comments_query->comment_count > 1 ) : ?>
				</ul>
		<?php endif; // comment_count;
	}
	echo "$after_widget\n";
}
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget('Admin Recent Comments (dojo version)', 'widget_dojo_dashboard_recent_comments');

/*
	Bryan's Latest Comments Widget v1.5.8
*/
if (function_exists('blc_latest_comments')) {
	function widget_dojo_blc_latest_comments( $args ) {
		extract( $args );
		echo "\n$before_widget\n";
		echo $before_title . "Recent Comments" . $after_title . "\n";
		echo "<ul>" . blc_latest_comments('5', '5', true, '<li>', '</li>', false) . "</ul>\n";
		echo "$after_widget\n";
	}
	if ( function_exists('register_sidebar_widget') )
		register_sidebar_widget('Bryan\'s Latest Comments (dojo version)', 'widget_dojo_blc_latest_comments');
}

/*
	FlickrRSS Widget v4.0
	These settings overrule the ones set in the admin area.
*/
if (function_exists('get_flickrRSS')) {
	function widget_dojo_flickrRSS( $args ) {
		extract( $args );
		echo "\n$before_widget\n";
		echo $before_title . "Recent Photos" . $after_title . "\n";
		// load the options from the database so we can specify proper markup
		$flickrRSS_display_numitems = get_option('flickrRSS_display_numitems');
		$flickrRSS_display_type = get_option('flickrRSS_display_type');
		$flickrRSS_tags = get_option('flickrRSS_tags');
		$flickrRSS_display_imagesize = get_option('flickrRSS_display_imagesize');
		echo "<ul>";
		get_flickrRSS($flickrRSS_display_numitems, $flickrRSS_display_type, $flickrRSS_tags, $flickrRSS_display_imagesize, '<li>', '</li>');
		echo "</ul>\n";
		echo "$after_widget\n";
	}
	if ( function_exists('register_sidebar_widget') )
		register_sidebar_widget('Flickr RSS (dojo version)', 'widget_dojo_flickrRSS');
}

/*
	Subscribe Widget
	Uses atom feeds - to use RSS2, just change 'atom' to 'rss2'.
*/
function widget_dojo_subscribe( $args ) {
	global $post;
	extract( $args );
	echo "\n$before_widget\n";
	echo $before_title . "Subscribe" . $after_title . "\n"; ?>
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
	<?php echo "$after_widget\n";
}
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget('Subscribe (dojo)', 'widget_dojo_subscribe');

/*
	Add Dojo Theme Admin Page
	Based on code from: http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/
*/
$dojomenu_themename = "Dojo";
$dojomenu_shortname = "dojo";
$dojomenu_options = array (
	array( "name" => "About Blurb Title",
		"id" => $dojomenu_shortname."_about_blurb_title",
		"type" => "text",
		"std" => "About This Site",
		"how" => "No HTML, please! This will be wrapped in an <code>H4</code> tag."),
	array( "name" => "About Blurb",
		"id" => $dojomenu_shortname."_about_blurb",
		"type" => "textarea",
		"std" => "To customize this about blurb, log into the admin area, and go to the \"Dojo Options\" page in the Design section. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
		"how" => "HTML is allowed, but be careful that you don't break your layout with bad code. This will be wrapped in a <code>P</code> tag."),
	array( "name" => "Use Custom Styles",
		"id" => $dojomenu_shortname."_use_custom_styles",
		"type" => "checkbox",
		"std" => "false",
		"how" => "Load the custom stylesheets in addition to the default ones."),
	array( "name" => "Show Byline by Title",
		"id" => $dojomenu_shortname."_byline_in_title",
		"type" => "checkbox",
		"std" => "false",
		"how" => "Put the byline with the author name and date by the post title instead of at the bottom."),
	array( "name" => "Disable Categories",
		"id" => $dojomenu_shortname."_disable_categories",
		"type" => "checkbox",
		"std" => "false",
		"how" => "Hide categories and just display tags."),
	array( "name" => "Use Custom Copyright",
		"id" => $dojomenu_shortname."_use_custom_copyright",
		"type" => "checkbox",
		"std" => "false",
		"how" => "Replace the default copyright statement with the custom one."),
	array( "name" => "Custom Copyright",
		"id" => $dojomenu_shortname."_custom_copyright",
		"type" => "text",
		"std" => "This weblog is licensed under a <a href='http://creativecommons.org/licenses/by-nc-nd/3.0/'>Creative Commons License</a>.",
		"how" => "This will be wrapped in a <code>P</code> tag.")
);
function mytheme_add_admin() {
	global $dojomenu_themename, $dojomenu_shortname, $dojomenu_options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($dojomenu_options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
			foreach ($dojomenu_options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($dojomenu_options as $value) {
				delete_option( $value['id'] ); }
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}
	add_theme_page($dojomenu_themename." Options", "$dojomenu_themename Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
	global $dojomenu_themename, $dojomenu_shortname, $dojomenu_options;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$dojomenu_themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$dojomenu_themename.' settings reset.</strong></p></div>';
	?>
	<div class="wrap">
		<h2><?php echo $dojomenu_themename; ?> Options</h2>
		<form method="post">
			<table class="form-table">
			<?php foreach ($dojomenu_options as $value) {
				switch ( $value['type'] ) {
					case 'text': ?>
						<tr valign="top"> 
							<th scope="row"><?php echo $value['name']; ?>:</th>
							<td>
								<input name="<?php echo $value['id']; ?>" size="40" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes( str_replace( "\"", "'", get_option ( $value['id'] ) ) ); } else { echo stripslashes($value['std'] ); } ?>" />
								<small><?php echo $value['how']; ?></small>
							</td>
						</tr>
					<? break;
					case 'textarea': ?>
						<tr valign="top"> 
							<th scope="row"><?php echo $value['name']; ?>:</th>
							<td>
								<p>
									<textarea name="<?php echo $value['id']; ?>" cols="60" rows="10" id="<?php echo $value['id']; ?>" style="width: 98%; font-size: 12px;" class="code"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes( get_option ( $value['id'] ) ); } else { echo stripslashes($value['std'] ); } ?></textarea>
									<br /><small><?php echo $value['how']; ?></small>
								</p>
							</td>
						</tr>
					<? break;
					case 'select': ?>
						<tr valign="top"> 
							<th scope="row"><?php echo $value['name']; ?>:</th>
							<td>
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
									<?php foreach ($value['options'] as $option) { ?>
										<option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
					<? break;
					case 'radio': ?>
						<tr valign="top">
							<th scope="row"><?php echo $value['name']; ?>:</th>
							<td>
								<?php foreach ( $value['options'] as $key=>$option ) {
									$radio_setting = get_settings($value['id']);
									if ( $radio_setting != "" ) {
										if ( $key == get_settings( $value['id'] ) ) {
											$checked = 'checked="checked"';
										} else {
											$checked = "";
										}
									} else {
										if ( $key == $value['std'] ) {
											$checked = 'checked="checked"';
										} else {
											$checked = "";
										}
									} ?>
									<input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /> <?php echo $option; ?>
								<?php } ?>
							</td>
						</tr>
					<? break;
					case 'checkbox': ?>
						<tr valign="top">
							<th scope="row"><?php echo $value['name']; ?>:</th>
							<td>
								<?php if( get_settings( $value['id'] ) ) {
									$checked = 'checked="checked"';
								} else {
									$checked = "";
								} ?>
								<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
								<small><?php echo $value['how']; ?></small>
							</td>
						</tr>
					<? break;
					default:
					break;
				}
			} ?>
			</table>
			<p class="submit">
				<input name="save" type="submit" value="Save changes" />
				<input type="hidden" name="action" value="save" />
			</p>
		</form>
		<form method="post">
			<p class="submit">
				<input name="reset" type="submit" value="Reset all Options" />
				<input type="hidden" name="action" value="reset" />
			</p>
			<p>To uninstall Dojo, use the "Reset all Options" button. That will remove all Dojo options from your database. Then you can switch to a different theme.</p>
		</form>
	</div>
<?php }
add_action('admin_menu', 'mytheme_add_admin');

?>