<?php
/**
 * add_order.php
 *
 * @package default
 */


$page_title = 'Ajouter la commande';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);

$all_orders = find_all('orders');
$order_id = last_id('orders');
$new_order_id = $order_id['id'] + 1;

?>
<?php
if (isset($_POST['add_order'])) {
	$req_fields = array('customer-name', 'paymethod' );
	validate_fields($req_fields);
	$customer_name = $db->escape($_POST['customer-name']);
	$paymethod = $db->escape($_POST['paymethod']);
	$notes = '';

	if (empty($errors)) {
		if ( ! find_by_name('customers', $customer_name) ) {
			$query  = "INSERT INTO customers (";
			//$query .=" name,address,postcode,telephone,email,paymethod";
			$query .=" name,paymethod";
			$query .=") VALUES (";
			//$query .=" '{$customer}', '{$c_address}', '{$c_postcode}', '{$c_telephone}', '{$c_email}', '{$paymethod}'";
			$query .=" '{$customer_name}', '{$paymethod}'";
			$query .=")";
			$result = $db->query($query);
			if ($result && $db->affected_rows() === 1) {
				$session->msg('s', "Client ajouté! ");
			} else {
				$session->msg('d', ' Désolé, échec de l ajout!');
			}
		}

		$current_date    = make_date();

		$sql  = "INSERT INTO orders (id,customer,paymethod,notes,date)";
		$sql .= " VALUES ('{$new_order_id}','{$customer_name}','{$paymethod}','{$notes}','{$current_date}')";
		if ($db->query($sql)) {
			$session->msg("s", "Commande ajoutée avec succès");
			redirect( ( '../sales/add_sale_to_order.php?id=' . $new_order_id ) , false);
		} else {
			$session->msg("d", "Désolé, échec de l'ajout de la commande!");
			redirect( '../sales/add_order.php' , false);
		}
	} else {
		$session->msg("d", $errors);
		redirect( '../sales/add_order.php' , false);
	}
}
?>

<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="../sales/ajax_customer.php" autocomplete="off" id="sug-customer-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
              >Recherche</button>
            </span>
            <input type="text" id="sug_customer_input" class="form-control" name="customer_name" value="" 
            placeholder="Nom du client">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>

  <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron text-center">
<h3>commande: #<?php echo $new_order_id; ?></h3>
      </div>
    </div>
</div>


</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Selectionner le client</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="../sales/add_order.php">
         <table class="table table-bordered">
           <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">Client</th>
                    <th class="text-center" style="width: 100px;">Adresse</th>
                    <th class="text-center" style="width: 50px;">Code Postal</th>
                    <th class="text-center" style="width: 50px;">Mode de paiement</th>
                    <th class="text-center" style="width: 50px;">Actions</th>
                </tr>
           </thead>
           <tbody  id="customer_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>
<?php include_once '../layouts/footer.php'; ?>
