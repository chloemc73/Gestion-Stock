<?php
/**
 * delete_customer.php
 *
 * @package default
 */


require_once '../includes/load.php';
//Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
?>
<?php
$d_customer = find_by_id('customers', (int)$_GET['id']);

if (!$d_customer) {
	$session->msg("d", "ID client manquant.");
	redirect('../customers/customers.php');
}


$delete_id = delete_by_id('customers', (int)$d_customer['id']);

if ($delete_id) {
	$session->msg("s", "Client supprimé.");
	redirect('../customers/customers.php');
} else {
	$session->msg("d", "Échec de la suppression du client.");
	redirect('../customers/customers.php');
}

?>
