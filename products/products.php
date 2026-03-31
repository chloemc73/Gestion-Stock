<?php
/**
 * products.php
 *
 * @package default
 */


$page_title = 'Tous les produits';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);

$all_categories = find_all('categories');
$selected_category = 0;
if ( isset( $_POST['product-category'] ) ) { $selected_category = (int)$_POST['product-category']; }
if ( ( isset($_POST['update_category'] ) ) && ( $selected_category > 0 ) ) {
	$products = find_products_by_category($selected_category);
} else {
	$products = join_product_table();
}
?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
            <button type="submit" name="update_category" class="btn btn-primary"
             style="background-color:rgb(255, 143, 99)">Modifier la categorie</button>
            </span>
                    <select class="form-control" name="product-category">
                      <option value="0">Sélectionner une catégorie de produit.</option>
		    <?php
foreach ($all_categories as $cat) {
	echo "<option value=\"";
	echo (int)$cat['id'];
	if ( (int)$cat['id'] == $selected_category ) { echo "\" selected>"; } else { echo "\">"; }
	echo $cat['name'];
}
?>
                    </select>

         </div>
        </div>
    </form>
  </div>

  <div class="col-md-6">
</div>


</div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>
 <?php
if ( ( isset($_POST['update_category'] ) ) && ( $selected_category > 0 ) ) {
	echo "Products by Category";
} else {
	echo "All Products";
}
?>
            </span>
          </strong>
          <div class="pull-right">
            <a href="../products/add_product.php" class="btn btn-primary" 
            style="background-color:rgb(255, 143, 99)">Ajouter un produit</a>
          </div>
        </div>
        <div class="panel-body">


          <table class="table table-bordered table-striped">
            <thead>
              <tr>
<!--     *************************     -->
                <th> Produit </th>
                <th> Photo</th>
                <th class="text-center" style="width: 10%;"> Référence produit</th>
                <th class="text-center" style="width: 10%;"> Categorie</th>
                <th class="text-center" style="width: 10%;"> Disponible </th>
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Prix de revient</th>
                <th class="text-center" style="width: 10%;"> Prix de vente</th>
                <th class="text-center" style="width: 10%;">Produit ajouté.</th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
<!--     *************************     -->
            </thead>
            <tbody>
<!--     *************************     -->
              <?php foreach ($products as $product):?>
              <tr>

                <td><a href="../products/view_product.php?id=<?php echo (int)$product['id'];?>">
                  <?php echo $product['name']; ?></a></td>

                <td>
                  <?php if ($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="../uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="../uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td class="text-center"><?php echo $product['sku'];?></td>
                <td class="text-center"> <?php echo $product['category']; ?></td>
                <td class="text-center"> <?php echo $product['location']; ?></td>
                <td class="text-center"> <?php echo $product['quantity']; ?></td>
                <td class="text-center"> <?php echo formatcurrency( $product['buy_price'], $CURRENCY_CODE); ?></td>
                <td class="text-center"> <?php echo formatcurrency( $product['sale_price'], $CURRENCY_CODE); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
<!--     *************************     -->
                <td class="text-center">
                  <div class="btn-group">
					<a href="../products/add_stock.php?id=<?php echo (int)$product['id'];?>"  class="btn btn-xs btn-warning"
           data-toggle="tooltip" title="Ajouter">
					  <span class="glyphicon glyphicon-th-large"></span>
					</a>
                    <a href="../products/edit_product.php?id=<?php echo (int)$product['id'];?>"
                     class="btn btn-info btn-xs"  title="Modifier" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="../products/delete_product.php?id=<?php echo (int)$product['id'];?>" 
                    onClick="return confirm('Êtes-vous sûr de vouloir supprimer?')" class="btn btn-danger btn-xs" 
                     title="Supprimer" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
<!--     *************************     -->
              </tr>
             <?php endforeach; ?>
<!--     *************************     -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once '../layouts/footer.php'; ?>
