<?php


define('COACHFOCUS_CHILD_ROOT', get_stylesheet_directory_uri());
define('COACHFOCUS_CHILD_ROOT_DIR', get_stylesheet_directory());
define('COACHFOCUS_CHILD_ASSETS_ROOT', COACHFOCUS_CHILD_ROOT . '/assets');
define('COACHFOCUS_CHILD_ASSETS_ROOT_DIR', COACHFOCUS_CHILD_ROOT_DIR . '/assets');
define('COACHFOCUS_CHILD_ASSETS_CSS_ROOT', COACHFOCUS_CHILD_ASSETS_ROOT . '/css');
define('COACHFOCUS_CHILD_ASSETS_CSS_ROOT_DIR', COACHFOCUS_CHILD_ASSETS_ROOT_DIR . '/css');
define('COACHFOCUS_CHILD_ASSETS_JS_ROOT', COACHFOCUS_CHILD_ASSETS_ROOT . '/js');
define('COACHFOCUS_CHILD_ASSETS_JS_ROOT_DIR', COACHFOCUS_CHILD_ASSETS_ROOT_DIR . '/js');
define('COACHFOCUS_CHILD_INC_ROOT', COACHFOCUS_CHILD_ROOT . '/inc');
define('COACHFOCUS_CHILD_INC_ROOT_DIR', COACHFOCUS_CHILD_ROOT_DIR . '/inc');


if (!function_exists('coachfocus_child_theme_enqueue_scripts')) {
	/**
	 * Function that enqueue theme's child style
	 */
	function coachfocus_child_theme_enqueue_scripts()
	{
		$main_style = 'coachfocus-main';

		wp_enqueue_style('coachfocus-child-style', get_stylesheet_directory_uri() . '/style.css', array($main_style));
	}

	add_action('wp_enqueue_scripts', 'coachfocus_child_theme_enqueue_scripts');
}

