<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$noResults = 'No content is currently available. Please check back shortly.';

if(is_singular('blog-de') || is_singular('place-de') || is_singular('resources-de') || get_post_type($post_id) === 'blog-de' || get_post_type($post_id) === 'place-de' || get_post_type($post_id) === 'resources-de' || is_post_type_archive('resources-de' ) || is_post_type_archive('blog-de')):
  $noResults = 'Derzeit haben wir noch keine Kontent eingestellt. Bitte schauen Sie demnächst nochmals vorbei – danke!';
elseif(is_singular('blog-fr') || is_singular('place-fr') || is_singular('resources-fr') || get_post_type($post_id) === 'blog-fr' || get_post_type($post_id) === 'place-fr' || get_post_type($post_id) === 'resources-fr' || is_post_type_archive('resources-fr' ) || is_post_type_archive('blog-fr')):
  $noResults = "Aucun contenu n'est actuellement disponible. Veuillez vérifier à nouveau sous peu.";
else:
  $noResults = 'No content is currently available. Please check back shortly.';
endif;

echo '<p>' . $noResults . '</p>';
 
?> 
 



