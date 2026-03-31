<?php
/**
 * delete_category.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>
<?php
$category = find_by_id('categories', (int)$_GET['id']);
if (!$category) {
	$session->msg("d", "ID de la catégorie manquante.");
	redirect('../products/categories.php');
}

$products = find_products_by_category((int)$_GET['id']);
if ($products) {
	$session->msg("d", "ID du produit affecté à une catégorie.");
	redirect('../products/categories.php');
}


$delete_id = delete_by_id('categories', (int)$category['id']);
if ($delete_id) {
	$session->msg("s", "Categorie supprimée.");
	redirect('../products/categories.php');
} else {
	$session->msg("d", "Echec de la suppresion de la catégorie.");
	redirect('../products/categories.php');
}
?>
