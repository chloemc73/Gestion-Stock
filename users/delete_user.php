<?php
/**
 * delete_user.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>
<?php
$delete_id = delete_by_id('users', (int)$_GET['id']);
if ($delete_id) {
	$session->msg("s", "Utilisateur supprimé.");
	redirect('../users/users.php');
} else {
	$session->msg("d", "Suppression de l'utilisateur a échoué ou il manque dse paramètres.");
	redirect('../users/users.php');
}
?>
