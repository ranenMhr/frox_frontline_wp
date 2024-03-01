<div class="widget widget_block widget_search">
    <?php
    // Unique ID for search form fields
    $qodef_unique_id = uniqid('qodef-search-form-');
    ?>
    <form role="search" method="get" class="qodef-search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label for="<?php echo esc_attr($qodef_unique_id); ?>" class="screen-reader-text"><?php esc_html_e('Search for:', 'coachfocus'); ?></label>
        <div class="qodef-search-form-inner clear">
            <input type="search" id="<?php echo esc_attr($qodef_unique_id); ?>" class="qodef-search-form-field" value="" name="s" placeholder="<?php esc_attr_e('Search', 'coachfocus'); ?>" />
            <button type="submit" class="qodef-search-form-button qodef--button-inside qodef--has-icon"><?php coachfocus_render_svg_icon('search'); ?></button>
        </div>
    </form>
</div>
<div class="qodef-separator" style="margin-top: 40px;"></div>
<div class="widget widget_coachfocus_core_simple_event_list">
    <div class="widget widget_coachfocus_core_title_widget">
        <h4 class="qodef-widget-title">Related Links</h4>
    </div>
    <?php
    $today = date('Y-m-d');

    $args = array(
        'post_type'      => 'consultings',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'post__not_in'   => array(get_the_ID()),
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) : ?>
        <ul class="wp-block-event-list wp-block-event sidebar-list-wrapper">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <li class="cat-item">
                    <a href="<?php echo the_permalink() ?>">
                        <?php echo the_title(); ?>
                    </a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
            ?>
        </ul>
    <?php
    else :
        echo 'No posts found.';
    endif;
    ?>

    <?php wp_reset_postdata(); ?>
</div>