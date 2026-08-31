<?php
/**
 * Plugin Name: Remcash Team
 * Description: Interactive two-section team showcase (Board & Team) for Elementor with card grid, modal popup, and "Other Members" navigation.
 * Version: 1.0.1
 *  Author: Agornyrah Eric
 * Text Domain: remcash-team
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'REMCASH_TEAM_VERSION', '1.0.0' );
define( 'REMCASH_TEAM_PATH', plugin_dir_path( __FILE__ ) );
define( 'REMCASH_TEAM_URL',  plugin_dir_url( __FILE__ ) );

class Remcash_Team {

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function init() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'wp_enqueue_scripts',          [ $this, 'enqueue_scripts' ] );
    }

    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'remcash-team' ),
            '<strong>' . esc_html__( 'Remcash Team', 'remcash-team' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'remcash-team' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_missing_widget_file() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            esc_html__( '"%1$s" could not load a required file: %2$s. Please reinstall or restore the plugin files.', 'remcash-team' ),
            '<strong>' . esc_html__( 'Remcash Team', 'remcash-team' ) . '</strong>',
            '<strong>widget/remcash_team_widget.php</strong>'
        );
        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_missing_widget_class() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            esc_html__( '"%1$s" could not register its widget because the class %2$s was not found. Please check the plugin files.', 'remcash-team' ),
            '<strong>' . esc_html__( 'Remcash Team', 'remcash-team' ) . '</strong>',
            '<strong>Remcash_Team_Widget</strong>'
        );
        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function register_widgets( $widgets_manager ) {
        $widget_file = REMCASH_TEAM_PATH . 'widget/remcash_team_widget.php';

        if ( file_exists( $widget_file ) ) {
            require_once $widget_file;
            if ( class_exists( 'Remcash_Team_Widget' ) ) {
                $widgets_manager->register( new \Remcash_Team_Widget() );
            } else {
                add_action( 'admin_notices', [ $this, 'admin_notice_missing_widget_class' ] );
                error_log( 'Remcash Team: widget class Remcash_Team_Widget not found in ' . $widget_file );
            }
        } else {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_widget_file' ] );
            error_log( 'Remcash Team: widget file missing: ' . $widget_file );
        }
    }

    public function enqueue_scripts() {
        $css_ver = file_exists( REMCASH_TEAM_PATH . 'assets/css/remcash_team.css' ) ? filemtime( REMCASH_TEAM_PATH . 'assets/css/remcash_team.css' ) : REMCASH_TEAM_VERSION;
        $js_ver  = file_exists( REMCASH_TEAM_PATH . 'assets/js/remcash_team.js' )  ? filemtime( REMCASH_TEAM_PATH . 'assets/js/remcash_team.js' )  : REMCASH_TEAM_VERSION;

        wp_enqueue_style(
            'remcash-team',
            REMCASH_TEAM_URL . 'assets/css/remcash_team.css',
            [ 'elementor-frontend' ],
            $css_ver
        );

        wp_enqueue_script(
            'remcash-team',
            REMCASH_TEAM_URL . 'assets/js/remcash_team.js',
            [ 'jquery', 'elementor-frontend' ],
            $js_ver,
            true
        );
    }
}

Remcash_Team::instance();
