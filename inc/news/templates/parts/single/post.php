<article <?php post_class('qodef-blog-item qodef-e'); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		child_template_part('news', 'templates/parts/post-info/media');
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					if (!has_post_thumbnail()) {
						child_template_part('news', 'templates/parts/post-info/date');
					}

					// Include post category info
					child_template_part('news', 'templates/parts/post-info/categories');
					?>
				</div>
			</div>
			<div class="qodef-e-text news-wrapper">
				<?php
				// Include post title
				child_template_part('news', 'templates/parts/post-info/title');

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action('coachfocus_action_after_blog_single_content');
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-tags">
					<?php
					// Include post tags info
					child_template_part('news', 'templates/parts/post-info/tags');
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include social share
					if (coachfocus_is_installed('core')) {
						coachfocus_core_template_part('blog/shortcodes/blog-list', 'templates/post-info/social-share');
					}
					?>
				</div>
			</div>
		</div>
	</div>
</article>