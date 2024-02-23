<?php if ( ! post_password_required() ) { ?>
	<div class="qodef-e-read-more">
		<?php
		if ( coachfocus_post_has_read_more() ) {
			$button_params = array(
				'button_layout' => 'circle',
				'link'          => get_permalink() . '#more-' . get_the_ID(),
				'text'          => esc_html__( 'Read More', 'coachfocus' ),
			);
		} else {
			$button_params = array(
				'button_layout' => 'circle',
				'link'          => get_the_permalink(),
				'text'          => esc_html__( 'Read More', 'coachfocus' ),
			);
		}

		coachfocus_render_button_element( $button_params );
		?>
	</div>
<?php } ?>
