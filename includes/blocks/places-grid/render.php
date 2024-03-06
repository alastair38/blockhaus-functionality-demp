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

$args = array(
    'numberposts' => -1,
    'post_type'   => 'place'
  );
  
$places = get_posts( $args );

// var_dump($places);

if(!empty($places)):?>

  <ul <?php echo get_block_wrapper_attributes();?>>
    <?php foreach($places as $place):
    	
    echo '<li>
            <figure>'
                . get_the_post_thumbnail( $place->ID) .
                '</figure><h3>' . get_the_title($place->ID) . '</h3>
                <a href="' . get_the_permalink($place->ID) . '">View place
            </a>
         </li>';
        
    endforeach;?>
   
<?php endif;
    
if(is_admin() && empty($places) ):
    echo '<span class="placeholder">List of places custom post type will appear here.</span>';
endif;

?>

</ul>