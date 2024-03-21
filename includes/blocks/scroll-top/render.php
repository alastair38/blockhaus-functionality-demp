<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>

<!-- use href="#" to scroll to the top of the page as per HTML specification https://html.spec.whatwg.org/multipage/browsing-the-web.html#scroll-to-the-fragment-identifier -->

<a href="#" aria-label="scroll to top" class="progress-circle-container">
  <svg aria-hidden="true" class="progress-circle" viewBox="0 0 100 100">
    <circle class="progress-background" cx="50" cy="50" r="45"></circle>
    <circle class="progress-circle-bar" cx="50" cy="50" r="45"></circle>
  </svg>
  <div aria-hidden="true" class="scroll-to-top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 19V5M5 12l7-7 7 7" />
    </svg>
  </div>
</a>

