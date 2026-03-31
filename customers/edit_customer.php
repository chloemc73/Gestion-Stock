<?php
/**
 * edit_customer.php
 *
 * @package default
 */


$page_title = 'Modifier le client';
require_once '../includes/load.php';
//Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(2);
page_require_level(2);

$customer = find_by_id('customers', (int)$_GET['id']);

if (!$customer) {
	$session->msg("d", "ID client manquant..");
	redirect('../customers/customers.php');
}
?>
<?php
if (isset($_POST['edit_customer'])) {
	$req_fields = array('customer-name' );
	validate_fields($req_fields);

	if (empty($errors)) {
		$c_name  = $db->escape($_POST['customer-name']);
		if (is_null($_POST['customer-address']) || $_POST['customer-address'] === "") {
			$c_address  =  '';
		} else {
			$c_address  = $db->escape($_POST['customer-address']);
		}
		if (is_null($_POST['customer-city']) || $_POST['customer-city'] === "") {
			$c_city  =  '';
		} else {
			$c_city  = $db->escape($_POST['customer-city']);
		}
		if (is_null($_POST['customer-region']) || $_POST['customer-region'] === "") {
			$c_region  =  '';
		} else {
			$c_region  = $db->escape($_POST['customer-region']);
		}
		if (is_null($_POST['customer-postcode']) || $_POST['customer-postcode'] === "") {
			$c_postcode  =  '';
		} else {
			$c_postcode  = $db->escape($_POST['customer-postcode']);
		}
		if (is_null($_POST['customer-telephone']) || $_POST['customer-telephone'] === "") {
			$c_telephone  =  '';
		} else {
			$c_telephone  = $db->escape($_POST['customer-telephone']);
		}
		if (is_null($_POST['customer-email']) || $_POST['customer-email'] === "") {
			$c_email  =  '';
		} else {
			$c_email  = $db->escape($_POST['customer-email']);
		}
		if (is_null($_POST['customer-paymethod']) || $_POST['customer-paymethod'] === "") {
			$c_paymethod  =  '';
		} else {
			$c_paymethod  = $db->escape($_POST['customer-paymethod']);
		}

		if ( find_by_name('customers', $c_name) ) {

			$query   = "UPDATE customers SET";
			$query  .=" name ='{$c_name}', address ='{$c_address}', city ='{$c_city}', region ='{$c_region}', postcode ='{$c_postcode}', telephone ='{$c_telephone}', email ='{$c_email}',";
			$query  .=" paymethod ='{$c_paymethod}'";
			$query  .=" WHERE id ='{$customer['id']}'";
			$result = $db->query($query);
			if ($result && $db->affected_rows() === 1) {
				$session->msg('s', 'Information Client mise à jour');
				redirect('customers.php', false);
			} else {
				$session->msg('d', 'Échec de la mise à jour !');
				redirect('../customers/edit_customer.php?id='.$customer['id'], false);
			}

		} else {
			$session->msg('d', 'Échec de la mise à jour, Veuillez ajouter!');
			redirect('../customers/edit_customer.php?id='.$customer['id'], false);
		}


	} else {
		$session->msg("d", $errors);
		redirect('../customers/edit_customer.php?id='.$customer['id'], false);
	}

}

?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
         <div class="col-md-7">
	<div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Modifier l'informations du client</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="../customers/edit_customer.php?id=<?php echo (int)$customer['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-user"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-name" value="<?php echo $customer['name'];?>" disabled>
                  <input type="hidden" class="form-control" name="customer-name" value="<?php echo $customer['name'];?>">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-address" value="<?php echo $customer['address'];?>" placeholder="Adresse">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-city" value="<?php echo $customer['city'];?>" placeholder="Ville">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-home"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-region" value="<?php echo $customer['region'];?>" placeholder="État / Province / Région">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-postcode" value="<?php echo $customer['postcode'];?>" placeholder="Code Postal">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-telephone" value="<?php echo $customer['telephone'];?>" placeholder="Telephone">
               </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-globe"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-email" value="<?php echo $customer['email'];?>" placeholder="Email">
               </div>
              </div>

           <div class="form-group">
                    <select class="form-control" name="customer-paymethod">
                      <option value="">Sélectionnez le mode de paiement</option>

                     <option value="Espèces" <?php if ($customer['paymethod'] === "Espèces" ):echo "selected"; endif; ?> >Espèces</option>

                     <option value="Chèque" <?php if ($customer['paymethod'] === "Chéque" ):echo "selected"; endif; ?> >Chèque</option>

                     <option value="Crédit" <?php if ($customer['paymethod'] === "Crédit" ):echo "selected"; endif; ?> >Crédit</option>

                     <option value="Compte" <?php if ($customer['paymethod'] === "Compte" ):echo "selected"; endif; ?> >Compte</option>
                    </select>

           </div>

	  <div class="pull-right">
              <button type="submit" name="edit_customer" class="btn btn-info">Modifier</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once '../layouts/footer.php'; ?>
