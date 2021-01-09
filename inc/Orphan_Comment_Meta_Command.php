<?php
/**
 * Orphan comment metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan comment metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan comment metadata.
 *     $ wp orphan comment meta list
 *     66,99
 *
 *     # Count all orphan comment metadata.
 *     $ wp orphan comment meta list --format=count
 *     2
 *
 *     # Delete all orphan comment metadata.
 *     $ wp orphan comment meta delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Comment_Meta_Command extends Orphan_Meta_Command {

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'meta_id';
		$this->column_ref = 'comment_id';
		$this->table = $wpdb->commentmeta;

		$this->column_parent_id = 'comment_ID';
		$this->table_parent = $wpdb->comments;

		$this->meta_type = 'comment';
	}

	/**
	 * List all orphan comment metadata according to the passed parameters.
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
	 *     # List all orphan comment metadata.
	 *     $ wp orphan comment meta list
	 *     66,99
	 *
	 *     # Count all orphan comment metadata.
	 *     $ wp orphan comment meta list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan comment metadata according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan comment metadata.
	 *     $ wp orphan comment meta delete
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
