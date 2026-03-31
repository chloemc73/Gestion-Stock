<?php
/**
 * delete_log_by_ip.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);

if ( isset($_GET['ip']) ) {
	$remote_ip = filter_var($_GET['ip'], FILTER_VALIDATE_IP);

	$delete_id = delete_by_ip('log', $remote_ip);
	if ( $delete_id ) {
		$session->msg("s", "Journaux supprimés.");
		redirect('../users/log.php');
	} else {
		$session->msg("d", "Suppression du journal a échoué.");
		redirect('../users/log.php');
	}

} else {
	$session->msg("d", "ID journal manquant.");
	redirect('../users/log.php');
}
