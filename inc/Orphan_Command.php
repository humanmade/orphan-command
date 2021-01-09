<?php
/**
 * Orphan WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

use function WP_CLI\Utils\format_items;
use function WP_CLI\Utils\get_flag_value;

use WP_CLI;
use WP_CLI_Command;

/**
 * List and delete orphan entities and metadata.
 */
abstract class Orphan_Command extends WP_CLI_Command {

	/**
	 * @var string
	 */
	protected $column_id;

	/**
	 * @var string
	 */
	protected $column_parent_id;

	/**
	 * @var string
	 */
	protected $column_ref;

	/**
	 * @var string
	 */
	protected $table;

	/**
	 * @var string
	 */
	protected $table_parent;

	/**
	 * Print the MySQL query to list all orphans for the current entity type and according to the passed parameters.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	public function query( array $args, array $assoc_args ): void {

		$query = $this->get_query( $assoc_args );

		WP_CLI::log( $query );
	}

	/**
	 * List all orphans for the current entity type and according to the passed parameters.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	abstract public function list( array $args, array $assoc_args ): void;

	/**
	 * Delete all orphans for the current entity type and according to the passed parameters.
	 *
	 * @param array $args       Parameters passed to the command (original order).
	 * @param array $assoc_args Parameters passed to the command (named).
	 */
	abstract public function delete( array $args, array $assoc_args ): void;

	/**
	 * Delete the orphan with the given ID for the current entity type.
	 *
	 * @param int $id Orphan ID.
	 *
	 * @return bool Whether or not the orphan has been deleted successfully.
	 */
	abstract protected function delete_orphan( int $id ): bool;

	/**
	 * Process orphans for the given entity type.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 */
	protected function list_orphans( array $assoc_args ): void {

		$format = get_flag_value( $assoc_args, 'format', 'ids' );

		$items = $format === 'ids' ? $this->get_ids( $assoc_args ) : $this->get_items( $assoc_args );

		format_items( $format, $items, $this->column_id );
	}

	/**
	 * Delete all orphans for the current entity type.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 */
	protected function delete_orphans( array $assoc_args ): void {

		$ids = $this->get_ids( $assoc_args );
		if ( ! $ids ) {
			WP_CLI::log( __( 'No items found.', 'orphan-command' ) );

			return;
		}

		$count = count( $ids );

		WP_CLI::log( sprintf(
			_n( 'Deleting %d item...', 'Deleting %d items...', $count, 'orphan-command' ),
			$count
		) );

		foreach ( $ids as $id ) {
			if ( ! $this->delete_orphan( $id ) ) {
				WP_CLI::error( sprintf(
					__( 'Could not delete item with ID %d!', 'orphan-command' ),
					$id
				) );
			}
		}

		WP_CLI::success( __( 'Done.', 'orphan-command' ) );
	}

	/**
	 * Return the MySQL query to fetch the orphans for the current entity type.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 *
	 * @return string MySQL query.
	 */
	protected function get_query( array $assoc_args ): string {

		return <<<SQL
SELECT {$this->column_id}
FROM {$this->table}
WHERE {$this->column_ref} != 0
  AND {$this->column_ref} NOT IN (
    SELECT {$this->column_parent_id}
    FROM {$this->table_parent}
  )
SQL;
	}

	/**
	 * Return all orphans.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 *
	 * @return object[] Orphans.
	 */
	private function get_items( array $assoc_args ): array {
		global $wpdb;

		$query = $this->get_query( $assoc_args );

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- All user data has been sanitized.
		return $wpdb->get_results( $query );
	}

	/**
	 * Return all orphan IDs.
	 *
	 * @param array $assoc_args Parameters passed to the command.
	 *
	 * @return int[] Orphan IDs.
	 */
	private function get_ids( array $assoc_args ): array {

		$items = $this->get_items( $assoc_args );

		$ids = array_column( $items, $this->column_id );

		return array_map( 'intval', $ids );
	}
}
