<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/rtl.css' );

}

add_shortcode ( 'add_map_widget', 'add_map_widget' );
function add_map_widget() {
return get_template_part('map');
}


add_shortcode ( 'transcriber', 'add_transcriber_widget' );
function add_transcriber_widget() {
return get_template_part('transcriber');
}
?>