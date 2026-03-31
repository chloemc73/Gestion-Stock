<?php
/**
 * delete_stock.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
?>
<?php
$d_stock = find_by_id('stock', (int)$_GET['id']);

if (!$d_stock) {
	$session->msg("d", "ID stock manquant.");
	redirect('../products/stock.php');
}

// Pour chaque vente
// Réduire le stock
if ( decrease_product_qty( $d_stock['quantity'], $d_stock['product_id']) ) {

	$delete_id = delete_by_id('stock', (int)$d_stock['id']);
}

if ($delete_id) {
	$session->msg("s", "stock supprimé.");
	redirect('../products/stock.php');
} else {
	$session->msg("d", "Echec de la suppression du stock.");
	redirect('../products/stock.php');
}

?>
