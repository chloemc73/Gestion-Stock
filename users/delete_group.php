<?php
/**
 * delete_group.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>
<?php
$delete_id = delete_by_id('user_groups', (int)$_GET['id']);
if ($delete_id) {
	$session->msg("s", "Se groupe a été supprimé.");
	redirect('../users/group.php');
} else {
	$session->msg("d", "Suppression du groupe a echoué ou il manque des paramètres.");
	redirect('../users/group.php');
}
?>
