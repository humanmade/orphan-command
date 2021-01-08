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
 * List and delete orphan WordPress entities and metadata.
 *
 * ## EXAMPLES
 *
 *     # List all orphan comments of any comment type.
 *     $ wp orphan comment
 *     2,5
 *
 *     # List all orphan comment metadata as table.
 *     $ wp orphan commentmeta --format=table
 *     +----+
 *     | ID |
 *     +----+
 *     | 4  |
 *     | 8  |
 *     +----+
 *
 *     # Count all orphan posts.
 *     $ wp orphan post --type=post --format=count
 *     1
 *
 *     # Delete all orphan post metadata.
 *     $ wp orphan postmeta --delete
 *     15,16
 *     Deleting 2 items...
 *     Success: Done.
 */
class Orphan_Command extends WP_CLI_Command {

	/**
	 * List (or delete) orphan blog metadata.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan blogmeta
	 *     23,42
	 *
	 *     # List all orphan blog metadata as table.
	 *     $ wp orphan blogmeta --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 23 |
	 *     | 42 |
	 *     +----+
	 *
	 *     # Count all orphan blog metadata.
	 *     $ wp orphan blogmeta --format=count
	 *     2
	 *
	 *     # Delete all orphan blog metadata.
	 *     $ wp orphan blogmeta --delete
	 *     23,42
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function blogmeta( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan comments.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan comment
	 *     2,5
	 *
	 *     # List all orphan pages as table.
	 *     $ wp orphan comment --type=reaction --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 2  |
	 *     +----+
	 *
	 *     # Count all orphan comments.
	 *     $ wp orphan comment --type=comment --format=count
	 *     1
	 *
	 *     # Delete all orphan comments of any comment type.
	 *     $ wp orphan comment --delete
	 *     2,5
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function comment( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan comment metadata.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan commentmeta
	 *     4,8
	 *
	 *     # List all orphan comment metadata as table.
	 *     $ wp orphan commentmeta --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 4  |
	 *     | 8  |
	 *     +----+
	 *
	 *     # Count all orphan comment metadata.
	 *     $ wp orphan commentmeta --format=count
	 *     2
	 *
	 *     # Delete all orphan comment metadata.
	 *     $ wp orphan commentmeta --delete
	 *     4,8
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function commentmeta( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan posts.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan post
	 *     19,84
	 *
	 *     # List all orphan pages as table.
	 *     $ wp orphan post --type=page --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 84 |
	 *     +----+
	 *
	 *     # Count all orphan revisions.
	 *     $ wp orphan post --type=revision --format=count
	 *     1
	 *
	 *     # Delete all orphan posts of any post type.
	 *     $ wp orphan post --delete
	 *     19,84
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function post( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan post metadata.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan postmeta
	 *     15,16
	 *
	 *     # List all orphan post metadata as table.
	 *     $ wp orphan postmeta --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 15 |
	 *     | 16 |
	 *     +----+
	 *
	 *     # Count all orphan post metadata.
	 *     $ wp orphan postmeta --format=count
	 *     2
	 *
	 *     # Delete all orphan post metadata.
	 *     $ wp orphan postmeta --delete
	 *     15,16
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function postmeta( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan term metadata.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan termmeta
	 *     66,69
	 *
	 *     # List all orphan term metadata as table.
	 *     $ wp orphan termmeta --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 66 |
	 *     | 69 |
	 *     +----+
	 *
	 *     # Count all orphan term metadata.
	 *     $ wp orphan termmeta --format=count
	 *     2
	 *
	 *     # Delete all orphan term metadata.
	 *     $ wp orphan termmeta --delete
	 *     66,69
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function termmeta( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * List (or delete) orphan user metadata.
	 *
	 * ## OPTIONS
	 *
	 * [--delete]
	 * : Delete all orphans.
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
	 *     $ wp orphan usermeta
	 *     77,99
	 *
	 *     # List all orphan user metadata as table.
	 *     $ wp orphan usermeta --format=table
	 *     +----+
	 *     | ID |
	 *     +----+
	 *     | 77 |
	 *     | 99 |
	 *     +----+
	 *
	 *     # Count all orphan user metadata.
	 *     $ wp orphan usermeta --format=count
	 *     2
	 *
	 *     # Delete all orphan user metadata.
	 *     $ wp orphan usermeta --delete
	 *     77,99
	 *     Deleting 2 items...
	 *     Success: Done.
	 *
	 * @param array $args       Parameters passed to command (in the original order).
	 * @param array $assoc_args Parameters passed to command (named).
	 */
	public function usermeta( array $args, array $assoc_args ): void {

		$this->process_( $assoc_args, __FUNCTION__ );
	}