function custom_enqueue_admin_scripts()
{
	wp_enqueue_script('custom-admin-scripts', get_stylesheet_directory_uri() . '/js/admin-scripts.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'custom_enqueue_admin_scripts');

function add_file_types_to_uploads($file_types)
{
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes);
	return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

if (!function_exists('coachfocus_template_part')) {
	/**
	 * Function that echo module template part.
	 *
	 * @param string $module   name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array  $params   the array of parameters to pass to template
	 */
	function child_template_part($module, $template, $slug = '', $params = array())
	{
		echo child_get_template_part($module, $template, $slug, $params); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if (!function_exists('child_get_template_part')) {
	/**
	 * Function that load module template part.
	 *
	 * @param string $module   name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array  $params   array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function child_get_template_part($module, $template, $slug = '', $params = array())
	{
		//HTML Content from template
		$html          = '';
		$template_path = COACHFOCUS_CHILD_INC_ROOT_DIR . '/' . $module;

		$temp = $template_path . '/' . $template;
		if (is_array($params) && count($params)) {
			extract($params, EXTR_SKIP); // @codingStandardsIgnoreLine
		}

		$template = '';

		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";

				if (!file_exists($template)) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		if ($template) {
			ob_start();
			include($template); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			$html = ob_get_clean();
		}

		return $html;
	}
}

function post_type_frontline()
{
	$training_labels = array(
		'name'               => _x('Trainings', 'post type general name'),
		'singular_name'      => _x('Training', 'post type singular name'),
		'add_new'            => _x('Add New', 'Training'),
		'add_new_item'       => __('Add New Training'),
		'edit_item'          => __('Edit Training'),
		'new_item'           => __('New Training'),
		'all_items'          => __('All Trainings'),
		'view_item'          => __('View Training'),
		'search_items'       => __('Search Properties'),
		'not_found'          => __('No Trainings found'),
		'not_found_in_trash' => __('No Trainings found in the Trash'),
		'menu_name'          => 'Trainings'
	);
	$training_args = array(
		'labels'        => $training_labels,
		'description'   => 'Trainings Listing',
		'public'        => true,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-groups',
		'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
		'show_in_rest' => true,
		'rewrite'       => array('slug' => 'training', 'with_front' => false),
	);
	register_post_type('trainings', $training_args);

	register_taxonomy(
		'trainings-category',
		'trainings',
		array(
			'hierarchical' => true,
			'label' => 'Trainings Categories',
			'query_var' => true,
			'public' => true, // Set it to false, which will remove View link from backend and redirect user to homepage on clicking taxonomy link.
			'show_ui' => true,
			'show_admin_column' => true,
			'supports' => array(
				'title', 'thumbnail', 'editor', 'custom-fields', 'excerpt', 'tags'
			),
			'show_in_rest' => true,
			'has_archive'   => false,
			'rewrite'       => array('slug' => 'training', 'with_front' => false),
			'publicly_queryable'  => true
		)
	);

	$consulting_labels = array(
		'name'               => _x('Consultings', 'post type general name'),
		'singular_name'      => _x('Consulting', 'post type singular name'),
		'add_new'            => _x('Add New', 'Consulting'),
		'add_new_item'       => __('Add New Consulting'),
		'edit_item'          => __('Edit Consulting'),
		'new_item'           => __('New Consulting'),
		'all_items'          => __('All Consultings'),
		'view_item'          => __('View Consulting'),
		'search_items'       => __('Search Properties'),
		'not_found'          => __('No Consultings found'),
		'not_found_in_trash' => __('No Consultings found in the Trash'),
		'menu_name'          => 'Consultings'
	);
	$consulting_args = array(
		'labels'        => $consulting_labels,
		'description'   => 'Consultings Listing',
		'public'        => true,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-buddicons-buddypress-logo',
		'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => true,
		'publicly_queryable'  => true,
		'rewrite'       	=> array('slug' => 'consulting', 'with_front' => false),
		'show_in_rest' => true
	);
	register_post_type('consultings', $consulting_args);

	register_taxonomy(
		'consultings-category',
		'consultings',
		array(
			'hierarchical' => true,
			'label' => 'Consultings Categories',
			'query_var' => true,
			'public' => true, // Set it to false, which will remove View link from backend and redirect user to homepage on clicking taxonomy link.
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite'       	=> array('slug' => 'consulting', 'with_front' => false),
			'supports' => array(
				'title', 'thumbnail', 'editor', 'custom-fields', 'excerpt', 'tags'
			)
		)
	);

	$news_labels = array(
		'name'               => _x('News', 'post type general name'),
		'singular_name'      => _x('News', 'post type singular name'),
		'add_new'            => _x('Add New', 'News'),
		'add_new_item'       => __('Add New News'),
		'edit_item'          => __('Edit News'),
		'new_item'           => __('New News'),
		'all_items'          => __('All News'),
		'view_item'          => __('View News'),
		'search_items'       => __('Search News'),
		'not_found'          => __('No News found'),
		'not_found_in_trash' => __('No News found in the Trash'),
		'menu_name'          => 'News'
	);
	$news_args = array(
		'labels'        	=> $news_labels,
		'description'   	=> 'News Listing',
		'public'        	=> true,
		'menu_position' 	=> 20,
		'menu_icon'     	=> 'dashicons-welcome-widgets-menus',
		'supports'      	=> array('title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   	=> true,
		'show_in_rest' 		=> true,
		'rewrite'       	=> array('slug' => 'recent-activities', 'with_front' => false),
		'publicly_queryable'  => true
	);
	register_post_type('news', $news_args);

	register_taxonomy(
		'news-category',
		'news',
		array(
			'hierarchical' 		=> true,
			'label' 			=> 'News Categories',
			'query_var' 		=> true,
			'public' 			=> true,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'show_in_rest' 		=> true,
			'rewrite'       	=> array('slug' => 'recent-activities', 'with_front' => false),
			'supports' 			=> array(
				'title', 'thumbnail', 'editor', 'custom-fields', 'excerpt', 'tags'
			)
		)
	);
}
add_action('init', 'post_type_frontline');

/* Populate ACF field Select Post Type */
add_filter('acf/load_field/name=select_post_type', 'custom_acf_load_post_types');
function custom_acf_load_post_types($field)
{

	$choices = get_post_types(array('show_in_nav_menus' => true), 'objects');
	$os = array("Event Item", "Training", "Consulting", "News");

	foreach ($choices as $post_type) :
		if (in_array($post_type->labels->singular_name, $os))
			$field['choices'][$post_type->name] = $post_type->labels->singular_name;
	endforeach;
	return $field;
}


/* Populate ACF field Select Post Category based on sected Post Type */
add_filter('acf/load_field/key=select_post_taxonomy', 'custom_populate_acf_select_with_taxonomies');
function custom_populate_acf_select_with_taxonomies($field)
{
	$post_type = isset($_POST['acf']['select_post_type']) ? $_POST['acf']['select_post_type'] : '';

	$field['choices'] = array();

	if (!empty($post_type)) {
		$taxonomies = get_object_taxonomies($post_type, 'objects');

		foreach ($taxonomies as $taxonomy) {
			$field['choices'][$taxonomy->name] = $taxonomy->label;
		}
	}

	return $field;
}

// AJAX handler function to fetch taxonomies based on selected post type
add_action('wp_ajax_custom_get_taxonomies', 'custom_get_taxonomies');
function custom_get_taxonomies()
{
	$post_type = $_POST['post_type'];

	$taxonomies = get_object_taxonomies($post_type, 'objects');
	$taxonomy_name = '';
	foreach ($taxonomies as $taxonomy) {
		$taxonomy_name = $taxonomy->name;
	}

	if ($taxonomy_name != '') {
		$options_html = '<option value="">Select Category</option>';
		if (!empty($post_type)) {
			$categories = get_categories(array(
				'taxonomy' => $taxonomy_name,
				'object_type' => $post_type
			));
			foreach ($categories as $category) {
				$options_html .= '<option value="' . $category->slug . '">' . $category->name . '</option>';
			}
		}
	}
	echo $options_html;
	die();
}
