<?php
/**
 * edit_product.php
 *
 * @package default
 */


$page_title = 'Modifier le produit';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$product = find_by_id('products', $id);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if (!$product) {
	$session->msg("d", "ID produit manquant.");
	redirect('../products/products.php');
}

if (isset($_POST['edit_product'])) {
	$req_fields = array('product-title', 'product-category', 'product-quantity', 'cost-price', 'sale-price' );
	validate_fields($req_fields);

	if (empty($errors)) {
		if (is_null($_POST['product-sku']) || $_POST['product-sku'] === "") {
			$p_sku  =  '';
		} else {
			$p_sku  = $db->escape(remove_junk($_POST['product-sku']));
		}

		$p_name  = $db->escape(remove_junk($_POST['product-title']));

		if (is_null($_POST['product-desc']) || $_POST['product-desc'] === "") {
			$p_desc  =  'none';
		} else {
			$p_desc  = $db->escape(remove_junk($_POST['product-desc']));
		}

		if (is_null($_POST['product-location']) || $_POST['product-location'] === "") {
			$p_loc  =  'NA';
		} else {
			$p_loc  = $db->escape(remove_junk($_POST['product-location']));
		}

		$p_cat   = (int)$_POST['product-category'];
		$p_qty   = $db->escape(remove_junk($_POST['product-quantity']));
		$p_buy   = $db->escape(remove_junk($_POST['cost-price']));
		$p_sale  = $db->escape(remove_junk($_POST['sale-price']));
		if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
			$media_id = '0';
		} else {
			$media_id = $db->escape(remove_junk($_POST['product-photo']));
		}
		$query   = "UPDATE products SET";
		$query  .=" name ='{$p_name}', description ='{$p_desc}', sku ='{$p_sku}',location ='{$p_loc}', quantity ='{$p_qty}',";
		$query  .=" buy_price ='{$p_buy}',sale_price ='{$p_sale}',category_id ='{$p_cat}',media_id ='{$media_id}'";
		$query  .=" WHERE id ='{$product['id']}'";
		$result = $db->query($query);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', "Mise à jour des informations produits");
			redirect('../products/products.php', false);
		} else {
			$session->msg('d', ' Désolé échec de mise à jour!');
			redirect('../products/edit_product.php?id='.$product['id'], false);
		}

	} else {
		$session->msg("d", $errors);
		redirect('../products/edit_product.php?id='.$product['id'], false);
	}

}

?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<!--     *************************     -->
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
<!--     *************************     -->
            <span>Modifier l'information produit</span>
<!--     *************************     -->
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
           <form method="post" action="../products/edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="
                  <?php echo remove_junk($product['name']);?>" placeholder="Nom du produit">
               </div>
              </div>


              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-desc" value="
                  <?php echo remove_junk($product['description']);?>" placeholder="Description">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-sku" value="
                  <?php echo remove_junk($product['sku']);?>" placeholder="Référence produit">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-location" value="
                  <?php echo remove_junk($product['location']);?>" placeholder="Disponible">
               </div>
              </div>


              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-category">
                    <option value=""> Selectionnez une catégorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>"
                      <?php if ($product['category_id'] === $cat['id']): echo "selectionné"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> Image produit</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" 
                        <?php if ($product['media_id'] === $photo['id']): echo "selectionné"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

	      <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantité</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="
                      <?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="cost-price">Prix de revient</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-piggy-bank"></i>
                      </span>
                      <input type="number" min="0" step="any" class="form-control" name="cost-price" value="
                      <?php echo remove_junk($product['buy_price']);?>">
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="sale-price">Prix de vente</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-piggy-bank"></i>
                       </span>
                       <input type="number" min="0" step="any" class="form-control" name="sale-price" value="
                       <?php echo remove_junk($product['sale_price']);?>">
                    </div>
                   </div>
                  </div>
               </div>

         <div class="pull-right">
              <button type="submit" name="edit_product" class="btn btn-info">Modifier</button>
         </div>

<!--     *************************     -->
          </form>

         </div>
        </div>
      </div>

    </div>
  </div>

<?php include_once '../layouts/footer.php'; ?>
