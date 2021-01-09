<?php
/**
 * Orphan term metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan term metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan term metadata.
 *     $ wp orphan term meta list
 *     11,47
 *
 *     # Count all orphan term metadata.
 *     $ wp orphan term meta list --format=count
 *     2
 *
 *     # Delete all orphan term metadata.
 *     $ wp orphan term meta delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Term_Meta_Command extends Orphan_Meta_Command {

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'meta_id';
		$this->column_ref = 'term_id';
		$this->table = $wpdb->termmeta;

		$this->column_parent_id = 'term_id';
		$this->table_parent = $wpdb->terms;

		$this->meta_type = 'term';
	}

	/**
	 * List all orphan term metadata according to the passed parameters.
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
	 *     # List all orphan term metadata.
	 *     $ wp orphan term meta list
	 *     11,47
	 *
	 *     # Count all orphan term metadata.
	 *     $ wp orphan term meta list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan term metadata according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan term metadata.
	 *     $ wp orphan term meta delete
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
