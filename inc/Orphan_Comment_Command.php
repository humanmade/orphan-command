<?php
/**
 * Orphan comments WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

use function WP_CLI\Utils\get_flag_value;

/**
 * List and delete orphan comments.
 *
 * ## EXAMPLES
 *
 *     # List all orphan comments of any comment type.
 *     $ wp orphan comment list
 *     19,84
 *
 *     # List all orphan reactions.
 *     $ wp orphan comment list --type=reaction
 *     84
 *
 *     # Count all orphan comments.
 *     $ wp orphan comment list --type=comment --format=count
 *     1
 *
 *     # Delete all orphan comments of any comment type.
 *     $ wp orphan comment delete
 *     Deleting 2 items...
 *     Success: Done.
 *
 *     # Delete all orphan reactions.
 *     $ wp orphan comment delete --type=reaction
 *     Deleting 1 item...
 *     Success: Done.
 */
class Orphan_Comment_Command extends Orphan_Command {

	/**
	 * @var string
	 */
	protected $column_type;

	/**
	 * Set up class properties.
	 */
	public function __construct() {
		global $wpdb;

		$this->column_id = 'comment_id';
		$this->column_ref = 'comment_post_ID';
		$this->column_type = 'comment_type';
		$this->table = $wpdb->comments;

		$this->column_parent_id = 'ID';
		$this->table_parent = $wpdb->posts;
	}

	/**
	 * List all orphan comments according to the passed parameters.
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
	 * : Comma-separated list of comment type slugs.
	 *
	 * ## EXAMPLES
	 *
	 *     # List all orphan comments of any comment type.
	 *     $ wp orphan comment list
	 *     19,84
	 *
	 *     # List all orphan reactions.
	 *     $ wp orphan comment list --type=reaction
	 *     84
	 *
	 *     # Count all orphan comments.
	 *     $ wp orphan comment list --type=comment --format=count
	 *     1
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function list( array $args, array $assoc_args ): void {

		$this->list_orphans( $assoc_args );
	}

	/**
	 * Delete all orphan comments according to the passed parameters.
	 *
	 * ## OPTIONS
	 *
	 * [--type=<type>]
	 * : Comma-separated list of comment type slugs.
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete all orphan comments of any comment type.
	 *     $ wp orphan comment delete
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 *     # Delete all orphan reactions.
	 *     $ wp orphan comment delete --type=reaction
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
	 * Delete the orphan comment with the given ID.
	 *
	 * @param int $id Orphan ID.
	 *
	 * @return bool Whether or not the orphan comment has been deleted successfully.
	 */
	protected function delete_orphan( int $id ): bool {

		return wp_delete_comment( $id, true );
	}

	/**
	 * Return the MySQL query to fetch orphan comments.
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
