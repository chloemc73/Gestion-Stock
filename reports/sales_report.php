<?php
/**
 * sales_report.php
 *
 * @package default
 */


$page_title = 'Rapport de vente';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="jumbotron text-center">
      <h3>Rapport de vente</h3>
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Intervalle de date</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="De">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="à">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary"style="background-color:rgb(255, 143, 99)"
                 >Générer le rapport</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>
<?php include_once '../layouts/footer.php'; ?>
