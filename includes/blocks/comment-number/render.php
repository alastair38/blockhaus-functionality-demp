<?php

/**
 * Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$post_id = get_the_ID();

$comments = get_comments_number($post_id);

if(comments_open($post_id)):
    
if ( is_singular()) : 
    echo '<a href="#comments-layout" ' . get_block_wrapper_attributes() . '>
        <svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.25 17.31a.75.75 0 0 1-.72-1l1.25-4.12a6.64 6.64 0 0 1-.4-2.19a6.36 6.36 0 0 1 .51-2.51a6.48 6.48 0 0 1 10.53-2.1a6.66 6.66 0 0 1 1.38 2.06a6.46 6.46 0 0 1 0 5a6.66 6.66 0 0 1-1.38 2.06A6.48 6.48 0 0 1 8.59 16l-4.12 1.28a.83.83 0 0 1-.22.03M10.84 5a4.9 4.9 0 0 0-1.93.39A5 5 0 0 0 6.27 8a5 5 0 0 0 0 3.87a.75.75 0 0 1 0 .51l-.92 3l3-.92a.75.75 0 0 1 .51 0a5 5 0 0 0 6.51-2.64A5 5 0 0 0 10.84 5"/><path fill="currentColor" d="M19.75 20.5a.83.83 0 0 1-.22 0l-4.12-1.25a6.42 6.42 0 0 1-8.17-3.48a.73.73 0 0 1 .38-1a.75.75 0 0 1 1 .38a5.06 5.06 0 0 0 1 1.53a5 5 0 0 0 5.44 1.06a.75.75 0 0 1 .51 0l3 .92l-.92-3a.75.75 0 0 1 0-.51a4.9 4.9 0 0 0 .39-1.93a4.93 4.93 0 0 0-1.45-3.51a5.62 5.62 0 0 0-.67-.71a.75.75 0 1 1 .84-1.24a6.69 6.69 0 0 1 1 .79a6.49 6.49 0 0 1 1.38 2.06a6.38 6.38 0 0 1 .51 2.52a6.63 6.63 0 0 1-.4 2.25l1.25 4.12a.75.75 0 0 1-.72 1Z"/></svg>';
        
        printf(
            _nx(
                '1 comment',
                '%1$s comments',
                get_comments_number(),
                'blockhaustwentytwentyfour'
            ),
            number_format_i18n( get_comments_number() )
        );
        
        echo '</a>';
endif;

if ( (is_archive()) || is_admin()) : 
    echo '<div ' . get_block_wrapper_attributes() . '>
        <svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.25 17.31a.75.75 0 0 1-.72-1l1.25-4.12a6.64 6.64 0 0 1-.4-2.19a6.36 6.36 0 0 1 .51-2.51a6.48 6.48 0 0 1 10.53-2.1a6.66 6.66 0 0 1 1.38 2.06a6.46 6.46 0 0 1 0 5a6.66 6.66 0 0 1-1.38 2.06A6.48 6.48 0 0 1 8.59 16l-4.12 1.28a.83.83 0 0 1-.22.03M10.84 5a4.9 4.9 0 0 0-1.93.39A5 5 0 0 0 6.27 8a5 5 0 0 0 0 3.87a.75.75 0 0 1 0 .51l-.92 3l3-.92a.75.75 0 0 1 .51 0a5 5 0 0 0 6.51-2.64A5 5 0 0 0 10.84 5"/><path fill="currentColor" d="M19.75 20.5a.83.83 0 0 1-.22 0l-4.12-1.25a6.42 6.42 0 0 1-8.17-3.48a.73.73 0 0 1 .38-1a.75.75 0 0 1 1 .38a5.06 5.06 0 0 0 1 1.53a5 5 0 0 0 5.44 1.06a.75.75 0 0 1 .51 0l3 .92l-.92-3a.75.75 0 0 1 0-.51a4.9 4.9 0 0 0 .39-1.93a4.93 4.93 0 0 0-1.45-3.51a5.62 5.62 0 0 0-.67-.71a.75.75 0 1 1 .84-1.24a6.69 6.69 0 0 1 1 .79a6.49 6.49 0 0 1 1.38 2.06a6.38 6.38 0 0 1 .51 2.52a6.63 6.63 0 0 1-.4 2.25l1.25 4.12a.75.75 0 0 1-.72 1Z"/></svg>';
        
        printf(
            _nx(
                '1 comment',
                '%1$s comments',
                get_comments_number(),
                'blockhaustwentytwentyfour'
            ),
            number_format_i18n( get_comments_number() )
        );
        
        echo '</div>';
endif;

endif;

?>

