</div> <!-- end content -->

<?php get_sidebar(); ?>

</div> <!-- end wrapper -->

<hr />

<div id="footer">
	<?php
		// Get custom theme options set in the admin area, or use the defaults
		global $dojomenu_options;
		foreach ($dojomenu_options as $value) {
			if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
		}
		// Display either the custom copyright statement or the default one
		if ( $dojo_use_custom_copyright == 'true' ) { ?>
			<p class="copyright"><small><?php echo stripslashes($dojo_custom_copyright); ?></small></p>
		<?php } else { ?>
			<p class="copyright"><small>&copy; Copyright <?php echo date('Y'); ?>, all rights reserved</small></p>
		<?php }
	?>
	<p class="poweredby"><small>
		<?php bloginfo('name'); ?> is powered by 
		<a href="http://spaceninja.com/dojo/">Dojo</a>
		and <a href="http://wordpress.org/">WordPress</a> <?php bloginfo('version'); ?>.
	</small></p>
</div> <!-- end footer -->

</div> <!-- end page -->

<?php wp_footer(); ?>
</body>
</html>