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
    $locale = get_locale();
    $pageLang = get_the_terms( $post_id, 'language' );
    $pageType = get_post_type($post_id);

    if($versions):?>
    
    <div class="language-versions">
    <span>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="currentColor" d="M160 129.89L175.06 160h-30.12l6.36-12.7ZM224 48v160a16 16 0 0 1-16 16H48a16 16 0 0 1-16-16V48a16 16 0 0 1 16-16h160a16 16 0 0 1 16 16m-16.84 140.42l-40-80a8 8 0 0 0-14.32 0l-13.18 26.38a62.31 62.31 0 0 1-23.61-10A79.61 79.61 0 0 0 135.6 80H152a8 8 0 0 0 0-16h-40v-8a8 8 0 0 0-16 0v8H56a8 8 0 0 0 0 16h63.48a63.73 63.73 0 0 1-15.3 34.05a65.93 65.93 0 0 1-9-13.61a8 8 0 0 0-14.32 7.12a81.75 81.75 0 0 0 11.4 17.15A63.62 63.62 0 0 1 56 136a8 8 0 0 0 0 16a79.56 79.56 0 0 0 48.11-16.13a78.33 78.33 0 0 0 28.18 13.66l-19.45 38.89a8 8 0 0 0 14.32 7.16l9.78-19.58h46.12l9.78 19.58a8 8 0 1 0 14.32-7.16"/></svg> 
    
    <?php if(($pageType === 'resources-de') || ($pageType === 'place-de') || ($pageType === 'blog-de') || ($pageLang && $pageLang[0]->slug === 'de')):
    
        echo 'Sprachen';
        
     elseif(($pageType === 'resources-fr') || ($pageType === 'place-fr') || ($pageType === 'blog-fr') || ($pageLang && $pageLang[0]->slug === 'fr')):
        
        echo 'Langues';
        
     else:
        
        echo 'Languages ';
        
     endif;?>
    </span>
    <ul class="language-versions">
    <?php foreach($versions as $version):
    // get the assigned language, if any, to check if content is not from a lingual resource post type
      $lang = get_the_terms( $version->ID, 'language' );  
      
      if($version->post_status === 'publish'):
 
    ?>
     
        <li><a aria-label="<?php echo $version->post_title;?>" href="<?php echo get_the_permalink($version->ID);?>">
     
        <?php if(($version->post_type === 'resources-fr') || ($version->post_type === 'place-fr') || ($version->post_type === 'blog-fr') || ($lang && $lang[0]->slug === 'fr')):?>
            
            <!-- add svg class to place li item in a consistent place within the ul grid this saves having to perform complicated sorting on the $versions array -->
 
            <svg class="fr" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#francais';?>"></use>
            </svg>
        
        <?php esc_html_e( 'Français', 'core-functionality' );?>
        
        <?php elseif(($version->post_type === 'resources-de') || ($version->post_type === 'place-de') || ($version->post_type === 'blog-de') || ($lang && $lang[0]->slug === 'de')):?>

            <svg class="de" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#deutsch';?>"></use>
            </svg>
            
            <?php esc_html_e( 'Deutsch', 'core-functionality' );?>
            
        <?php else: ?>
         
            <svg class="gb" width="30" height="30">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/flags.svg#english';?>"></use>
            </svg>
            
            <?php esc_html_e( 'English', 'core-functionality' );?>
                  
        <?php endif;?>
        
        </a></li>
        
    <?php endif; endforeach;?> 

    </ul>
    </div>
    <?php endif;
    
    if(is_admin() && empty($versions)):
        echo '<small>Alternate language versions will appear here if assigned to the content item</small>';
    endif;

endif;?>