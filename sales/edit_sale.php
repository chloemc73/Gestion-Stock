<?php
/**
 * edit_sale.php
 *
 * @package default
 */


$page_title = 'Modifier la commande';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
?>


<?php
$sale = find_by_id('sales', (int)$_GET['id']);
if (!$sale) {
	$session->msg("d", "ID produit manquant.");
	redirect('../sales/sales.php');
}
?>

<?php $product = find_by_id('products', $sale['product_id']); ?>
<?php $order = find_by_id('orders', $sale['order_id']); ?>

<?php

if (isset($_POST['update_sale'])) {
	$req_fields = array('title', 'order_id', 'quantity', 'price', 'total', 'date' );
	validate_fields($req_fields);
	if (empty($errors)) {
		$o_id      = $db->escape((int)$_POST['order_id']);
		$p_id      = $db->escape((int)$product['id']);
		$quantity     = $db->escape((int)$_POST['quantity']);

		$s_qty_diff = 0;
		if ( $quantity != $sale['qty'] ) {
			// Il y a eu un changement dans la quantité
			if ( $quantity > $sale['qty'] ) {
			// augmentation de la quantité vendue et vérification de la disponibilité en stock
				// différence entre la quantité précédente et la nouvelle valeur
				$s_qty_diff = $quantity - $sale['qty'];
				// vérifier la disponibilité en stock
				if ( (int)$product['quantity'] < $s_qty_diff ) {
					$session->msg('d', ' Qunatité insuffisante pour la vente!');
					redirect('../sales/add_sale.php', false);
				} else {
					$decrease_quantity_flag = true;
				}
			}
      // diminution - augmentation du stock vendu
			else if ( $quantity < $sale['qty'] ) {
				// différence entre la quantité précédente et la nouvelle valeur
				$s_qty_diff = $sale['qty'] - $quantity;
				$decrease_quantity_flag = false;
			}
		}

		$s_total   = $db->escape($_POST['total']);
		$date      = $db->escape($_POST['date']);
		$s_date    = date("Y-m-d", strtotime($date));

		$sql  = "UPDATE sales SET";
		$sql .= " order_id= '{$o_id}', product_id= '{$p_id}',qty={$quantity},price='{$s_total}',date='{$s_date}'";
		$sql .= " WHERE id ='{$sale['id']}'";
		$result = $db->query($sql);

		if ( $result && $db->affected_rows() === 1) {
			if ( $s_qty_diff > 0 ) {
				if ( $decrease_quantity_flag ) {
					decrease_product_qty($s_qty_diff, $p_id);
				} else {
					increase_product_qty($s_qty_diff, $p_id);
				}
			}

			$session->msg('s', "La vente a été mise à jour");
			redirect('../sales/edit_sale.php?id='.$sale['id'], false);
		} else {
			$session->msg('d', ' Désolé, la mise à jour a échouée');
			redirect('../sales/sales.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../sales/edit_sale.php?id='.(int)$sale['id'], false);
	}
}

?>
<?php include_once '../layouts/header.php'; ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
<!--     *************************     -->
        <span>Modifier</span>
<!--     *************************     -->
     </strong>
     <div class="pull-right">
<!--     *************************     -->
       <a href="../sales/sales.php" class="btn btn-primary">Afficher toutes les ventes</a>
<!--     *************************     -->
     </div>
    </div>
    <div class="panel-body">
<!--     *************************     -->
       <table class="table table-bordered">
         <thead>
          <th> Commande # </th>
          <th> Produit </th>
          <th> Qantité </th>
          <th> Prix </th>
          <th> Totale </th>
          <th> Date</th>
          <th> Actions</th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="../sales/edit_sale.php?id=<?php echo (int)$sale['id']; ?>">

                <td>
                  <input type="text" class="form-control" name="order_id" value="<?php echo $order['id']; ?>">
                </td>


                <td id="s_name">
                  <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo $product['name']; 
                  ?>">

                  <div id="result" class="list-group"></div>

                </td>
                <td id="s_qty">
                  <input type="text" class="form-control" name="quantity" value="<?php echo (int)$sale['qty']; ?>">
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="price" value="<?php echo $product['sale_price']; ?>" >
                </td>
                <td>
                  <input type="text" class="form-control" name="total" value="<?php echo $sale['price']; ?>">
                </td>
                <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="
                  <?php echo $sale['date']; ?>">
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
                  >Modifier la vente</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>
<!--     *************************     -->

    </div>
  </div>
  </div>
</div>

<?php include_once '../layouts/footer.php'; ?>
