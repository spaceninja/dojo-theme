<?php
/**
 * Post and Page Navigation
 * Shared across all templates
 */
?>

<?php if (is_single()) : ?>

	<nav class="navigation">
		<ul>
			<?php previous_post_link( '<li class="prev"><small>Previously:</small> %link</li>' ); ?>
			<?php next_post_link('<li class="next"><small>Next:</small> %link</li>'); ?>
		</ul>
	</nav>

<?php

	else :
		$previous = get_next_posts_link('Older Entries');
		$next = get_previous_posts_link('Newer Entries');
?>

	<?php if ( $previous || $next ) : ?>
		<nav class="navigation">
			<ul>
				<?php
					if ( $previous ) {
						print '<li class="prev">' . $previous . '</li>';
					}
					if ( $next ) {
						print '<li class="next">' . $next . '</li>';
					}
				?>
			</ul>
		</nav>
	<?php endif; ?>

<?php endif; ?>