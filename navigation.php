<?php if (is_single()) : ?>

	<div class="navigation">
		<?php previous_post_link( '<div class="prev"><small>Previously:</small> %link</div>' ); ?>
		<?php next_post_link('<div class="next"><small>Next:</small> %link</div>'); ?>
	</div>

<?php
	else :
		$previous = get_next_posts_link('Older Entries');
		$next = get_previous_posts_link('Newer Entries');
?>

	<?php if( $previous || $next ) : ?>
		<div class="navigation">
			<?php
				if ( $previous ) {
					print '<div class="prev">' . $previous . '</div>';
				}
				if ( $next ) {
					print '<div class="next">' . $next . '</div>';
				}
			?>
		</div>
	<?php endif; ?>

<?php endif; ?>