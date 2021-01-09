<?php
/**
 * Orphan metadata WP CLI command class.
 */

declare( strict_types=1 );

namespace HumanMade\OrphanCommand;

/**
 * List and delete orphan metadata.
 */
abstract class Orphan_Meta_Command extends Orphan_Command {

	/**
	 * @var string
	 */
	protected $meta_type;

	/**
	 * Delete the orphan meta with the given ID.
	 *
	 * @param int $id Orphan ID.
	 *
	 * @return bool Whether or not the orphan meta has been deleted successfully.
	 */
	protected function delete_orphan( int $id ): bool {

		return (bool) delete_metadata_by_mid( $this->meta_type, $id );
	}
}
