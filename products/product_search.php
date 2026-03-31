<?php
/**
 * product_search.php
 *
 * @package default
 */


$page_title = 'Rechercher un produit';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);

?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax_product.php" autocomplete="off" id="sug-search-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
              >Recherche</button>
            </span>
            <input type="text" id="sug_search_input" class="form-control" name="product_search"  
            placeholder="Nom du produit / Réference produit / Description">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Produits</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="">
         <table class="table table-bordered">
           <thead>
                <th> Nom du produit </th>
                <th> Photo</th>
                <th class="text-center" style="width: 10%;"> Référence </th>
                <th class="text-center" style="width: 10%;"> Disponible</th>
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Prix de revient </th>
                <th class="text-center" style="width: 10%;"> Prix de vente</th>
                <th class="text-center" style="width: 100px;"> Actions </th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once '../layouts/footer.php'; ?>
