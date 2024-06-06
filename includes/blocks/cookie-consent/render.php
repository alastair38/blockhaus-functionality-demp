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
 
 $btnText = 'Manage Cookie Preferences';
 $paraText = 'Embedded media content is disabled by default. Click "Manage Cookie Preferences" and enable "Media" cookies to view.';

if(is_singular('blog-de') || is_singular('place-de') || is_singular('resources-de') || get_post_type($post_id) === 'blog-de' || get_post_type($post_id) === 'place-de' || get_post_type($post_id) === 'resources-de'):
  $btnText = 'Cookie-Einstellungen';
  $paraText = 'Eingebettete Medieninhalte sind standardmäßig deaktiviert. Klicken Sie auf "Cookie-Einstellungen" und aktivieren Sie "Medien"-Cookies zur Ansicht.';
elseif(is_singular('blog-fr') || is_singular('place-fr') || is_singular('resources-fr') || get_post_type($post_id) === 'blog-fr' || get_post_type($post_id) === 'place-fr' || get_post_type($post_id) === 'resources-fr'):
  $btnText = 'Préférences en matière de cookies';
  $paraText = 'Le contenu multimédia intégré est désactivé par défaut. Cliquez sur "Préférences en matière de cookies" et activez les cookies "médias" pour les visualiser.';
else:
  $btnText = 'Manage cookie preferences';
  $paraText = 'Embedded media content is disabled by default. Click "Manage Cookie Preferences" and enable "Media" cookies to view.';
endif;

if(!is_admin()):?>

<div class="wp-block-blockhaus-cookie-consent-wrapper">
  <p>Embedded media content is disabled by default. Click 'Manage Cookie Preferences' and enable "Media" cookies to view.</p>
<button class="wp-block-blockhaus-cookie-consent-btn" type="button" data-cc="show-preferencesModal"><?php echo $btnText;?></button>
</div>

<?php else:?>

<div class="wp-block-blockhaus-cookie-consent-admin">The cookie consent button will only show on the front-end. Make sure to add both this block and the embed block to a Group (Shadow) block for correct positioning. </div>

<?php endif;?>




