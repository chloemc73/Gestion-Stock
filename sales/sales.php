<?php
/**
 * sales.php
 *
 * @package default
 */


$page_title = 'Toutes les ventes';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
?>

<?php $sales = find_all_sales(); ?>
<?php include_once '../layouts/header.php'; ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Toutes les ventes</span>
          </strong>
        </div>
        <div class="panel-body">


          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 15%;">Commande</th>
                <th> Produit </th>
                <th class="text-center" style="width: 15%;"> Quantité</th>
                <th class="text-center" style="width: 15%;"> Totalé </th>
                <th class="text-center" style="width: 15%;"> Date </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>


           <tbody>

             <?php foreach ($sales as $sale):?>

             <tr>
               <td class="text-center"><?php echo (int)$sale['order_id']; ?></td>
               <td><?php echo $sale['name']; ?></td>
               <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
               <td class="text-center"><?php echo formatcurrency($sale['price'], $CURRENCY_CODE); ?></td>
               <td class="text-center"><?php echo $sale['date']; ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="../sales/edit_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs" 
                      title="Motifier" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="../sales/delete_sale.php?id=<?php echo (int)$sale['id'];?>"  
                     onClick="return confirm('Êtes-vous sûr de vouloir supprimer?')" 
                     class="btn btn-danger btn-xs"  title="Supprimer" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>

             <?php endforeach;?>

           </tbody>
         </table>


        </div>
      </div>

    </div>
  </div>
<?php include_once '../layouts/footer.php'; ?>
