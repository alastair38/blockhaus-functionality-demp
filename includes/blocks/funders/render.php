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
$id = 'blockhaus-funders-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-funders';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if(function_exists('get_field')):
    //get the contents of the relationship field for this content item
    //$funders = get_field('funders', 'option');

  // Check rows exists.
if( have_rows('funders', 'option') ):?>

<ul class="funders">

    <?php // Loop through rows.
    while( have_rows('funders', 'option') ) : the_row();

        // Load sub field value.
        $name = get_sub_field('name');
        $website = get_sub_field('website');
        $logo = get_sub_field('logo');
        
        
        
        ?>
       
            <li>
                <a aria-label="<?php esc_html_e( $name . ' website', 'core-functionality' );?>" href="<?php echo esc_url($website);?>">
                <?php 
                 //   var_dump($logo);
                    if( !empty( $logo ) ): ?>
                        <img height="100" width="100%" src="<?php echo esc_url($logo['url']); ?>" alt="<?php esc_html_e( $name . ' logo', 'core-functionality' );?>" />
                    <?php endif; ?>
                </a>
            </li>
       

  <?php  // End loop.
    endwhile;?>
 </ul>
<?php // No value.
else :
    if(is_admin()):
        echo '<small>Any funder details from the Site Settings page will show here</small>';
    endif;
endif;

endif;?>

