<?php
/**
 * order_picklist.php
 *
 * @package default
 */


$page_title = 'Liste de préparation de commande';

require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
$order_id  = 0;

if (isset($_GET['id'])) {
	$order_id = (int) $_GET['id'];
} else {
	$session->msg("d", "Missing order id.");
}

$sales = find_sales_by_order_id( $order_id );
$order = find_by_id("orders", $order_id);

$products_available = join_product_table();
?>

<!doctype html>
<html lang="en-US">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Liste de préparation de commande</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .sale-head{
       margin: 40px 0;
       text-align: center;
     }.sale-head h1,.sale-head strong{
       padding: 10px 20px;
       display: block;
     }.sale-head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.sale-head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }tfoot{
       color:#000;
       text-transform: uppercase;
       font-weight: 500;
     }
   </style>
</head>
<body>
  <?php if ($sales): ?>
    <div class="page-break">
       <div class="sale-head pull-right">
           <h1>Order #<?php echo ucfirst($order['id']);?></h1>
           <strong><?php echo $order['date'];?> </strong>
       </div>
       <div class="sale-head pull-left">
           <h1><?php echo ucfirst($order['customer']);?> </h1>
       </div>

      <table class="table table-border">
        <thead>
          <tr>
              <th>Réference produit</th>
              <th>Nom du produit</th>
              <!--<th>Product Disponible</th>-->
              <th>Stock  Disponible</th>
              <th>Quantité Commandée</th>
              <th>Disponible</th>
              <th>Preparéé</th>
              <th>Expédiée</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sales as $sale): ?>
           <tr>
              <td class="text-center">
              <?php
	foreach ( $products_available as $product ) {
		if ( $product['name'] == $sale['name'] ) {
			echo $product['sku'];
		}
	}
?>
              </td>
              <td class="text-center"><?php echo ucfirst($sale['name']);?></td>
              <td class="text-center"><?php echo $sale['location'];?></td>
              <td class="text-center">
              <?php
foreach ( $products_available as $product ) {
	if ( $product['name'] == $sale['name'] ) {
		echo $product['quantity'] + $sale['qty'];
	}
}
?>
              </td>
              <td class="text-center"><?php echo $sale['qty'];?></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php
else:
	$session->msg("d", "Désolé, aucun vente n'a été trouvée. ");
redirect('../sales/orders.php', false);
endif;
?>
</body>
</html>
<?php if (isset($db)) { $db->db_disconnect(); } ?>
