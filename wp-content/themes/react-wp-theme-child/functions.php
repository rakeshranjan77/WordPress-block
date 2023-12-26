<?php

/*if (file_exists(__DIR__ . '/plugins/class-latest-stories-widget/class-latest-stories-widget.php') ) {
    include_once __DIR__ . '/plugins/class-latest-stories-widget/class-latest-stories-widget.php';
}*/
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles_child');
function my_theme_enqueue_styles_child()
{
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array( 'parenthandle' ),
        wp_get_theme()->get('Version') // This only works if you have Version defined in the style header.
    );
}

add_action('after_setup_theme', 'reactwp_slug_setup');
function reactwp_slug_setup()
{
    add_theme_support('wp-block-styles');
}
