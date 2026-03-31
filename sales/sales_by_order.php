<?php
/**
 * sales_by_order.php
 *
 * @package default
 */


$page_title = 'Ventes par commande';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);

$order_id  = 0;

if (isset($_GET['id'])) {
	$order_id = (int) $_GET['id'];
} else {
	$session->msg("d", "ID commande manquante.");
}

$sales = find_sales_by_order_id( $order_id );
$order = find_by_id("orders", $order_id);
?>



<?php include_once '../layouts/header.php'; ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>

    <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>

            <span>Commande: #<?php echo $order_id; ?></span>

       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th class="text-center" style="width: 50px;">Client</th>
                    <th class="text-center" style="width: 50px;">Mode de paiement</th>
                    <th class="text-center" style="width: 50px;">Notes</th>
                    <th class="text-center" style="width: 50px;">Date</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="text-center"><?php echo $order['id'];?>
					</td>

                    <td class="text-center">
						<?php echo ucfirst($order['customer']);?>
					</td>
                    <td class="text-center">
						<?php echo ucfirst($order['paymethod']);?>
					</td>

                    <td class="text-center">
						<?php echo $order['notes'];?>
					</td>

                    <td class="text-center">
						<?php echo $order['date'];?>
					</td>

                    <td class="text-center">
                      <div class="btn-group">
                        <a href="../sales/edit_order.php?id=<?php echo (int)$order['id'];?>" 
                         class="btn btn-xs btn-warning" data-toggle="tooltip" title="Modifier">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="../sales/order_picklist.php?id=<?php echo (int)$order['id'];?>" 
                         class="btn btn-xs btn-primary" data-toggle="tooltip" title="Liste de prelèvement">
                          <span class="glyphicon glyphicon-hand-up"></span>
                        </a>
                        <a href="../sales/sales_invoice.php?id=<?php echo (int)$order['id'];?>"  
                        class="btn btn-xs btn-success" data-toggle="tooltip" title="Facture">
                          <span class="glyphicon glyphicon-export"></span>
                        </a>
                      </div>
                    </td>

                </tr>

            </tbody>
          </table>
       </div>
    </div>



  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Vente</span>
          </strong>
          <div class="pull-right">
            <a href="../sales/add_sale_by_search.php?id=<?php echo $order_id; ?>" class="btn btn-primary">
              Ajouter la vente</a>
          </div>
        </div>
        <div class="panel-body">

          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product </th>
                <th class="text-center" style="width: 15%;"> Référence produit</th>
                <th class="text-center" style="width: 15%;"> Disponible </th>
                <th class="text-center" style="width: 15%;"> Quantité </th>
                <th class="text-center" style="width: 15%;"> Totale </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>

           <tbody>

             <?php foreach ($sales as $sale):?>

             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo $sale['name']; ?></td>
               <td class="text-center"><?php echo $sale['sku']; ?></td>
               <td class="text-center"><?php echo $sale['location']; ?></td>
               <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
               <td class="text-center"><?php echo formatcurrency($sale['price'], $CURRENCY_CODE); ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="../sales/edit_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  
                     title="Modifier" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="../sales/delete_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs" 
                      title="Supprimer" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>

             <?php endforeach;?>

             <tr>
               <td class="text-center"></td>
               <td class="text-center"></td>
               <td class="text-center"></td>
               <td class="text-center"></td>
               <td class="text-center"></td>
<?php
$order_total = 0;
foreach ($sales as $sale) {
	$order_total = $order_total + $sale['price'];
}
?>
               <td class="text-center"><?php echo formatcurrency($order_total, $CURRENCY_CODE); ?></td>
               <td class="text-center"></td>


			</tr>


           </tbody>
         </table>
<!--     *************************     -->
        </div>
      </div>


    </div>
  </div>
<?php include_once '../layouts/footer.php'; ?>
