<?php
function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

add_filter( 'tiny_mce_before_init', 'boxes_plugin_that_add_style_formats_options', 20 );

function boxes_plugin_that_add_style_formats_options( $settings ){

    /* Our Own Custom Options */
    $style_formats = array(
        array(
            'title'   => 'Button',
            'items' => array(
                array(
                    'title' => 'Button 1',
                    'block' => 'span',
                    'classes' => 'btn btn-sm animated-button victoria-one',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Button 2',
                    'block' => 'span',
                    'classes' => 'btn btn-sm animated-button victoria-two',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Button 3',
                    'block' => 'span',
                    'classes' => 'btn btn-sm animated-button victoria-three',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Button 4',
                    'block' => 'span',
                    'classes' => 'btn btn-sm animated-button victoria-four',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Button 5',
                    'block' => 'span',
                    'classes' => 'btn btn-sm animated-button victoria-four',
                    'wrapper' => true,
                ),
            ),
        ),
        array(
            'title'   => 'Text',
            'items' => array(
                array(
                    'title' => 'Text Uppercase',
                    'block' => 'span',
                    'classes' => 'Text-Uppercase',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Text Capitalize',
                    'block' => 'span',
                    'classes' => 'Text-Capitalize',
                    'wrapper' => true,
                ),
                array(
                    'title' => 'Text Lowercase',
                    'block' => 'span',
                    'classes' => 'Text-Lowercase',
                    'wrapper' => true,
                ),
            ),
        ),
    );

    /* Add it in tinymce config as json data */
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}

