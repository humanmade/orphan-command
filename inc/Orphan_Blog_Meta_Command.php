<?php
/**
 * Orphan blog metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan blog metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan blog metadata.
 *     $ wp orphan blog meta list
 *     4,8
 *
 *     # Count all orphan blog metadata.
 *     $ wp orphan blog meta list --format=count
 *     2
 *
 *     # Delete all orphan blog metadata.
 *     $ wp orphan blog meta delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Blog_Meta_Command extends Orphan_Meta_Command {

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'meta_id';
		$this->column_ref = 'blog_id';
		$this->table = $wpdb->blogmeta;

		$this->column_parent_id = 'blog_id';
		$this->table_parent = $wpdb->blogs;

		$this->meta_type = 'blog';
	}

	/**
	 * List all orphan blog metadata according to the passed parameters.
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
	 *     # List all orphan blog metadata.
	 *     $ wp orphan blog meta list
	 *     4,8
	 *
	 *     # Count all orphan blog metadata.
	 *     $ wp orphan blog meta list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan blog metadata according to the passed parameters.
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan blog metadata.
	 *     $ wp orphan blog meta delete
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
