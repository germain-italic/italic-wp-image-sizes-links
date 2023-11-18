<?php
/*
Plugin Name: Italic WP Image Sizes Links
Plugin URI: https://github.com/germain-italic/italic-wp-image-sizes-links
Description: Display links to all available image sizes on the image edit page.
Version: 1.0.0
Author: Germain-Italic
Author URI: https://www.italic.fr
License: GPLv2 or later
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_filter('attachment_fields_to_edit', 'add_image_size_links', 10, 2);

function add_image_size_links($form_fields, $post) {
    $attachment_id = $post->ID;
    $available_sizes = get_intermediate_image_sizes();

    $size_links = '';

	echo '<ul>';
    foreach ($available_sizes as $size) {
        $image = wp_get_attachment_image_src($attachment_id, $size);
        if ($image) {
            $url = $image[0];
            $width = $image[1];
            $height = $image[2];
            $size_links .= "<li><a href='$url' target='_blank'>$size ($width x $height)</a></li>";
        }
    }
	echo '</ul>';

    $form_fields['image-size-links'] = array(
        'label' => 'Image Sizes',
        'input' => 'html',
        'html'  => $size_links
    );

    return $form_fields;
}
