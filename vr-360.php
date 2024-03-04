<?php
/*
Plugin Name: VR 360
Plugin URI: https://floatmagazin.de/
Description: A plugin for integrating 360-degree images into articles.
Version: 1.0
Author: Olivier Guillard
Author URI: https://olivierguillard.dev/
*/

function vr360_scripts() {
    // Enqueue Pannellum CSS
    wp_enqueue_style('pannellum-css', '//cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css');
    
    // Enqueue Pannellum JS
    wp_enqueue_script('pannellum-js', '//cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'vr360_scripts');

function display_vr360($atts) {
    static $counter = 0;
    $attributs = shortcode_atts(array(
        'src' => '',
        'width' => '100%',
        'height' => '400px',
    ), $atts);
    $viewer_id = 'mon-image-360-' . $counter++;
    $output = "<div id='{$viewer_id}' style='width: {$attributs['width']}; height: {$attributs['height']};'></div>";
    $output .= "<script>
    window.addEventListener('load', function(){
        var viewer = pannellum.viewer('{$viewer_id}', {
            'type': 'equirectangular',
            'panorama': '{$attributs['src']}',
            'showFullscreenCtrl': true,
            'autoLoad': true
        });
    });
    </script>";
    return $output;
}
add_shortcode('image_360', 'display_vr360');
