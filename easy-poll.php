<?php
/**
 * Plugin Name:     Easy Poll
 * Plugin URI:      https://shewazone.com/products/easy-poll
 * Description:     A simple plugin for creating polls, survey, user's feedback management system
 * Author:          Shewa
 * Author URI:      https://shewazone.com
 * Text Domain:     easy-poll
 * Domain Path:     /languages
 * Version:         1.2.2
 *
 * @package         EasyPoll
 */

use EasyPoll\Admin\Admin;
use EasyPoll\Assets\Enqueue;
use EasyPoll\CustomPosts\InitCustomPosts;
use EasyPoll\Database\EasyPollFeedback;
use EasyPoll\Database\EasyPollFields;
use EasyPoll\Database\EasyPollOptions;
use EasyPoll\ErrorHandler\Init as ErrorHandlerInit;
use EasyPoll\FormBuilder\FormClient;
use EasyPoll\Metabox\MetaboxInit;
use EasyPoll\PollHandler\PollHandler;
use EasyPoll\Report\Report;
use EasyPoll\Settings\Options;
use EasyPoll\Settings\Settings;
use EasyPoll\ShortCodes\ShortCodes;

if ( ! class_exists( 'EasyPoll' ) ) {

	/**
	 * Evaluation form main class that trigger the plugin
	 */
	final class EasyPoll {

		/**
		 * Plugin meta data
		 *
		 * @since v1.0.0
		 *
		 * @var $plugin_data
		 */
		private static $plugin_data = array();

		/**
		 * Plugin instance
		 *
		 * @since v1.0.0
		 *
		 * @var $instance
		 */
		public static $instance = null;

		/**
		 * Register hooks and load dependent files
		 *
		 * @since v1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
				include_once __DIR__ . '/vendor/autoload.php';
			}
			register_activation_hook( __FILE__, array( __CLASS__, 'register_activation' ) );
			register_deactivation_hook( __FILE__, array( __CLASS__, 'register_deactivation' ) );
			add_action( 'init', array( __CLASS__, 'load_textdomain' ) );

			$this->load_packages();
		}

		/**
		 * Cloning and un-serialization are not permitted for singletons.
		 */
		protected function __clone() { }

		public function __wakeup() {
			throw new \Exception( 'Cannot unserialize singleton' );
		}

		/**
		 * Plugin meta data
		 *
		 * @since v1.0.0
		 *
		 * @return array  contains plugin meta data
		 */
		public static function plugin_data(): array {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$plugin_data = get_plugin_data(
				__FILE__
			);
			array_push( self::$plugin_data, $plugin_data );

			self::$plugin_data['plugin_url']   = plugin_dir_url( __FILE__ );
			self::$plugin_data['plugin_path']  = plugin_dir_path( __FILE__ );
			self::$plugin_data['base_name']    = plugin_basename( __FILE__ );
			self::$plugin_data['templates']    = trailingslashit( plugin_dir_path( __FILE__ ) . 'templates' );
			self::$plugin_data['views']        = trailingslashit( plugin_dir_path( __FILE__ ) . 'views' );
			self::$plugin_data['assets']       = trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' );
			self::$plugin_data['base_name']    = plugin_basename( __FILE__ );
			self::$plugin_data['nonce_action'] = 'easy-poll-nonce-action';
			self::$plugin_data['nonce']        = 'easy-poll-nonce';
			// set ENV DEV | PROD.
			self::$plugin_data['env'] = 'DEV';
			return self::$plugin_data;
		}

		/**
		 * Create and return instance of this plugin
		 *
		 * @return self  instance of plugin
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Do some stuff after activate plugin
		 *
		 * @return void
		 */
		public static function register_activation() {
			update_option( 'easy_poll_install_time', time() );
			/**
			 * Create tables
			 *
			 * @since v1.0.0
			 */
			$tables = array(
				EasyPollFields::class,
				EasyPollFeedback::class,
				EasyPollOptions::class,
			);

			foreach ( $tables as $table ) {
				$table::create_table();
			}

			// Save default settings options.
			Options::save_default_settings();

			flush_rewrite_rules();
		}

		/**
		 * Do some stuff after deactivate plugin
		 *
		 * @return void
		 */
		public static function register_deactivation() {

		}

		/**
		 * Load plugin text domain
		 *
		 * @return void
		 */
		public static function load_textdomain() {
			load_plugin_textdomain( 'easy-poll', false, trailingslashit( plugin_dir_path( __FILE__ ) ) . 'languages/' );
		}

		/**
		 * Load inital packages
		 *
		 * @return void
		 */
		public function load_packages() {
			new Admin();
			new InitCustomPosts();
			new MetaboxInit();
			new Enqueue();
			new FormClient();
			new PollHandler();
			new Settings();
			new ShortCodes();
			new Report();
			new ErrorHandlerInit();
		}
	}
	// trigger.
	EasyPoll::instance();
}
