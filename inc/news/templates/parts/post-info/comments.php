<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<?php comments_number( '0 ' . esc_html__( 'Comments', 'coachfocus' ), '1 ' . esc_html__( 'Comment', 'coachfocus' ), '% ' . esc_html__( 'Comments', 'coachfocus' ) ); ?>
	</a><div class="qodef-info-separator-end"></div>
<?php } ?>
