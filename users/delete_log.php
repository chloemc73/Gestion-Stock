<?php
/**
 * delete_log.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$log = find_by_id('log', $id);
if ( ! $log ) {
	$session->msg("d", "ID journal manquant.");
	redirect('../users/log.php');
}

$delete_id = delete_by_id('log', (int)$log['id']);
if ( $delete_id ) {
	$session->msg("s", "Journaux supprimés.");
	redirect('../users/log.php');
} else {
	$session->msg("d", "Suppression du journal a échoué.");
	redirect('../users/log.php');
}
