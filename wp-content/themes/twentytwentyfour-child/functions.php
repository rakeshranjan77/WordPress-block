<?php
//add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles_child' );
function my_theme_enqueue_styles_child() {
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( 'parenthandle' ),
		wp_get_theme()->get( 'Version' ) // This only works if you have Version defined in the style header.
	);
}

//add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles_main' );
    function my_theme_enqueue_styles_main() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    }

function my_theme_enqueue_styles() {
    $parent_style = 'twentytwentyfour-style'; // This is 'parent-style' for the Twenty Seventeen theme.
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
