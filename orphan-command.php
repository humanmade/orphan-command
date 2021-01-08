<?php
/**
 * Orphan Command
 *
 * @package           HumanMade\OrphanCommand
 * @author            Human Made
 * @copyright         2021 Human Made
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Orphan Command
 * Plugin URI:        https://github.com/humanmade/orphan-command
 * Description:       WP-CLI command to list and delete orphan WordPress entities and metadata.
 * Version:           1.0.0
 * Requires at least: 3.3
 * Requires PHP:      7.2
 * Author:            Human Made
 * Author URI:        https://humanmade.com/
 * Text Domain:       orphan-command
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

$wpcli_orphan_autoloader = __DIR__ . '/vendor/autoload.php';
if ( is_readable( $wpcli_orphan_autoloader ) ) {
	include_once $wpcli_orphan_autoloader;
}
unset( $wpcli_orphan_autoloader );

WP_CLI::add_command( 'orphan', HumanMade\OrphanCommand\Orphan_Command::class );
