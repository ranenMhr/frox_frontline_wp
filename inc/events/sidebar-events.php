<aside id="qodef-page-sidebar" role="complementary">
    <div class="d-none d-lg-block mb-lg-5">
        <?php child_template_part('events', 'event-details'); ?>
    </div>
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
            <h4 class="qodef-widget-title">Event Type</h4>
        </div>
        <?php
        $terms = get_terms(array(
            'taxonomy' => 'event-types',
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
            <h4 class="qodef-widget-title">More Upcoming Events</h4>
        </div>
        <ul class="wp-block-event-list wp-block-event sidebar-list-wrapper">
            <?php
            $today = date('Y-m-d');
            $post_terms = wp_get_post_terms(get_the_ID(), 'event-types', ['fields' => 'slugs']);
            $args = array(
                'post_type' => 'event-item',
                'posts_per_page' => 6,
                'order' => 'DESC',
                'orderby' => 'meta_value',
                'meta_key' => 'qodef_event_single_start_date',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'qodef_event_single_start_date',
                        'value' => $today,
                        'compare' => '>',
                        'type' => 'DATE',
                    ),
                ),
                /* 'tax_query' => array(
                        'relation' => 'OR',
                        array(
                            'taxonomy' => 'event-types', // Replace 'your_taxonomy' with the name of your taxonomy
                            'field' => 'slug',
                            'terms' => $post_terms, // Replace 'test1' with the slug of the first term
                        ),
                    ) */
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
            ?>
                    <li class="cat-item"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                <?php
                }
            } else {

                echo 'No events found';
            }

            wp_reset_postdata();
                ?>
        </ul>
    </div>
</aside>