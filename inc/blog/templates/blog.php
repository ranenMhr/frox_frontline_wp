<main id="qodef-page-content" class="qodef-grid qodef-layout--template qodef-gutter--huge" role="main">
	<div class="qodef-grid-inner clear">
		<div class="qodef-grid-item qodef-page-content-section qodef-col--9">
			<?php
			// Hook to include additional content before blog loop
			do_action('coachfocus_action_before_blog_loop');
			?>
			<div class="qodef-blog qodef-m <?php echo esc_attr(coachfocus_get_blog_holder_classes()); ?>">
				<?php
				// Include posts loop
				child_template_part('blog', 'templates/parts/loop');

				if (!is_single()) {
					// Include pagination
					child_template_part('pagination', 'templates/pagination-wp');
				}
				?>
			</div>
		</div>
		<div class="qodef-grid-item qodef-page-sidebar-section qodef-col--3">
			<aside id="qodef-page-sidebar" role="complementary">
				<?php dynamic_sidebar(coachfocus_get_sidebar_name()); ?>
			</aside>
		</div>
	</div>
</main>