<?php
/**
 * Qeury help class contains static helper methods
 *
 * @package EasyPoll\Helpers
 */

namespace EasyPoll\Helpers;

/**
 * This class is for using from derived class.
 * Derived class must have $table_name property.
 *
 * Extend this class and use basic DB query.
 */
class QueryHelper {

	/**
	 * Get a row, wrapper method of wpdb::get_row
	 *
	 * @since v1.0.0
	 *
	 * @see https://developer.wordpress.org/reference/classes/wpdb/#select-a-row
	 *
	 * @param string $table   table name.
	 * @param array $where   key value pair, 1 dimensional array.
	 * ex: array('id' => 10).
	 * @param string $output  return type.
	 *
	 * @return mixed   wpdb::get_row() response
	 */
	public static function get_one( string $table, array $where = array(), $output = 'OBJECT' ) {
		global $wpdb;
		$key    = sanitize_text_field( array_keys( $where )[0] );
		$value  = sanitize_text_field( array_values( $where )[0] );
		$output = sanitize_text_field( $output );
		return $wpdb->get_row(
			"SELECT *
				FROM {$table}
				WHERE $key = '$value'
			",
			$output
		);
	}

	/**
	 * Insert data in the instance table
	 *
	 * @param string $table  table name.
	 * @param array  $data | data to insert in the table.
	 *
	 * @return int, inserted id.
	 *
	 * @since v1.0.0
	 */
	public static function insert( string $table, array $data ): int {
		global $wpdb;
		// Sanitize text field.
		$data = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$data
		);

		$insert = $wpdb->insert(
			$table,
			$data
		);
		return $insert ? $wpdb->insert_id : 0;
	}

	/**
	 * Update data in the instance table
	 *
	 * @param string $table  table name.
	 * @param array  $data | data to update in the table.
	 * @param array  $where | condition array.
	 *
	 * @return bool, true on success false on failure
	 *
	 * @since v1.0.0
	 */
	public static function update( string $table, array $data, array $where ): bool {
		global $wpdb;
		// Sanitize text field.
		$data = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$data
		);

		$where = array_map(
			function( $value ) {
				return sanitize_text_field( $value );
			},
			$where
		);

		$update = $wpdb->update(
			$table,
			$data,
			$where
		);
		return $update ? true : false;
	}

	/**
	 * Delete rows from table
	 *
	 * @param string $table  table name.
	 * @param array  $where  key value pairs.Where key is the name of
	 * column & value is the value to match.
	 * For ex: [ 'id' => 1 ].
	 *
	 * @since v1.0.0
	 */
	public static function delete( string $table, array $where ): bool {
		global $wpdb;
		$delete = $wpdb->delete(
			$table,
			$where
		);
		return $delete ? true : false;
	}

	/**
	 * Delete from table where id not in
	 *
	 * @since v1.0.0
	 *
	 * @param string $table   table name.
	 * @param string $in  comma separated values.
	 *
	 * @return bool
	 */
	public static function delete_where_id_not_in( string $table, string $in ): bool {
		global $wpdb;
		if ( '' === $table || '' === $in ) {
			return false;
		}
		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$delete = $wpdb->query(
			$wpdb->prepare(
				"DELETE
					FROM {$table}
					WHERE id NOT IN ($in)
						AND 1 = %d
				",
				1
			)
		);
		return $delete ? true : false;
	}

	/**
	 * Clean everything from table
	 *
	 * @since v1.0.0
	 *
	 * @param string $table  table name.
	 *
	 * @return bool
	 */
	public static function table_clean( string $table ): bool {
		global $wpdb;
		$delete = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM
					{$table}
					WHERE 1 = %d
				",
				1
			)
		);
		return $delete ? true : false;
	}

	/**
	 * Insert multiple rows without knowing key value
	 *
	 * @since v1.0.0
	 *
	 * @param string $table  table name.
	 * @param array  $request two dimensional array
	 * for ex: [ [id => 1], [id => 2] ].
	 *
	 * @return mixed  wpdb response true or int on success,
	 * false on failure
	 */
	public static function insert_multiple_rows( $table, $request ) {
		global $wpdb;
		$column_keys   = '';
		$column_values = '';
		$sql           = '';
		$last_key      = array_key_last( $request );
		$first_key     = array_key_first( $request );
		foreach ( $request as $k => $value ) {
			$keys = array_keys( $value );

			// Prepare column keys & values.
			foreach ( $keys as $v ) {
				$column_keys   .= sanitize_key( $v ) . ',';
				$sanitize_value = sanitize_text_field( $value[ $v ] );
				$column_values .= is_numeric( $sanitize_value ) ? $sanitize_value . ',' : "'$sanitize_value'" . ',';
			}
			// Trim trailing comma.
			$column_keys   = rtrim( $column_keys, ',' );
			$column_values = rtrim( $column_values, ',' );
			if ( $first_key === $k ) {
				$sql .= "INSERT INTO {$table} ($column_keys) VALUES ($column_values),";
			} elseif ( $last_key == $k ) {
				$sql .= "($column_values)";
			} else {
				$sql .= "($column_values),";
			}

			// Reset keys & values to avoid duplication.
			$column_keys   = '';
			$column_values = '';
		}
		return $wpdb->query( $sql );
	}

	/**
	 * Select with where in condition
	 *
	 * @since v1.0.0
	 *
	 * @param string $table   table name.
	 * @param string $column_keys  comma separated values
	 * for ex: a,b,c.
	 * @param string $where   column name for where clause.
	 * @param string $in  comma separated values as $column_keys.
	 *
	 * @return array  wpdb::get_results response
	 */
	public static function select_all_where_in( string $table, string $column_keys, string $where, string $in ): array {
		$response = array();
		if ( '' === $table || '' === $column_keys || '' === $where || '' === $in ) {
			return $response;
		}
		global $wpdb;
		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					{$column_keys}
					FROM {$table}
					WHERE $where IN ($in)
						AND 1 = %d
				",
				1
			)
		);
	}
}
