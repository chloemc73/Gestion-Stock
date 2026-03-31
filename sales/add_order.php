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
	if (isset($_POST['notes'])) { $notes = $db->escape($_POST['notes']); }
	$c_address = "";
	$c_city = "";
	$c_region = "";
	$c_postcode = "";
	$c_telephone = "";
	$c_email = "";

	if (empty($errors)) {

		if ( ! find_by_name('customers', $customer_name) ) {
			$query  = "INSERT INTO customers (";
			$query .=" name,address,city,region,postcode,telephone,email,paymethod";
			$query .=") VALUES (";
			$query .=" '{$customer_name}', '{$c_address}','{$c_city}', '{$c_region}', '{$c_postcode}', '{$c_telephone}', 
			'{$c_email}', '{$paymethod}'";
			$query .=")";
			$result = $db->query($query);
			if ($result && $db->affected_rows() === 1) {
				$session->msg('s', "Client ajouté! ");
			} else {
				$session->msg('d', 'Désolé, échec de l ajout!');
			}
		}

		$current_date    = make_date();
		$sql  = "INSERT INTO orders (id,customer,paymethod,notes,date)";
		$sql .= " VALUES ('{$new_order_id}','{$customer_name}','{$paymethod}','{$notes}','{$current_date}')";
		if ($db->query($sql)) {
			$session->msg("s", "Commande ajoutée avec succès");
			redirect( ( '../sales/add_sale_by_search.php?id=' . $new_order_id ) , false);
		} else {
			$session->msg("d", "Désolé, échec de l'ajout de la commande !");
			redirect( '../sales/add_order.php' , false);
		}
	} else {
		$session->msg("d", $errors);
		redirect( '../sales/add_order.php' , false);
	}
}
?>

<?php include_once '../layouts/header.php'; ?>

<div class="login-page">
    <div class="text-center">
<!--     *************************     -->
       <h2>Ajouter la commande</h3>
       <h3>#<?php echo $new_order_id;?></h3>
<!--     *************************     -->
     </div>
     <?php echo display_msg($msg); ?>

      <form method="post" action="" class="clearfix">
<!--     *************************     -->
        <div class="form-group">
        </div>

        <div class="form-group">
              <label for="name" class="control-label">Nom du client</label>
              <input type="text" class="form-control" name="customer-name" value="" placeholder="Nom du client">
        </div>

           <div class="form-group">
              <label for="paymethod" class="control-label">Mode de paiement</label>

                    <select class="form-control" name="paymethod">
                      <option value="">Sélectionner le mode de paiement</option>
                      <option value="Espèces">Espèces</option>
                      <option value="Chèque">Chèque</option>
                      <option value="Crédit">Crédit</option>
                      <option value="Compte">Compte</option>
                    </select>
           </div>

           <div class="form-group">
              <label for="notes" class="control-label">Notes</label>
               <input type="text" class="form-control" name="notes" value="" placeholder="Notes">
           </div>

<!--     *************************     -->
        <div class="form-group clearfix">
         <div class="pull-right">
                <button type="submit" name="add_order" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
				>lancer la commande</button>
        </div>
        </div>
    </form>
</div>

<?php include_once '../layouts/footer.php'; ?>
