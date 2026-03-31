<?php
/**
 * delete_product.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
if (!$product) {
	$session->msg("d", "ID produit manquant.");
	redirect('../products/products.php');
}

$all_stock = find_all('stock');
foreach ( $all_stock as $stock ) {
	if ( $stock['product_id'] == $product['id'] ) {
		$session->msg("d", "Veuillez supprimer les enregistrements ou ajouter une quantité négative en stock.");
		redirect('../products/stock.php');
	}
}

$delete_id = delete_by_id('products', (int)$product['id']);
if ($delete_id) {
	$session->msg("s", "Produit supprimée.");
	redirect('../products/products.php');
} else {
	$session->msg("d", "Echec de la suppression du produit.");
	redirect('../products/products.php');
}
?>
