<?php
/**
 * Contains utilities static methods
 *
 * @since    v1.0.0
 *
 * @package  EasyPoll\Utilities
 */

namespace EasyPoll\Utilities;

use EasyPoll;
use phpDocumentor\Reflection\Types\Callable_;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Plugin's utilities
 */
class Utilities {

	/**
	 * Load template file
	 *
	 * @param string $template  required template file relative path.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_template( string $template, $data = '', $once = false ) {
		$plugin_data = EasyPoll::plugin_data();
		$template    = trailingslashit( $plugin_data['templates'] ) . $template;
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}

	/**
	 * Load template file
	 *
	 * @param string $template  required views relative path,
	 * path should be before views folder.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_views( string $template, $data = '', $once = false ) {
		$plugin_data = EasyPoll::plugin_data();
		$template    = trailingslashit( $plugin_data['views'] ) . $template;
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}
	/**
	 * Load custom file from any path provided
	 *
	 * @param string $template  provide full path of a file.
	 * @param mixed  $data  data that will be available on the file.
	 * @param bool   $once  if true file will be included once.
	 *
	 * @return void
	 */
	public static function load_file_from_custom_path( string $template, $data = '', $once = false ) {
		if ( file_exists( $template ) ) {
			if ( $once ) {
				include_once $template;
			} else {
				include $template;
			}
		} else {
			echo esc_html( $template . ' file not found' );
		}
	}

	/**
	 * Create nonce field.
	 *
	 * @since v1.0.0
	 *
	 * @return void
	 */
	public static function create_nonce_field() {
		$plugin_data = EasyPoll::plugin_data();
		wp_nonce_field( $plugin_data['nonce_action'], $plugin_data['nonce'] );
	}

	/**
	 * Verify nonce not it verified then die
	 *
	 * @since v1.0.0
	 *
	 * @param bool $die whether to die or not.
	 *
	 * @return bool if die false otherwise it will die
	 */
	public static function verify_nonce( bool $die = true ) {
		$plugin_data = EasyPoll::plugin_data();
		if ( isset( $_POST[ $plugin_data['nonce'] ] ) && ! wp_verify_nonce( $_POST[ $plugin_data['nonce'] ], $plugin_data['nonce_action'] ) ) {
			if ( $die ) {
				die( esc_html_e( 'Easy poll nonce verification failed', 'easy-poll' ) );
			} else {
				return false;
			}
		}
	}

	/**
	 * Sanitize fields
	 *
	 * @since v1.0.0
	 *
	 * @param mixed $data string or array data to sanitize.
	 *
	 * @return mixed return input data after sanitize
	 */
	public static function sanitize( $data ) {
		if ( is_array( $data ) ) {
			$data = array_map(
				function( $value ) {
					return sanitize_text_field( $value );
				},
				$data
			);
		} else {
			$data = sanitize_text_field( $data );
		}
		return $data;
	}

