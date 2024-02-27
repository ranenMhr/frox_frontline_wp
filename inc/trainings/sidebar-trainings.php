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
<div class="widget widget_block widget_types">
    <div class="widget widget_coachfocus_core_title_widget">
        <h4 class="qodef-widget-title">Training Type</h4>
    </div>
    <?php
    $terms = get_terms(array(
        'taxonomy' => 'trainings-category',
        'parent'   => 0,
        'orderby'    => 'title',
    ));
    ?>
    <ul class="wp-block-categories-list wp-block-categories sidebar-list-wrapper">
        <?php foreach ($terms as $term_value) { ?>
            <li class="cat-item"><a href="<?php echo esc_url(get_term_link($term_value->term_id)); ?>"><?php echo esc_html($term_value->name); ?></a>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="qodef-separator" style="margin-top: 40px;"></div>
<div class="widget widget_coachfocus_core_simple_event_list">
    <div class="widget widget_coachfocus_core_title_widget">
        <h4 class="qodef-widget-title">More Trainings</h4>
    </div>
    <ul class="wp-block-event-list wp-block-event sidebar-list-wrapper">
        <?php
        $today = date('Y-m-d');
        $post_terms = wp_get_post_terms(get_the_ID(), 'event-types', ['fields' => 'slugs']);

        $args_with_term = array(
            'post_type'      => 'trainings',
            'posts_per_page' => 6,
            'orderby'        => 'taxonomy',
            'order'          => 'ASC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'trainings-category',
                    'field'    => 'slug',
                    'terms'    => $post_terms,
                ),
            ),
            'post__not_in'   => array(get_the_ID()),
        );

        $args_without_term = array(
            'post_type'      => 'trainings',
            'posts_per_page' => 6,
            'orderby'        => 'title',
            'order'          => 'DESC',
            'tax_query'      => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'trainings-category',
                    'operator' => 'NOT EXISTS',
                ),
                array(
                    'taxonomy' => 'trainings-category',
                    'operator' => 'EXISTS',
                    'terms'    => $post_terms,
                    'field'    => 'slug',
                    'compare'  => 'NOT IN',
                ),
            ),
            'post__not_in'   => array(get_the_ID()),
        );

        $query_with_term = new WP_Query($args_with_term);
        $query_without_term = new WP_Query($args_without_term);
        $query_results = array_merge($query_with_term->posts, $query_without_term->posts); ?>

        <?php foreach ($query_results as $post) :  ?>
            <li class="cat-item"><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title($post->ID); ?></a>
            <?php endforeach; ?>

            <?php wp_reset_postdata(); ?>
    </ul>
</div>