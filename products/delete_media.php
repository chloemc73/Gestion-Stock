<?php
/**
 * delete_media.php
 *
 * @package default
 */


require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
?>
<?php
$find_media = find_by_id('media', (int)$_GET['id']);
$photo = new Media();
if ($photo->media_destroy($find_media['id'], $find_media['file_name'])) {
	$session->msg("s", "La photo a été supprimée.");
	redirect('../products/media.php');
} else {
	$session->msg("d", "Echec d envoi de la photo ou paramètre manquant.");
	redirect('../products/media.php');
}
?>