	/**
	 * Get global timezone
	 *
	 * @since 1.0.2
	 *
	 * @return array
	 */
	public static function timezone_lists() {
		return array(
			'Pacific/Midway'                 => '(GMT-11:00) Midway Island, Samoa ',
			'Pacific/Pago_Pago'              => '(GMT-11:00) Pago Pago ',
			'Pacific/Honolulu'               => '(GMT-10:00) Hawaii ',
			'America/Anchorage'              => '(GMT-8:00) Alaska ',
			'America/Vancouver'              => '(GMT-7:00) Vancouver ',
			'America/Los_Angeles'            => '(GMT-7:00) Pacific Time (US and Canada) ',
			'America/Tijuana'                => '(GMT-7:00) Tijuana ',
			'America/Phoenix'                => '(GMT-7:00) Arizona ',
			'America/Edmonton'               => '(GMT-6:00) Edmonton ',
			'America/Denver'                 => '(GMT-6:00) Mountain Time (US and Canada) ',
			'America/Mazatlan'               => '(GMT-6:00) Mazatlan ',
			'America/Regina'                 => '(GMT-6:00) Saskatchewan ',
			'America/Guatemala'              => '(GMT-6:00) Guatemala ',
			'America/El_Salvador'            => '(GMT-6:00) El Salvador ',
			'America/Managua'                => '(GMT-6:00) Managua ',
			'America/Costa_Rica'             => '(GMT-6:00) Costa Rica ',
			'America/Tegucigalpa'            => '(GMT-6:00) Tegucigalpa ',
			'America/Winnipeg'               => '(GMT-5:00) Winnipeg ',
			'America/Chicago'                => '(GMT-5:00) Central Time (US and Canada) ',
			'America/Mexico_City'            => '(GMT-5:00) Mexico City ',
			'America/Panama'                 => '(GMT-5:00) Panama ',
			'America/Bogota'                 => '(GMT-5:00) Bogota ',
			'America/Lima'                   => '(GMT-5:00) Lima ',
			'America/Caracas'                => '(GMT-4:30) Caracas ',
			'America/Montreal'               => '(GMT-4:00) Montreal ',
			'America/New_York'               => '(GMT-4:00) Eastern Time (US and Canada) ',
			'America/Indianapolis'           => '(GMT-4:00) Indiana (East) ',
			'America/Puerto_Rico'            => '(GMT-4:00) Puerto Rico ',
			'America/Santiago'               => '(GMT-4:00) Santiago ',
			'America/Halifax'                => '(GMT-3:00) Halifax ',
			'America/Montevideo'             => '(GMT-3:00) Montevideo ',
			'America/Araguaina'              => '(GMT-3:00) Brasilia ',
			'America/Argentina/Buenos_Aires' => '(GMT-3:00) Buenos Aires, Georgetown ',
			'America/Sao_Paulo'              => '(GMT-3:00) Sao Paulo ',
			'Canada/Atlantic'                => '(GMT-3:00) Atlantic Time (Canada) ',
			'America/St_Johns'               => '(GMT-2:30) Newfoundland and Labrador ',
			'America/Godthab'                => '(GMT-2:00) Greenland ',
			'Atlantic/Cape_Verde'            => '(GMT-1:00) Cape Verde Islands ',
			'Atlantic/Azores'                => '(GMT+0:00) Azores ',
			'UTC'                            => '(GMT+0:00) Universal Time UTC ',
			'Etc/Greenwich'                  => '(GMT+0:00) Greenwich Mean Time ',
			'Atlantic/Reykjavik'             => '(GMT+0:00) Reykjavik ',
			'Africa/Nouakchott'              => '(GMT+0:00) Nouakchott ',
			'Europe/Dublin'                  => '(GMT+1:00) Dublin ',
			'Europe/London'                  => '(GMT+1:00) London ',
			'Europe/Lisbon'                  => '(GMT+1:00) Lisbon ',
			'Africa/Casablanca'              => '(GMT+1:00) Casablanca ',
			'Africa/Bangui'                  => '(GMT+1:00) West Central Africa ',
			'Africa/Algiers'                 => '(GMT+1:00) Algiers ',
			'Africa/Tunis'                   => '(GMT+1:00) Tunis ',
			'Europe/Belgrade'                => '(GMT+2:00) Belgrade, Bratislava, Ljubljana ',
			'CET'                            => '(GMT+2:00) Sarajevo, Skopje, Zagreb ',
			'Europe/Oslo'                    => '(GMT+2:00) Oslo ',
			'Europe/Copenhagen'              => '(GMT+2:00) Copenhagen ',
			'Europe/Brussels'                => '(GMT+2:00) Brussels ',
			'Europe/Berlin'                  => '(GMT+2:00) Amsterdam, Berlin, Rome, Stockholm, Vienna ',
			'Europe/Amsterdam'               => '(GMT+2:00) Amsterdam ',
			'Europe/Rome'                    => '(GMT+2:00) Rome ',
			'Europe/Stockholm'               => '(GMT+2:00) Stockholm ',
			'Europe/Vienna'                  => '(GMT+2:00) Vienna ',
			'Europe/Luxembourg'              => '(GMT+2:00) Luxembourg ',
			'Europe/Paris'                   => '(GMT+2:00) Paris ',
			'Europe/Zurich'                  => '(GMT+2:00) Zurich ',
			'Europe/Madrid'                  => '(GMT+2:00) Madrid ',
			'Africa/Harare'                  => '(GMT+2:00) Harare, Pretoria ',
			'Europe/Warsaw'                  => '(GMT+2:00) Warsaw ',
			'Europe/Prague'                  => '(GMT+2:00) Prague Bratislava ',
			'Europe/Budapest'                => '(GMT+2:00) Budapest ',
			'Africa/Tripoli'                 => '(GMT+2:00) Tripoli ',
			'Africa/Cairo'                   => '(GMT+2:00) Cairo ',
			'Africa/Johannesburg'            => '(GMT+2:00) Johannesburg ',
			'Europe/Helsinki'                => '(GMT+3:00) Helsinki ',
			'Africa/Nairobi'                 => '(GMT+3:00) Nairobi ',
			'Europe/Sofia'                   => '(GMT+3:00) Sofia ',
			'Europe/Istanbul'                => '(GMT+3:00) Istanbul ',
			'Europe/Athens'                  => '(GMT+3:00) Athens ',
			'Europe/Bucharest'               => '(GMT+3:00) Bucharest ',
			'Asia/Nicosia'                   => '(GMT+3:00) Nicosia ',
			'Asia/Beirut'                    => '(GMT+3:00) Beirut ',
			'Asia/Damascus'                  => '(GMT+3:00) Damascus ',
			'Asia/Jerusalem'                 => '(GMT+3:00) Jerusalem ',
			'Asia/Amman'                     => '(GMT+3:00) Amman ',
			'Europe/Moscow'                  => '(GMT+3:00) Moscow ',
			'Asia/Baghdad'                   => '(GMT+3:00) Baghdad ',
			'Asia/Kuwait'                    => '(GMT+3:00) Kuwait ',
			'Asia/Riyadh'                    => '(GMT+3:00) Riyadh ',
			'Asia/Bahrain'                   => '(GMT+3:00) Bahrain ',
			'Asia/Qatar'                     => '(GMT+3:00) Qatar ',
			'Asia/Aden'                      => '(GMT+3:00) Aden ',
			'Africa/Khartoum'                => '(GMT+3:00) Khartoum ',
			'Africa/Djibouti'                => '(GMT+3:00) Djibouti ',
			'Africa/Mogadishu'               => '(GMT+3:00) Mogadishu ',
			'Europe/Kiev'                    => '(GMT+3:00) Kiev ',
			'Asia/Dubai'                     => '(GMT+4:00) Dubai ',
			'Asia/Muscat'                    => '(GMT+4:00) Muscat ',
			'Asia/Tehran'                    => '(GMT+4:30) Tehran ',
			'Asia/Kabul'                     => '(GMT+4:30) Kabul ',
			'Asia/Baku'                      => '(GMT+5:00) Baku, Tbilisi, Yerevan ',
			'Asia/Yekaterinburg'             => '(GMT+5:00) Yekaterinburg ',
			'Asia/Tashkent'                  => '(GMT+5:00) Tashkent ',
			'Asia/Karachi'                   => '(GMT+5:00) Islamabad, Karachi ',
			'Asia/Calcutta'                  => '(GMT+5:30) India ',
			'Asia/Kolkata'                   => '(GMT+5:30) Mumbai, Kolkata, New Delhi ',
			'Asia/Kathmandu'                 => '(GMT+5:45) Kathmandu ',
			'Asia/Novosibirsk'               => '(GMT+6:00) Novosibirsk ',
			'Asia/Almaty'                    => '(GMT+6:00) Almaty ',
			'Asia/Dacca'                     => '(GMT+6:00) Dacca ',
			'Asia/Dhaka'                     => '(GMT+6:00) Astana, Dhaka ',
			'Asia/Krasnoyarsk'               => '(GMT+7:00) Krasnoyarsk ',
			'Asia/Bangkok'                   => '(GMT+7:00) Bangkok ',
			'Asia/Saigon'                    => '(GMT+7:00) Vietnam ',
			'Asia/Jakarta'                   => '(GMT+7:00) Jakarta ',
			'Asia/Irkutsk'                   => '(GMT+8:00) Irkutsk, Ulaanbaatar ',
			'Asia/Shanghai'                  => '(GMT+8:00) Beijing, Shanghai ',
			'Asia/Hong_Kong'                 => '(GMT+8:00) Hong Kong ',
			'Asia/Taipei'                    => '(GMT+8:00) Taipei ',
			'Asia/Kuala_Lumpur'              => '(GMT+8:00) Kuala Lumpur ',
			'Asia/Singapore'                 => '(GMT+8:00) Singapore ',
			'Australia/Perth'                => '(GMT+8:00) Perth ',
			'Asia/Yakutsk'                   => '(GMT+9:00) Yakutsk ',
			'Asia/Seoul'                     => '(GMT+9:00) Seoul ',
			'Asia/Tokyo'                     => '(GMT+9:00) Osaka, Sapporo, Tokyo ',
			'Australia/Darwin'               => '(GMT+9:30) Darwin ',
			'Australia/Adelaide'             => '(GMT+9:30) Adelaide ',
			'Asia/Vladivostok'               => '(GMT+10:00) Vladivostok ',
			'Pacific/Port_Moresby'           => '(GMT+10:00) Guam, Port Moresby ',
			'Australia/Brisbane'             => '(GMT+10:00) Brisbane ',
			'Australia/Sydney'               => '(GMT+10:00) Canberra, Melbourne, Sydney ',
			'Australia/Hobart'               => '(GMT+10:00) Hobart ',
			'Asia/Magadan'                   => '(GMT+10:00) Magadan ',
			'SST'                            => '(GMT+11:00) Solomon Islands ',
			'Pacific/Noumea'                 => '(GMT+11:00) New Caledonia ',
			'Asia/Kamchatka'                 => '(GMT+12:00) Kamchatka ',
			'Pacific/Fiji'                   => '(GMT+12:00) Fiji Islands, Marshall Islands ',
			'Pacific/Auckland'               => '(GMT+12:00) Auckland, Wellington',
		);
	}

