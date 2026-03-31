<?php
/**
 * add_sale_by_search.php
 *
 * @package default
 */


$page_title = 'Ajouter la commande par recherche';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
$order_id = 0;

if (isset($_GET['id'])) {
	$order_id = (int)$_GET['id'];
} else {
	$session->msg("d", "ID commande manquante.");
	redirect( ( '../sales/sales_by_order.php?id=' . $order_id ) , false);
}



if (isset($_POST['add_sale'])) {
	$req_fields = array('s_id', 'order_id', 'quantity', 'sale_price');
	validate_fields($req_fields);
	if (empty($errors)) {
		$p_id      = $db->escape((int)$_POST['s_id']);
		$o_id      = $db->escape((int)$_POST['order_id']);
		$s_qty     = $db->escape((int)$_POST['quantity']);

		$product = find_by_id("products", $p_id);
		if ( (int)$product['quantity'] < $s_qty ) {
			$session->msg('d', ' Qunatité insuffisante pour la vente!');
			redirect( ( 'sales_by_order.php?id=' . $order_id ) , false);
		}

		$s_price      = $db->escape($_POST['sale_price']);
		$s_total   = $s_qty * $s_price;

		$date    = make_date();

		$sql  = "INSERT INTO sales (";
		$sql .= " product_id,order_id,qty,price,date";
		$sql .= ") VALUES (";
		//$sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
		$sql .= "'{$p_id}','{$o_id}','{$s_qty}','{$s_total}','{$date}'";
		$sql .= ")";

		if ($db->query($sql)) {
			decrease_product_qty($s_qty, $p_id);
			$session->msg('s', "Vente ajoutée. ");
			redirect( ( '../sales/sales_by_order.php?id=' . $order_id ) , false);
		} else {
			$session->msg('d', ' Désolé, échec de l ajout!');
			redirect( ( '../sales/sales_by_order.php?id=' . $order_id ) , false);
		}
	} else {
		$session->msg("d", $errors);
		redirect( ( '../sales/sales_by_order.php?id=' . $order_id ) , false);
	}
}

$all_categories = find_all('categories');


?>

<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="../sales/add_sale_by_search.php?id=<?php echo $order_id; ?>">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
              >Recherche</button>
            </span>
            <input type="text" class="form-control" name="search"  placeholder=
            "Nom du produit / Référence produit / Description">
         </div>
        </div>
    </form>
  </div>

  <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron text-center">
<a href="../sales/sales_by_order.php?id=<?php echo $order_id;?>">
<h3>Commande: #<?php echo $order_id; ?></h3></a>

      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Ajouter la vente à la commande #<?php echo $order_id; ?></span>
       </strong>
          <div class="pull-right">
            <a href="../sales/add_sale_to_order.php?id=<?php echo $order_id; ?>"
             class="btn btn-success">Ajouter la ventes par categorie</a>
          </div>
      </div>
      <div class="panel-body">
         <table class="table table-bordered">
           <thead>
            <th class="text-center" style="width: 15px;"> Produit </th>
            <th class="text-center" style="width: 50px;"> Photo </th>
            <th class="text-center" style="width: 15px;"> Référence produit </th>
            <!-- <th class="text-center" style="width: 50px;"> Disponible</th>-->
            <th class="text-center" style="width: 50px;"> Disponible</th>
            <th class="text-center" style="width: 15px;"> Quantité</th>
            <th class="text-center" style="width: 50px;"> Prix</th>
            <th class="text-center" style="width: 50px;"> Actions</th>
           </thead>

<?php

$sales = find_sales_by_order_id( $order_id );

// Remplir tous les produits
if (isset($_POST['search']) && strlen($_POST['search'])) {
	$product_search = remove_junk($db->escape($_POST['search']));
	$products_available = find_all_product_info_by_search($product_search);

	foreach ( $products_available as $product ) {
		$added_to_order = false;
		foreach ( $sales as $sale ) {
			if ( $product['name'] == $sale['name'] ) { // Déjà ajouté à la commande
				$added_to_order = true;
			}
		}

		if ( $added_to_order == false ) {

?>
        <form method="post" action="../sales/add_sale_by_search.php?id=<?php echo $order_id; ?>">

<tr>
<td id="s_name">
<?php echo $product['name'];?>
</td>
                <td>
                  <?php if ($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="../uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="../uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
<td class="text-center">
<?php echo $product['sku']; ?>
</td>
<td class="text-center">
<?php echo $product['location']; ?>
</td>
<input type="hidden" name="s_id" value="<?php echo $product['id']; ?>">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
<input type="hidden" class="form-control" name="sale_price" value="<?php echo $product['sale_price']; ?>">

<td class="text-center">
<?php echo $product['quantity']; ?>
</td>
<td id="s_qty">

                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="quantity" placeholder="Quantité Produit">
                  </div>
                 </div>

</td>
<td id="s_price">
<?php echo formatcurrency( $product['sale_price'], $CURRENCY_CODE); ?>
</td>
<td>
<button type="submit" name="add_sale" class="btn btn-primary">
Ajouter la vente
</button>
</td>
</tr>
       </form>
<?php
		}
	}
}

?>



		     </tbody>
         </table>
      </div>
    </div>

  </div>
</div>

<?php include_once '../layouts/footer.php'; ?>
