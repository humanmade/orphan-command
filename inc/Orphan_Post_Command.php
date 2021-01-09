<?php
/**
 * Orphan posts WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

use function WP_CLI\Utils\get_flag_value;

/**
 * List and delete orphan posts.
 *
 * ## EXAMPLES
 *
 *     # List all orphan posts of any post type.
 *     $ wp orphan post list
 *     2,5
 *
 *     # List all orphan pages.
 *     $ wp orphan post list --type=pages
 *     5
 *
 *     # Count all orphan posts.
 *     $ wp orphan post list --type=post --format=count
 *     1
 *
 *     # Delete all orphan posts of any post type.
 *     $ wp orphan post delete
 *     Deleting 2 items...
 *     Success: Done.
 *
 *     # Delete all orphan pages.
 *     $ wp orphan post delete --type=page
 *     Deleting 1 item...
 *     Success: Done.
 */
class Orphan_Post_Command extends Orphan_Command {

	/**
	 * @var string
	 */
	protected $column_type;

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'ID';
		$this->column_ref = 'post_parent';
		$this->column_type = 'post_type';
		$this->table = $wpdb->posts;

		$this->column_parent_id = 'ID';
		$this->table_parent = $wpdb->posts;
	}

	/**
	 * List all orphan posts according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * [--format=<format>]
	 * : Render output in a particular format.
	 * ---
	 * default: ids
	 * options:
	 *   - count
	 *   - csv
	 *   - ids
	 *   - json
	 *   - table
	 *   - yaml
	 * ---
	 *
	 * [--type=<type>]
	 * : Comma-separated list of post type slugs.
	 *
	 * ## EXAMPLES
	 *
	 *     # List all orphan posts of any post type.
	 *     $ wp orphan post list
	 *     2,5
	 *
	 *     # List all orphan pages.
	 *     $ wp orphan post list --type=page
	 *     5
	 *
	 *     # Count all orphan posts.
	 *     $ wp orphan post list --type=post --format=count
	 *     1
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan posts according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * [--type=<type>]
	 * : Comma-separated list of post type slugs.
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan posts of any post type.
	 *     $ wp orphan post delete
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 *     # Delete all orphan pages.
	 *     $ wp orphan post delete --type=page
	 *     Deleting 1 item...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function delete( array $args, array $assoc_args ): void {

		$this->delete_orphans( $assoc_args );
	}

	/**
	 * Delete the orphan post with the given ID.
	 *
	 * @param int $id Orphan ID.
	 *
	 * @return bool Whether or not the orphan post has been deleted successfully.
	 */
	protected function delete_orphan( int $id ): bool {

		return wp_delete_post( $id, true );
	}

	/**
	 * Return the MySQL query to fetch orphan posts.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 *
	 * @return string MySQL query.
	 */
	protected function get_query( array $assoc_args ): string {

		$query = parent::get_query( $assoc_args );

		$type = trim( get_flag_value( $assoc_args, 'type', '' ) );
		if ( $type ) {
			$types = array_map( 'sanitize_key', explode( ',', $type ) );
			$query .= "\n  AND {$this->column_type} IN ('" . implode( "','", $types ) . "')";
		}

		return $query;
	}
}
