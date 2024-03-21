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

if(!is_home()):
    
$queried = get_queried_object();
$postType = $queried->name;

else:
    
$postType = 'post';

endif;

if(function_exists('get_field')):
    
$description = get_field( $postType, 'option' );

    if($description && !is_author()):
        
     echo '<p ' . get_block_wrapper_attributes() . '>' . $description . '</p>';
        
    endif;
    
    if(is_admin() && empty($description) ):
        
        echo '<p>Set the description for custom post type archives on the site settings page.</p>';
        
    endif;
    
endif;

?>

