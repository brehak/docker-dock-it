<?php
/**
 * Plugin Name: Stephen King Books
 * Author : Bray R
 * Version: 1.0.0
 * Description: Manages Stephen King books
 */
namespace SKB;

const TEXT_DOMAIN = 'sk-books-plugin';
define( "SKB\PLUGIN_PATH", plugin_dir_path( __FILE__ ) );

// --- Include Core Classes ---
require_once PLUGIN_PATH . 'classes/Singleton.php';
require_once PLUGIN_PATH . 'classes/BookPostType.php';
require_once PLUGIN_PATH . 'classes/BookTaxonomy.php';
require_once PLUGIN_PATH . 'classes/BookMeta.php';
require_once PLUGIN_PATH . 'classes/ReviewPostType.php';
require_once PLUGIN_PATH . 'classes/ReviewMeta.php';


/**
 * Main plugin manager class.
 * handles activation/deactivation hooks.
 */
class BookManager {
	private static $instance;

	private function __construct() {
		BookPostType::getInstance();
		BookTaxonomy::getInstance();
		BookMeta::getInstance();
		ReviewPostType::getInstance();
		ReviewMeta::getInstance();
	}

	private function __clone() {}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * plugin activation.
	 */
	public static function activate() {
		BookPostType::getInstance()->registerPostType();
		BookTaxonomy::getInstance()->registerGenreTaxonomy();
		flush_rewrite_rules();
	}

	/**
	 * plugin deactivation.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}

$instance = BookManager::getInstance();

// Register activation/deactivation hooks
register_activation_hook( __FILE__, [ 'SKB\BookManager', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'SKB\BookManager', 'deactivate' ] );