	/**
	 * Get UTC time from any specific timezone date
	 *
	 * @since 1.1.0
	 *
	 * @param string $datetime  string date time.
	 * @param string $timezone  timezone.
	 * @param string $format    optional date format to get formatted date.
	 *
	 * @return string date time| empty string.
	 */
	public static function get_gmt_date_from_timezone_date( $datetime, $timezone, $format = '' ) {
		if ( ! trim( $datetime ) || ! trim( $timezone ) ) {
			return '';
		}

		if ( '' === $format ) {
			$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
		}
		$datetime = date_create( $datetime, new \DateTimeZone( $timezone ) );
		if ( false === $datetime ) {
			return gmdate( $format, 0 );
		}
		return $datetime->setTimezone( new \DateTimeZone( 'UTC' ) )->format( $format );
	}

	/**
	 * Undocumented function
	 *
	 * @since 1.1.0
	 *
	 * @param string $date date time.
	 * @param string $format date format for return date. If not set
	 * WordPress default datetime format will be used.
	 *
	 * @return string
	 */
	public static function get_translated_date( string $date, $format = '' ) {
		if ( ! $date ) {
			return '';
		}
		if ( '' === $format ) {
			$format = get_option( 'date_format ' ) . ' ' . get_option( 'time_format' );
		}
		return date_i18n( $format, strtotime( $date ) );
	}

