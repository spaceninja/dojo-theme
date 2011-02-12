<?php
/**
 * Footer template
 */
?>
			</div> <!-- /#content -->

			<?php get_sidebar(); ?>

		</div> <!-- /#main -->

		<hr />

		<footer id="footer" role="contentinfo">

			<?php
				// footer widget area
				get_sidebar( 'footer' );
			?>

			<?php
				// TODO: Make this load from the admin options page
				// load the admin options
				$dojo_options = get_option('dojo_theme_options');
			?>

			<?php if ( $dojo_options['footer_message'] ) : ?>
				<div id="footer-message">
					<?php
						print $dojo_options['footer_message'];
					?>
				</div>
			<?php endif; ?>

			<?php if ( $dojo_options['show_poweredby'] ) : ?>
				<p class="poweredby"><small>
					<?php bloginfo('name'); ?> is powered by 
					<a href="http://spaceninja.com/dojo/">Dojo</a>
					and <a href="http://wordpress.org/">WordPress</a>.
				</small></p>
			<?php endif; ?>

		</footer> <!-- /#footer -->

	</div> <!-- /#page -->

	<?php wp_footer(); // required for plugin support ?>

</body>
</html>