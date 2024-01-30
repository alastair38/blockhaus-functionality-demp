<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'blockhaus-date-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-date';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

if((get_post_type($post_id) === "post") || (get_post_type($post_id) === "resources") ):
    
echo blockhaus_locale_date_formatter($post_id);

endif;

?>

