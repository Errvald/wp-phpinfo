<?php

/**
 * @wordpress-plugin
 * Plugin Name:       WP PHP Info
 * Description:       This plugin creates a page to show php info
 * Version: 1.0.0
 * Author:            Erevald Kullolli
 * Author URI:        https://errvald.github.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace Errvald\WpPhpinfo;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Root Plugin dir path
 *
 * @since 1.0.0
 * @param string
 */
define( 'PHINFO_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin URL
 *
 * @since 1.0.0
 * @param string
 */
define( 'PHINFO_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin Version
 *
 * @since 1.0.0
 * @param string
 */
define( 'PHINFO_VER', '1.0.0' );

// We load Composer's autoload file
require_once PHINFO_PATH . 'vendor/autoload.php';

// Load instance
$instance = new Plugin();