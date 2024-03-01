jQuery(document).ready(function ($) {
    console.log('test');
    $('[data-name="select_post_type"] select').change(function () {
        var selectedPostType = $(this).val();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'custom_get_taxonomies',
                post_type: selectedPostType,
            },
            success: function (response) {
                $('[data-name="select_post_taxonomy"] select').html(response);
            },
        });
    });
});
