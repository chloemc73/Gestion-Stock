<?php
/**
 * layouts/admin_menu.php
 *
 * @package default
 */


?>
<ul>
  <li>
    <a href="../users/admin.php">
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
       <span> Ventes</span>
      </a>
      <ul class="nav submenu">
         <li><a href="../sales/add_order_by_customer.php">Ajouter une commande</a> </li>
         <li><a href="../sales/orders.php">Gestion des commandes</a> </li>
         <li><a href="../sales/sales.php">Gestion des ventes</a> </li>
         <li><a href="../sales/add_sale_by_sku.php">Rechercher une vente par RP</a> </li>
     </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
       <span>Rapports</span>
      </a>
      <ul class="nav submenu">
        <li><a href="../reports/stock_report.php">Rapport du stock</a></li>
        <li><a href="../reports/sales_report.php">Ventes par dates</a></li>
        <li><a href="../reports/monthly_sales.php">Ventes mensuelles</a></li>
        <li><a href="../reports/daily_sales.php">Ventes quotidiennes</a> </li>
      </ul>
  </li>

  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-cog"></i>
      <span>Utilisateurs</span>
    </a>
    <ul class="nav submenu">
      <li><a href="../users/group.php">Gestion des groupes</a></li>
      <li><a href="../users/users.php">Gestion des utilisateurs</a> </li>
      <li><a href="../users/log.php">Journal système</a> </li>
   </ul>
  </li>

</ul>
