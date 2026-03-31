<?php
/**
 * profile.php
 *
 * @package default
 */


$page_title = 'Mon profil';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
?>
  <?php
$user_id = (int)$_GET['id'];
if (empty($user_id)):
	redirect('home.php', false);
else:
	$user_p = find_by_id('users', $user_id);
endif;
?>
<?php include_once '../layouts/header.php'; ?>
<div class="row">
   <div class="col-md-4">
       <div class="panel profile">
         <div class="jumbotron text-center bg-red">
            <img class="img-circle img-size-2" src="../uploads/users/<?php echo $user_p['image'];?>" alt="">
           <h3><?php echo first_character($user_p['name']); ?></h3>
         </div>
        <?php if ( $user_p['id'] === $user['id']):?>
         <ul class="nav nav-pills nav-stacked">
          <li><a href="../users/edit_account.php"> <i class="glyphicon glyphicon-edit"></i> Modifier le profil</a></li>
         </ul>
       <?php endif;?>
       </div>
   </div>
</div>
<?php include_once '../layouts/footer.php'; ?>
