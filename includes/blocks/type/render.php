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
$id = 'blockhaus-type-label-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-type-label';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}


$type = get_post_type($post_id );
$typeObj = get_post_type_object($type);

if(!is_admin() && $typeObj && ($typeObj->name !== "page")):

echo '<p class="' . $className . '">' . $typeObj->labels->singular_name . '</p>';

elseif(is_admin() && !$typeObj):
    
echo '<p class="' . $className . '">Post type label</p>'; 
    
endif;

?>

