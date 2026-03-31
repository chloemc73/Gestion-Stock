<?php
/**
 * edit_order.php
 *
 * @package default
 */


$page_title = 'Modifier la commande';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);


//Afficher toutes les catgories.
$order = find_by_id('orders', (int)$_GET['id']);
if (!$order) {
	$session->msg("d", "ID commande manquante.");
	redirect('../sales/orders.php');
}

if (isset($_POST['edit_order'])) {
	$req_fields = array('customer-name', 'paymethod' );
	validate_fields($req_fields);
	$customer_name = $db->escape($_POST['customer-name']);
	$paymethod = $db->escape($_POST['paymethod']);
	$notes = remove_junk($db->escape($_POST['notes']));
	$c_address = "";
	$c_city = "";
	$c_region = "";
	$c_postcode = "";
	$c_telephone = "";
	$c_email = "";
	$date = remove_junk($db->escape($_POST['date']));
	if ($date == 0 ) { $date    = make_date(); }

	if (empty($errors)) {

		if ( ! find_by_name('customers', $customer_name) ) {
			$query  = "INSERT INTO customers (";
			$query .=" name,address,city,region,postcode,telephone,email,paymethod";
			$query .=") VALUES (";
			$query .=" '{$customer_name}', '{$c_address}','{$c_city}', '{$c_region}', '{$c_postcode}',
			 '{$c_telephone}', '{$c_email}', '{$paymethod}'";
			$query .=")";
			$result = $db->query($query);
			if ($result && $db->affected_rows() === 1) {
				$session->msg('s', "Client ajouté! ");
			} else {
				$session->msg('d', ' Désolé, l ajout a échoué!');
			}
		}

		$sql = "UPDATE orders SET";
		$sql .= " customer='{$customer_name}', paymethod='{$paymethod}', notes='{$notes}', date='{$date}'";
		$sql .= " WHERE id='{$order['id']}'";

		$result = $db->query($sql);
		if ($result && $db->affected_rows() === 1) {
			$session->msg("s", "Mise à jour de la commande avec succès");
			redirect('../sales/orders.php', false);
		} else {
			$session->msg("d", "Désolé, la commande a échouée!");
			redirect('../sales/orders.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../sales/orders.php', false);
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
           <span>Modifier la commande: #<?php echo ucfirst($order['id']);?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="../sales/edit_order.php?id=<?php echo (int)$order['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="customer-name" 
			   value="<?php echo ucfirst($order['customer']);?>">
           </div>

           <div class="form-group">
                    <select class="form-control" name="paymethod">
                      <option value="">selectionner le mode de paiement</option>
                     <option value="Espèces" <?php if ($order['paymethod'] === "Espèces" ): echo "selectionner"; endif; ?>
						 >Espèces</option>
                     <option value="Chèque" <?php if ($order['paymethod'] === "Chéque" ): echo "selecteionner"; endif; ?> 
						>Chèque</option>
                     <option value="Crédit" <?php if ($order['paymethod'] === "Crédit" ): echo "selectionner"; endif; ?> 
						>Crédit</option>
                     <option value="Compte" <?php if ($order['paymethod'] === "Compte" ): echo "selectionner"; endif; ?> 
						>Compte</option>
                    </select>

           </div>

           <div class="form-group">
               <input type="text" class="form-control" name="notes" value="<?php echo ucfirst($order['notes']);?>"
			    placeholder="Notes">
           </div>

           <div class="form-group">
           <input type="date" class="form-control datepicker" name="date" data-date-format=""
		    value="<?php echo $order['date']; ?>">
           </div>

         <div class="pull-right">
              <button type="submit" name="edit_order" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
			  >Modifier</button>
          </form>
         </div>
        </div>
      </div>
  </div>
<?php
// print "<pre>";
// print_r($order);
// print "</pre>\n";
?>

   </div>
</div>

<?php include_once '../layouts/footer.php'; ?>
