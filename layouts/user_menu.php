<?php
/**
 * layouts/user_menu.php
 *
 * @package default
 */


?>
<ul>
  <li>
    <a href="../users/home.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-shopping-cart"></i>
      <span>Produits</span>
    </a>
    <ul class="nav submenu">
       <li><a href="../products/media.php">Media</a> </li>
       <li><a href="../products/categories.php">Categories</a> </li>
       <li><a href="../products/products.php">Gestion des produits</a> </li>
       <li><a href="../products/product_search.php">Recherche de produit</a> </li>
       <li><a href="../products/stock.php">Gestion du stock</a> </li>
   </ul>
  </li>
  <li>
    <a href="../customers/customers.php" class="submenu-toggle">
      <i class="glyphicon glyphicon-user"></i>
      <span>Clients</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-piggy-bank"></i>
       <span>Ventes</span>
      </a>
      <ul class="nav submenu">
         <li><a href="../sales/add_order_by_customer.php">Ajouter une commande</a> </li>
         <li><a href="../sales/orders.php">Gestion des commandes</a> </li>
         <li><a href="../sales/sales.php">Gestion des ventes</a> </li>
         <li><a href="../sales/add_sale_by_sku.php">Rechercher une vente par RP</a> </li>
     </ul>
  </li>
  <li>

</ul>
