<?php
/**
 * reports/stock_report.php
 *
 * @package default
 */


?>

<?php
/**
 * stock_report.php
 *
 * @package default
 */
$page_title = 'Rapport du stock';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
$all_categories = find_all('categories');
if ( isset($_POST['update_category'] ) ) {
	$products = find_products_by_category((int)$_POST['product-category']);
} else {
	$products = join_product_table();
}

?>

<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron text-center">
      <h3>Rapport du stock</h3>
          <form class="clearfix" method="post" action="stock_report_process.php">
            <div class="form-group">
              <label class="form-label">Categorie</label>
                    <select class="form-control" name="product-category">
                      <option value="">Toutes les Categories</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
             </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary"style="background-color:rgb(255, 143, 99)"
                 >Générer le rapport</button>
            </div>
          </div>

          </form>
      </div>
    </div>
  </div>
</div>

<?php include_once '../layouts/footer.php'; ?>
