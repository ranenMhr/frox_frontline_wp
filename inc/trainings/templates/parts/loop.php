<?php

// Hook to include additional content before blog post item
do_action('coachfocus_action_before_blog_post_item');

if (have_posts()) {
	while (have_posts()) :
		the_post();

		// Include post item
		if (is_single()) {
			echo apply_filters('coachfocus_filter_blog_single_template', child_get_template_part('trainings', 'templates/parts/single/post', get_post_format())); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo apply_filters('coachfocus_filter_blog_list_post_template', child_get_template_part('trainings', 'templates/parts/list/post', get_post_format())); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	endwhile; // End of the loop.
} else {
	// Include global posts not found
	child_template_part('content', 'templates/parts/posts-not-found');
}

// Hook to include additional content after blog post item
do_action('coachfocus_action_after_blog_post_item');

wp_reset_postdata();
