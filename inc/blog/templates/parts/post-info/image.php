<?php if (has_post_thumbnail()) { ?>
	<div class="qodef-e-media-image">
		<?php if (!is_single()) { ?>
			<a itemprop="url" href="<?php the_permalink(); ?>">
			<?php } ?>
			<?php the_post_thumbnail('full'); ?>
			<?php if (!is_single()) { ?>
			</a>
		<?php } ?>
		<?php child_template_part('blog', 'templates/parts/post-info/date-on-image'); ?>
		<?php
		// Hook to include additional content after blog post featured image
		do_action('coachfocus_action_after_post_thumbnail_image');
		?>
	</div>
<?php } ?>