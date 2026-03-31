<?php
/**
 * users.php
 *
 * @package default
 */


?>

<?php
$page_title = 'Tous les utilisateurs';
require_once '../includes/load.php';
?>

<?php
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
//Récupérer tous les utilisateurs de la base de données

$all_users = find_all_user();

?>

<?php include_once '../layouts/header.php'; ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<!--     *************************     -->

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Utilisateur</span>
<!--     *************************     -->
       </strong>
         <a href="../users/add_user.php" class="btn btn-info pull-right"style="background-color:rgb(255, 143, 99)"
         >Ajouter un nouveau utilisateur</a>
      </div>
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
<!--     *************************     -->
          <tr>
            <th class="text-center" style="width: 50px;">ID#</th>
            <th>Prénom</th>
            <th>Nom d'utilisateur</th>
            <th class="text-center" style="width: 15%;">Rôle de l'utilisateur</th>
            <th class="text-center" style="width: 10%;">Statut</th>
            <th style="width: 20%;">Dernière connexion</th>
            <th class="text-center" style="width: 100px;">Actions</th>
          </tr>
<!--     *************************     -->
        </thead>
        <tbody>

<!--     *************************     -->
        <?php foreach ($all_users as $a_user): ?>

          <tr>
           <td class="text-center"><?php echo $a_user['id'];?></td>
           <td><?php echo ucwords($a_user['name'])?></td>
           <td><?php echo $a_user['username']?></td>
           <td class="text-center"><?php echo ucwords($a_user['group_name'])?></td>
<!--     *************************     -->
           <td class="text-center">
           <?php if ($a_user['status'] === '1'): ?>
            <span class="label label-success"><?php echo "Activer"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Déactiver"; ?></span>
          <?php endif;?>
           </td>
<!--     *************************     -->
           <td><?php echo read_date($a_user['last_login'])?></td>
<!--     *************************     -->
           <td class="text-center">
             <div class="btn-group">
                <a href="../users/edit_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" 
                data-toggle="tooltip" title="Modifier">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                <a href="../users/delete_user.php?id=<?php echo (int)$a_user['id'];?>"
                  onClick="return confirm('Êtes-vous sûr de vouloir supprimer?')" class="btn btn-xs btn-danger" 
                  data-toggle="tooltip" title="Supprimer">
                  <i class="glyphicon glyphicon-remove"></i>
                </a>
                </div>
           </td>
<!--     *************************     -->
          </tr>

        <?php endforeach;?>
<!--     *************************     -->

       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once '../layouts/footer.php'; ?>
