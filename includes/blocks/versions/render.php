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
$id = 'blockhaus-versions-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-versions';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if(function_exists('get_field')):
    //get the contents of the relationship field for this content item
    $versions = get_field('language_versions', $post_id);

    if($versions):?>

    <ul class="language-versions">
    <?php foreach($versions as $version):
    // get the assigned language, if any, to check if content is not from a lingual resource post type
      $lang = get_the_terms( $version->ID, 'language' );  
    ?>
     
        <li><a aria-label="<?php echo $version->post_title;?>" href="<?php echo get_the_permalink($version->ID);?>">
     
        <?php if(($version->post_type === 'resources-fr') || ($lang && $lang[0]->slug === 'fr')):?>
            
            <!-- add svg class to place li item in a consistent place within the ul grid this saves having to perform complicated sorting on the $versions array -->
 
            <svg class="fr" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#francais';?>"></use>
            </svg>
        
        <?php esc_html_e( 'Français', 'blockhaus' );?>
        
        <?php elseif(($version->post_type === 'resources-de') || ($lang && $lang[0]->slug === 'de')):?>

            <svg class="de" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#deutsch';?>"></use>
            </svg>
            
            <?php esc_html_e( 'Deutsch', 'blockhaus' );?>
            
        <?php else: ?>
         
            <svg class="gb" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#english';?>"></use>
            </svg>
            
            <?php esc_html_e( 'English', 'blockhaus' );?>
                  
        <?php endif;?>
        
        </a></li>
        
    <?php endforeach;?> 

    </ul>

    <?php endif;

endif;?>

