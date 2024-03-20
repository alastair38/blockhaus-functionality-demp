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
$id = 'blockhaus-documents-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'blockhaus-documents';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

if(function_exists('get_field')):
    //get the contents of the relationship field for this content item
    // $docs = get_field('documents');
    
    // var_dump($docs);

  // Check rows exists.
if( have_rows('documents', $post_id) ):

    $type = get_post_type($post_id);
    $lang = get_the_terms( $post_id, 'language' );
	
	
	if($type === 'resources-de' || $type === 'blog-de' || ($lang && $lang[0]->slug === 'de')):
			
	$text = 'Dokumentes ';

	elseif($type === 'resources-fr' || $type === 'blog-fr' || ($lang && $lang[0]->slug === 'fr')):
			
	$text = 'Le Documents';

	else:
		
    $text = 'Documents';

	endif;


?>

<div class="<?php echo $className;?>">
<strong class="">  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><path fill="currentColor" d="m30 25l-1.414-1.414L26 26.172V18h-2v8.172l-2.586-2.586L20 25l5 5l5-5z"/><path fill="currentColor" d="M18 28H8V4h8v6a2.006 2.006 0 0 0 2 2h6v3h2v-5a.91.91 0 0 0-.3-.7l-7-7A.909.909 0 0 0 18 2H8a2.006 2.006 0 0 0-2 2v24a2.006 2.006 0 0 0 2 2h10Zm0-23.6l5.6 5.6H18Z"/></svg><?php echo $text;?></strong>

<ul>

    <?php // Loop through rows.
    while( have_rows('documents', $post_id) ) : the_row();

        // Load sub field value.
        $doc = get_sub_field('document');
       // var_dump($doc);
        if(!empty($doc)):
        ?>
       
            <li>
                <a aria-label="<?php esc_html_e( 'Download ' . $doc['filename'], 'core-functionality' );?>" href="<?php echo esc_url($doc['url']);?>">
                <span class="file-name"><?php esc_html_e( $doc['title'], 'core-functionality' );?></span>
                <span class="file-type"><?php esc_html_e( $doc['subtype'], 'core-functionality' );?></span>
                </a>
            </li>
       

  <?php  endif; // End loop.
    endwhile;?>
 </ul>

 </div>
<?php // No value.
else :
    
    if(is_admin()):
    echo '<small>Files attached to this resource will show here</small>';
    endif;
    
endif;

endif;?>

