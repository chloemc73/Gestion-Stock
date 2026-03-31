<?php
/**
 * change_password.php
 *
 * @package default
 */


$page_title = 'Change Password';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
if (isset($_POST['update'])) {

	$req_fields = array('new-password', 'old-password', 'id' );
	validate_fields($req_fields);

	if (empty($errors)) {

		if (sha1($_POST['old-password']) !== current_user()['password'] ) {
			$session->msg('d', "Votre mot de passe ne correspond pas");
			redirect('../users/change_password.php', false);
		}

		$id = (int)$_POST['id'];
		$new = remove_junk($db->escape(sha1($_POST['new-password'])));
		$sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
		$result = $db->query($sql);
		if ($result && $db->affected_rows() === 1):
			$session->logout();
		$session->msg('s', "Connectez-vous avec votre nouveau mot de passe.");
		redirect('index.php', false);
		else:
			$session->msg('d', ' Désolé, la mise à jour à échouer!');
		redirect('../users/change_password.php', false);
		endif;
	} else {
		$session->msg("d", $errors);
		redirect('../users/change_password.php', false);
	}
}
?>
<?php include_once '../layouts/header.php'; ?>
<div class="login-page">
    <div class="text-center">
       <h3>Changer votre mot de passe</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="../users/change_password.php" class="clearfix">
        <div class="form-group">
              <label for="newPassword" class="control-label">Nouveau mot de passe</label>
              <input type="password" class="form-control" name="new-password" placeholder="Nouveau mot de passe">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Mot de passe actuel</label>
              <input type="password" class="form-control" name="old-password" placeholder="Mot de passe actuel">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
				>Changer</button>
        </div>
    </form>
</div>
<?php include_once '../layouts/footer.php'; ?>
