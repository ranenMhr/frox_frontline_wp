<?php

/* Template Name: Post Listing Template */
get_header('w-title'); ?>

<?php
$archive_type = get_field('archive_type');
$post_type = get_field('select_post_type');
$taxonomy_slug = get_field('select_post_taxonomy');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_per_page = 20;
?>

<?php
/* If Archive type is Post type */
if ($archive_type == 'post_type') :
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $post_per_page,
        'paged' => $paged
    );

/* If Archive type is Taxonomy */
elseif ($archive_type == 'category') :
    $taxonomies = get_object_taxonomies($post_type, 'objects');
    $taxonomy_name = '';
    foreach ($taxonomies as $taxonomy) {
        $taxonomy_name = $taxonomy->name;
    }

    $args = array(
        'post_type' => $post_type, // Your custom post type
        'posts_per_page' => $post_per_page, // Number of posts per page
        'paged' => $paged, // Current page number
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy_name, // Replace 'your_taxonomy_slug' with your actual taxonomy slug
                'field' => 'slug',
                'terms' => $taxonomy_slug // Replace 'your_term_slug' with the slug of the specific term you want to query
            )
        )
    );
endif; ?>

<div class="qodef-course-list qodef-item-layout--standard qodef-grid qodef-layout--columns  qodef-gutter--normal qodef-col-num--3 qodef-item-layout--standard qodef-filter--on qodef-pagination--on qodef-pagination-type--standard qodef-responsive--predefined">
    <?php
    $query = new WP_Query($args);
    if ($query->have_posts()) : ?>
        <div class="qodef-grid-inner clear">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="qodef-e qodef-course-item qodef-grid-item qodef-item--full">
                    <div class="qodef-e-inner">
                        <div class="qodef-e-media">
                            <div class="qodef-e-media-image archive-images">
                                <a itemprop="url" href="<?= the_permalink() ?>">
                                    <?php the_post_thumbnail('full') ?>
                                </a>
                            </div>
                            <div class="qodef-e-content">
                                <div class="qodef-e-text">
                                    <h5 itemprop="name" class="qodef-e-title entry-title">
                                        <a itemprop="url" class="qodef-e-title-link" href="<?= the_permalink() ?>">
                                            <?php the_title() ?></a>
                                    </h5>
                                    <div class="qodef-e-info qodef-e-info--instructor">
                                        <p class="m-0">
                                            <?php
                                            $content = get_the_content();
                                            $content = strip_tags($content);
                                            $content = preg_replace('/\s+/', ' ', $content);
                                            $content = trim($content);
                                            $truncated_content = substr($content, 0, 150) . '...';

                                            echo $truncated_content;
                                            ?>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata();
            ?>
        </div>
    <?php
    else :
        echo 'No posts found.';
    endif;
    ?>
</div>

<?php
echo '<div class="custom-pagination">';
echo paginate_links(array(
    'total' => $query->max_num_pages,
    'current' => max(1, $paged),
    'prev_text' => __('<svg class="qodef-svg--pagination-arrow-left" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="34" height="28" viewBox="0 0 34 28" style="enable-background:new 0 0 34 28;" xml:space="preserve"><path d="M1,13.9L14.3,1l0.2,0.2l-13,12.6h31.4v0.3H1.5l13,12.6L14.3,27L1,14.1L1,13.9L1,13.9z"></path></svg> Prev'),
    'next_text' => __('Next <svg class="qodef-svg--pagination-arrow-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="34" height="28" viewBox="0 0 34 28" style="enable-background:new 0 0 34 28;" xml:space="preserve"><path d="M32.8,13.9L19.5,1l-0.2,0.2l13,12.6H0.9v0.3h31.4l-13,12.6l0.2,0.2l13.3-12.9L32.8,13.9L32.8,13.9z"></path></svg>'),
    'mid_size' => 1, // Adjust the number of pages shown on each side of the current page
    //'prev_next' => false // Hide previous and next arrows
));
echo '</div>';
?>

<?php get_footer();
