<?php

if (!function_exists('coachfocus_get_trainings_holder_classes')) {
	/**
	 * Function that return classes for the main trainings holder
	 *
	 * @return string
	 */
	function coachfocus_get_trainings_holder_classes()
	{
		$classes = array();

		if (is_single()) {
			$classes[] = 'qodef--single';
		} else {
			$classes[] = 'qodef--list';
		}

		return implode(' ', apply_filters('coachfocus_filter_trainings_holder_classes', $classes));
	}
}

if (!function_exists('coachfocus_get_trainings_list_excerpt_length')) {
	/**
	 * Function that return number of characters for excerpt on trainings list page
	 *
	 * @return int
	 */
	function coachfocus_get_trainings_list_excerpt_length()
	{
		$length = apply_filters('coachfocus_filter_post_excerpt_length', 180);

		return intval($length);
	}
}

if (!function_exists('coachfocus_post_has_read_more')) {
	/**
	 * Function that checks if current post has read more tag set
	 *
	 * @return int position of read more tag text. It will return false if read more tag isn't set
	 */
	function coachfocus_post_has_read_more()
	{
		global $post;

		return !empty($post) ? strpos($post->post_content, '<!--more-->') : false;
	}
}
