<?php
/**
 * delete_sale.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
?>
<?php
$d_sale = find_by_id('sales', (int)$_GET['id']);

if (!$d_sale) {
	$session->msg("d", "ID vente manquante.");
	redirect('../sales/sales.php');
}
// increase - add inventory back to stock
if ( increase_product_qty( $d_sale['qty'], $d_sale['product_id']) ) {
	$delete_id = delete_by_id('sales', (int)$d_sale['id']);
}

if ($delete_id) {
	$session->msg("s", "Vente supprimée.");
	redirect('../sales/sales.php');
} else {
	$session->msg("d", "Suppression de la vente a échouée.");
	redirect('../sales/sales.php');
}

?>
