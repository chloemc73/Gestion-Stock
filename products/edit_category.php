<?php
/**
 * edit_category.php
 *
 * @package default
 */


$page_title = 'Modifier une categorie';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>
<?php
//Afficher toutes les catégories.
$category = find_by_id('categories', (int)$_GET['id']);
if (!$category) {
	$session->msg("d", "ID catégorie manaquant.");
	redirect('../products/categories.php');
}
?>

<?php
if (isset($_POST['edit_cat'])) {
	$req_field = array('category-name');
	validate_fields($req_field);
	$cat_name = remove_junk($db->escape($_POST['category-name']));
	if (empty($errors)) {
		$sql = "UPDATE categories SET name='{$cat_name}'";
		$sql .= " WHERE id='{$category['id']}'";
		$result = $db->query($sql);
		if ($result && $db->affected_rows() === 1) {
			$session->msg("s", "Mise àjour de la catégorie effectuée avec succès");
			redirect('../products/categories.php', false);
		} else {
			$session->msg("d", "Désolé! Echec de la mise à jour");
			redirect('../products/categories.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../products/categories.php', false);
	}
}
?>
<?php include_once '../layouts/header.php'; ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Modifier <?php echo ucfirst($category['name']);?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="../products/edit_category.php?id=<?php echo (int)$category['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="category-name" value="
               <?php echo ucfirst($category['name']);?>">
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Modifier la catégorie</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once '../layouts/footer.php'; ?>
