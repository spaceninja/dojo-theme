<?php if (is_single()) : ?>

	<div class="navigation">
		<?php previous_post_link('<div class="prev"><small>Previously:</small> %link</div>') ?>
		<?php next_post_link('<div class="next"><small>Next:</small> %link</div>') ?>
	</div>

<?php else : ?>

	<div class="navigation">
		<div class="prev"><?php next_posts_link('Older Entries') ?></div>
		<div class="next"><?php previous_posts_link('Newer Entries') ?></div>
	</div>

<?php endif; ?>