	/**
	 * Process orphans for the given entity type.
	 *
	 * @param array  $assoc_args Parameters passed to command.
	 * @param string $entity     Entity type such as "post" or "termmeta".
	 */
	private function process_( array $assoc_args, string $entity ): void {
		global $wpdb;

		[ $table, $field, $ref, $foreign_table, $foreign_field, $type_field ] = $this->get_query_refs( $entity );

		$query = <<<SQL
SELECT {$field}
FROM {$table}
WHERE {$ref} != 0
  AND {$ref} NOT IN (
    SELECT {$foreign_field}
    FROM {$foreign_table}
  )
SQL;

		$type = trim( get_flag_value( $assoc_args, 'type', '' ) );
		if ( $type && $type_field ) {
			$types = array_map( 'sanitize_key', explode( ',', $type ) );
			$query .= "\n  AND {$type_field} IN ('" . implode( "','", $types ) . "')";
		}

		$delete = (bool) get_flag_value( $assoc_args, 'delete', false );

		$format = $delete ? 'ids' : get_flag_value( $assoc_args, 'format', 'ids' );

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- All user data has been sanitized.
		$results = $format === 'ids' ? $wpdb->get_col( $query ) : $wpdb->get_results( $query );

		format_items( $format, $results, $field );

		if ( $delete && $results ) {
			$this->delete_( $entity, $results );

			WP_CLI::success( __( 'Done.', 'orphan-command' ) );
		}
	}

	/**
	 * Delete all orphans for the given entity type and IDs.
	 *
	 * @param string $entity Entity type such as "post" or "termmeta".
	 * @param array  $ids    Item IDs.
	 */
	private function delete_( string $entity, array $ids ): void {

		WP_CLI::log( '' );

		$count = count( $ids );

		WP_CLI::log( sprintf(
			_n( 'Deleting %d item...', 'Deleting %d items...', $count, 'orphan-command' ),
			$count
		) );

		switch ( $entity ) {
			case 'blogmeta':
			case 'commentmeta':
			case 'postmeta':
			case 'termmeta':
			case 'usermeta':
				$meta_type = substr( $entity, 0, -4 );

				$delete = function ( $id ) use ( $meta_type ): bool {
					return (bool) delete_metadata_by_mid( $meta_type, $id );
				};
				break;

			case 'comment':
				$delete = function ( $id ): bool {
					return (bool) wp_delete_comment( $id, true );
				};
				break;

			case 'post':
				$delete = function ( $id ): bool {
					return (bool) wp_delete_post( $id, true );
				};
				break;

			default:
				// Invalid type! This should not happen, but hey.
				return;
		}

		foreach ( $ids as $id ) {
			if ( ! $delete( $id ) ) {
				WP_CLI::error( sprintf(
					__( 'Could not delete %s with ID %d!', 'orphan-command' ),
					$entity,
					$id
				) );
			}
		}
	}

	/**
	 * Return the references needed for querying the given entity type.
	 *
	 * @param string $entity Entity type such as "post" or "termmeta".
	 *
	 * @return string[] Database table and column names.
	 */
	private function get_query_refs( string $entity ): array {
		global $wpdb;

		switch ( $entity ) {
			case 'blogmeta':
				return [
					$wpdb->blogmeta,
					'meta_id',
					'blog_id',
					$wpdb->blogs,
					'blog_id',
					'',
				];

			case 'comment':
				return [
					$wpdb->comments,
					'comment_id',
					'comment_post_ID',
					$wpdb->posts,
					'ID',
					'comment_type',
				];

			case 'commentmeta':
				return [
					$wpdb->commentmeta,
					'meta_id',
					'comment_id',
					$wpdb->comments,
					'comment_ID',
					'',
				];

			case 'post':
				return [
					$wpdb->posts,
					'ID',
					'post_parent',
					$wpdb->posts,
					'ID',
					'post_type',
				];

			case 'postmeta':
				return [
					$wpdb->postmeta,
					'meta_id',
					'post_id',
					$wpdb->posts,
					'ID',
					'',
				];

			case 'termmeta':
				return [
					$wpdb->termmeta,
					'meta_id',
					'term_id',
					$wpdb->terms,
					'term_id',
					'',
				];

			case 'usermeta':
				return [
					$wpdb->usermeta,
					'umeta_id',
					'user_id',
					$wpdb->users,
					'ID',
					'',
				];
		}

		return [];
	}
}
