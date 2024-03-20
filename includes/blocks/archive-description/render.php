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
$id = 'blockhaus-archive-description-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-archive-description';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}


$type = get_queried_object();

if(function_exists('get_field')):
    
$description = get_field( $type->name, 'option' );

    if($description && !is_author()):
        
     echo '<p ' . get_block_wrapper_attributes() . '>' . $description . '</p>';
        
    endif;
    
    if(is_admin() && empty($description) ):
        echo '<p>Set the description for custom post type archives on the site settings page.</p>';
    endif;
    
endif;

?>

