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
$id = 'blockhaus-places-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-places';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

$locations = get_the_terms($post_id, 'location');
$type = get_post_type($post_id);


if(!empty($locations)):?>
    <div aria-label="<?php esc_html_e( 'Places', 'core-functionality' );?>" data-count="<?php echo count($locations);?>" class="blockhaus-places">
    
    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/></svg>
  
    <?php foreach($locations as $location):
    	
        if($type === 'resources-de' || $type === 'blog-de'):
        
            $link = get_field('places_link_de', 'term_' . $location->term_id);
        
        elseif($type === 'resources-fr' || $type === 'blog-fr'):
            
            $link = get_field('places_link_fr', 'term_' . $location->term_id);
            
        else:
            
            $link = get_field('places_link', 'term_' . $location->term_id);
        
        endif;
    
    echo '<a href="' . $link . '" rel="tag">' . $location->name . '</a>';
        
    endforeach;?>
    </div>
<?php endif;

if(is_admin() && empty($locations) ):
    echo '<span class="placeholder">List of assigned locations will appear here.</span>';
endif;


?>

