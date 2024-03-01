<div class="qodef-e-media">
	<?php
	switch (get_post_format()) {
		case 'gallery':
			child_template_part('blog', 'templates/parts/post-format/gallery');
			break;
		case 'video':
			child_template_part('blog', 'templates/parts/post-format/video');
			break;
		case 'audio':
			child_template_part('blog', 'templates/parts/post-format/audio');
			break;
		default:
			child_template_part('blog', 'templates/parts/post-info/image');
			break;
	}
	?>
</div>