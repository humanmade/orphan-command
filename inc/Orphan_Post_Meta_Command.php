<?php
/**
 * Orphan post metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan post metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan post metadata.
 *     $ wp orphan post meta list
 *     15,16
 *
 *     # Count all orphan post metadata.
 *     $ wp orphan post meta list --format=count
 *     2
 *
 *     # Delete all orphan post metadata.
 *     $ wp orphan post meta delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Post_Meta_Command extends Orphan_Meta_Command {

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'meta_id';
		$this->column_ref = 'post_id';
		$this->table = $wpdb->postmeta;

		$this->column_parent_id = 'ID';
		$this->table_parent = $wpdb->posts;

		$this->meta_type = 'post';
	}

	/**
	 * List all orphan post metadata according to the passed parameters.
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
	 * ## EXAMPLES
	 *
	 *     # List all orphan post metadata.
	 *     $ wp orphan post meta list
	 *     15,16
	 *
	 *     # Count all orphan post metadata.
	 *     $ wp orphan post meta list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan post metadata according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan post metadata.
	 *     $ wp orphan post meta delete
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function delete( array $args, array $assoc_args ): void {

		$this->delete_orphans( $assoc_args );
	}
}
