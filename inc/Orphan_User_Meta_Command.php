<?php
/**
 * Orphan user metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan user metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan user metadata.
 *     $ wp orphan user meta list
 *     23,42
 *
 *     # Count all orphan user metadata.
 *     $ wp orphan user meta list --format=count
 *     2
 *
 *     # Delete all orphan user metadata.
 *     $ wp orphan user meta delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_User_Meta_Command extends Orphan_Meta_Command {

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'umeta_id';
		$this->column_ref = 'user_id';
		$this->table = $wpdb->usermeta;

		$this->column_parent_id = 'ID';
		$this->table_parent = $wpdb->users;

		$this->meta_type = 'user';
	}

	/**
	 * List all orphan user metadata according to the passed parameters.
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
	 *     # List all orphan user metadata.
	 *     $ wp orphan user meta list
	 *     23,42
	 *
	 *     # Count all orphan user metadata.
	 *     $ wp orphan user meta list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan user metadata according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan user metadata.
	 *     $ wp orphan user meta delete
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