	/**
	 * Sanitize array, single or multi dimensional array
	 * Explicitly setup how should a value sanitize by the
	 * sanitize function.
	 *
	 * @see available sanitize func
	 * https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/
	 *
	 * @param array $input array to sanitize.
	 * @param array $sanitize_mapping single dimensional map key value
	 * pair to set up sanitization process. Key name should by inside
	 * input array and the value will be callable func.
	 * For ex: [key1 => sanitize_email, key2 => wp_kses_post ]
	 *
	 * If key not passed then default sanitize_text_field will be used.
	 *
	 * @return array
	 */
	public static function sanitize_array( array $input, array $sanitize_mapping = array() ):array {
		$array = array();

		if ( is_array( $input ) && count( $input ) ) {
			foreach ( $input as $key => $value ) {
				if ( is_array( $value ) ) {
					$array[ $key ] = self::sanitize_array( $value );
				} else {
					$key = sanitize_text_field( $key );

					// If mapping exists then use callback.
					if ( isset( $sanitize_mapping[ $key ] ) ) {
						$callback = $sanitize_mapping[ $key ];
						$value    = call_user_func( $callback, wp_unslash( $value ) );
					} else {
						$value = sanitize_text_field( wp_unslash( $value ) );
					}
					$array[ $key ] = $value;
				}
			}
		}
		return is_array( $array ) && count( $array ) ? $array : array();
	}

	/**
	 * Sanitize post value through callable function
	 *
	 * @param string   $key required $_POST key.
	 * @param callable $callback callable WP sanitize/esc func.
	 * @param string   $default will be returned if key not set.
	 *
	 * @return string
	 */
	public static function sanitize_post_field( string $key, callable $callback = null, $default = '' ) {
		if ( is_null( $callback ) ) {
			$callback = 'sanitize_text_field';
		}
		//phpcs:ignore
		if ( isset( $_POST[ $key ] ) ) {
			return call_user_func( $callback, wp_unslash( $_POST[ $key ] ) ); //phpcs:ignore
		}
		return $default;
	}

	/**
	 * Sanitize get value through callable function
	 *
	 * @param string   $key required $_GET key.
	 * @param callable $callback callable WP sanitize/esc func.
	 * @param string   $default will be returned if key not set.
	 *
	 * @return string
	 */
	public static function sanitize_get_field( string $key, callable $callback = null, $default = '' ) {
		if ( is_null( $callback ) ) {
			$callback = 'sanitize_text_field';
		}
		//phpcs:ignore
		if ( isset( $_GET[ $key ] ) ) {
			return call_user_func( $callback, wp_unslash( $_GET[ $key ] ) ); //phpcs:ignore
		}
		return $default;
	}

	/**
	 * Get allowed tags for using with wp_kses
	 *
	 * @since 1.1.0
	 *
	 * @param array $tags allowed tags.
	 *
	 * @return array
	 */
	public static function allowed_tags( array $tags = array() ):array {
		$default      = array(
			'strong' => true,
			'b'      => true,
			'italic' => true,
			'a'      => array(
				'href'  => true,
				'class' => true,
				'id'    => true,
			),
			'p'      => array(
				'class' => true,
				'id'    => true,
			),
			'span'   => array(
				'class' => true,
			),
		);
		$allowed_tags = wp_parse_args( $tags, $default );
		return $allowed_tags;
	}
}
