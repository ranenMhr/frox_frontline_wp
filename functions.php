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
		wp_enqueue_style('coachfocus-grid', COACHFOCUS_ASSETS_CSS_ROOT . '/grid.min.css');
	}

	add_action('wp_enqueue_scripts', 'coachfocus_child_theme_enqueue_scripts');
}

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
	$labels = array(
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
	$args = array(
		'labels'        => $labels,
		'description'   => 'Trainings Listing',
		'public'        => true,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-groups',
		'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
		'show_in_rest' => true
	);
	register_post_type('trainings', $args);

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
			'has_archive'   => true,
			'publicly_queryable'  => true
		)
	);

	$labels = array(
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
	$args = array(
		'labels'        => $labels,
		'description'   => 'Consultings Listing',
		'public'        => true,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-buddicons-buddypress-logo',
		'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'   => true,
		'publicly_queryable'  => true
	);
	register_post_type('consultings', $args);

	register_taxonomy(
		'consultings-category',
		'consultings',
		array(
			'hierarchical' => true,
			'label' => 'Consultings Categories',
			'query_var' => true,
			'public' => true, // Set it to false, which will remove View link from backend and redirect user to homepage on clicking taxonomy link.
			'show_ui' => true,
			'show_admin_column' => true,
			'supports' => array(
				'title', 'thumbnail', 'editor', 'custom-fields', 'excerpt', 'tags'
			)
		)
	);
}
add_action('init', 'post_type_frontline');
