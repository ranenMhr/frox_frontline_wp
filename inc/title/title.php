<div class="qodef-page-title custom-page-title qodef-m <?php echo esc_attr(coachfocus_get_page_title_classes()); ?>">
    <?php
    // Hook to include additional content before page title inner
    do_action('coachfocus_action_before_page_title_inner');
    ?>
    <div class="qodef-m-inner">
        <?php
        // Include module content template
        child_template_part('title', 'templates/title-content');
        ?>
    </div>
    <?php
    // Hook to include additional content after page title inner
    do_action('coachfocus_action_after_page_title_inner');
    ?>
</div>