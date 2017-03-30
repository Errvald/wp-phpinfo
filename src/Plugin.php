<?php

namespace Errvald\WpPhpinfo;

/**
 * Plugin class.
 */
class Plugin 
{

    /**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $version    The current version of the plugin.
	 */
	public $version = '1.0.0';

    /**
	 * Page meta data
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $pageMeta
	 */
	public $pageMeta = [
        'name'      => 'WP PhpInfo',
        'slug'      => 'wp-phpinfo',
        'menu_icon' => 'dashicons-dashboard'
    ];

    /**
	 * The minimum requirements for this environment
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $minimums
	 */
	public $minimums = [
        'php_ver' => 5.6,
        'php_met' => 30,
        'mysql'   => 5.5,
        'wp_ver'  => 4
    ];

    /**
	 * Initialize the plugin
	 */
	function __construct() 
    {

        if ( is_admin() ) 
        {
            add_action( 'admin_menu', [$this, 'scan_menu_page'], 25 );
            add_action( 'admin_enqueue_scripts', [$this, 'enqueue_styles'] );
		}

    }


    public function enqueue_styles()
    {

        wp_enqueue_style(
            $this->pageMeta['slug'],
            PHINFO_URL . 'src/assets/css/table.css',
            [],
            1.0,
            FALSE
        );
         
    }

    public function scan_menu_page()
    { 

        add_menu_page(
            $this->pageMeta['name'],
            $this->pageMeta['name'],
            'manage_options',
            $this->pageMeta['slug'],
            [ $this, 'scan_page_view' ],
            $this->pageMeta['menu_icon'],
            20
        );

    }

    public function scan_page_view()
    {

        $tests = [];

        // PHP VERSION
	    $test = [
            'title' => 'PHP Version',
            'value' => phpversion()
        ];

        if ( version_compare( PHP_VERSION, $this->minimums['php_ver'], '<=' ) ) {
            $test['status'] = 'FAIL';
        } else {
            $test['status'] = 'OK';
        }
        array_push( $tests, $test );


        // PHP max_execution_time
        $test = [
        'title'			=> 'PHP max_execution_time',
        'value'			=> ini_get( 'max_execution_time' ),
        ];
        if ( str_ireplace( 's', '', ini_get( 'max_execution_time' ) ) < $this->minimums['php_met'] ) {
            $test['status'] = 'WARNING';
        } else {
            $test['status'] = 'OK';
        }
        array_push( $tests, $test );
 
        // WP VERSION
        global $wp_version;
        $test = [
            'title'			=> 'WordPress Version',
            'value'			=> $wp_version
        ];
        if ( version_compare( $wp_version, $this->minimums['wp_ver'], '<=' ) ) {
            $test['status'] = 'FAIL';
        } else {
            $test['status'] = 'OK';
        }
        array_push( $tests, $test );

        // MYSQL VERSION
        global $wpdb;
        $test = [
            'title' => 'MySQL Version',
            'value' => $wpdb->db_version()
        ];
        if ( version_compare( $wpdb->db_version(), $this->minimums['mysql'], '<=' ) ) {
            $test['status'] = 'FAIL';
        } else {
            $test['status'] = 'OK';
        }
        array_push( $tests, $test );

        include PHINFO_PATH . 'src/views/scan-page.php';

    }


}