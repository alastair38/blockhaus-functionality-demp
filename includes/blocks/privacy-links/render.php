<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

 $class_name = 'demo-author-block-acf';
 if ( ! empty( $block['className'] ) ) {
     $class_name .= ' ' . $block['className'];
 }
 
 $queriedObjectId = get_queried_object_id(  );
 
 if(function_exists('get_field')):

  $cookiesSet = get_field('cookies_settings', 'option');
  $privacyPages = get_field('consent_panel_settings', 'option');
  $privacyLinkText = 'Privacy';
  $contactLinkText = 'Contact';
  
  if($privacyPages):
    $privacy = $privacyPages['privacy_page'];
    $contact = $privacyPages['contact_page'];
  endif;
  
  $btnText = 'Cookie Preferences';
  
  $lang = get_the_terms( $post_id, 'language' );
  
  $lang = $lang ? $lang[0]->slug : '';

  if(is_singular('blog-de') || is_singular('place-de') || is_singular('resources-de') || get_post_type($post_id) === 'blog-de' || get_post_type($post_id) === 'place-de' || get_post_type($post_id) === 'resources-de' || $lang === 'de'):
    
    $btnText = 'Cookie-Einstellungen';
    
    $privacyLinkText = 'Datenschutz';
    $contactLinkText = 'Kontakt';
    
    if($privacyPages):
      $privacy = $privacyPages['privacy_page_de'];
      $contact = $privacyPages['contact_page_de'];
    endif;
    
  elseif(is_singular('blog-fr') || is_singular('place-fr') || is_singular('resources-fr') || get_post_type($post_id) === 'blog-fr' || get_post_type($post_id) === 'place-fr' || get_post_type($post_id) === 'resources-fr' || $lang === 'fr'):
    
    $btnText = 'Préférences en matière de cookies';
    
    $privacyLinkText = 'Privée';
    $contactLinkText = 'Contact';
    
    if($privacyPages):
      $privacy = $privacyPages['privacy_page_fr'];
      $contact = $privacyPages['contact_page_fr'];
    endif;
    
  else:
    
    $privacyLinkText = 'Privacy';
    $contactLinkText = 'Contact';
    
    $btnText = 'Cookie Preferences';
    
    if($privacyPages):
      $privacy = $privacyPages['privacy_page'];
      $contact = $privacyPages['contact_page'];
    endif;
  
  endif;
  
 endif;
?>

<ul class="wp-block-blockhaus-privacy-links">
  
  <?php if($cookiesSet):?>
  <li><button type="button" data-cc="show-preferencesModal"><?php echo $btnText;?></button></li>
  <?php endif;?>
  
  <?php if($privacy):?>
    
    <li><a href="<?php echo $privacy;?>"><?php echo $privacyLinkText;?></a></li>
    
  <?php endif;?>
  
  <?php if($contact):?>
    
    <li><a href="<?php echo $contact;?>"><?php echo $contactLinkText;?></a></li>
    
  <?php endif;?>
  
  
</ul>



