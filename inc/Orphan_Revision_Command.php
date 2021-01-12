<?php
/**
 * Orphan revisions WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan revisions.
 *
 * ## EXAMPLES
 *
 *     # List all orphan revisions.
 *     $ wp orphan revision list
 *     7,27
 *
 *     # Count all orphan revisions.
 *     $ wp orphan revision list --format=count
 *     2
 *
 *     # Delete all orphan revisions.
 *     $ wp orphan revision delete
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Revision_Command extends Orphan_Post_Command {

	/**
	 * List all orphan revisions according to the passed parameters.
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
	 *     # List all orphan revisions.
	 *     $ wp orphan revision list
	 *     7,27
	 *
	 *     # Count all orphan revisions.
	 *     $ wp orphan revision list --format=count
	 *     2
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan revisions according to the passed parameters.
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan revisions.
	 *     $ wp orphan revision delete
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function delete( array $args, array $assoc_args ): void {

		$this->delete_orphans( $assoc_args );
	}

	/**
	 * Delete the orphan revision with the given ID.
	 *
	 * @param int $id Orphan ID.
	 *
	 * @return bool Whether or not the orphan revision has been deleted successfully.
	 */
	protected function delete_orphan( int $id ): bool {

		$deleted = wp_delete_post_revision( $id );

		return $deleted && ! is_wp_error( $deleted );
	}

	/**
	 * Return the MySQL query to fetch orphan revisions.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 *
	 * @return string MySQL query.
	 */
	protected function get_query( array $assoc_args ): string {

		unset( $assoc_args['type'] );

		$query = parent::get_query( $assoc_args );

		$query .= "\n  AND {$this->column_type} = 'revision'";

		return $query;
	}
}
