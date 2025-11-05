<?php
/**
 * protector functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function protector_setup() {
    // Поддержка WooCommerce
    add_theme_support( 'woocommerce' );

    // Поддержка FSE (Full Site Editing)
    add_theme_support( 'block-template-parts' );

    // Поддержка блоков WooCommerce
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
    ) );

    // Подключаем Google Fonts: Inter
    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_style(
            'inter-font',
            'https://rsms.me/inter/inter.css',
            array(),
            null
        );
    } );

    // Подключаем стили темы
    add_action( 'wp_enqueue_scripts', 'protector_enqueue_styles' );
}
add_action( 'after_setup_theme', 'protector_setup' );

function protector_enqueue_styles() {
    wp_enqueue_style(
        'protector-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}

// Отключаем стандартные стили WooCommerce (используем блоки)
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Регистрируем шаблон главной страницы
add_action( 'init', function() {
    if ( function_exists( 'register_block_template' ) ) {
        register_block_template(
            'protector//index',
            array(
                'title'      => __( 'Главная (Каталог)', 'protector' ),
                'post_types' => array( 'page' ),
                'description' => __( 'Главная страница с каталогом и фильтрами', 'protector' ),
            )
        );
    }
} );