<?php
/**
 * edit_user.php
 *
 * @package default
 */


$page_title = 'Modifier l utilisateur';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>

<!--     *************************     -->

<?php
$e_user = find_by_id('users', (int)$_GET['id']);
$groups  = find_all('user_groups');
if (!$e_user) {
	$session->msg("d", "ID utilisateur manquant.");
	redirect('../users/users.php');
}
?>

<!--     *************************     -->

<?php
//Modifier les informations basic de l'utilisateur
if (isset($_POST['update'])) {
	$req_fields = array('name', 'username', 'level');
	validate_fields($req_fields);
	if (empty($errors)) {
		$id = (int)$e_user['id'];
		$name = remove_junk($db->escape($_POST['name']));
		$username = remove_junk($db->escape($_POST['username']));
		$level = (int)$db->escape($_POST['level']);
		$status   = remove_junk($db->escape($_POST['status']));
		$sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' 
    WHERE id='{$db->escape($id)}'";
		$result = $db->query($sql);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', "Compte modifié ");
			redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
		} else {
			$session->msg('d', ' Désolé, la modification a échoué!');
			redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
	}
}
?>

<!--     *************************     -->


<?php
// Modifier le mot de passe de l'utilisateur
if (isset($_POST['update-pass'])) {
	$req_fields = array('password');
	validate_fields($req_fields);
	if (empty($errors)) {
		$id = (int)$e_user['id'];
		$password = remove_junk($db->escape($_POST['password']));
		$h_pass   = sha1($password);
		$sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
		$result = $db->query($sql);
		if ($result && $db->affected_rows() === 1) {
			$session->msg('s', "Mot de passe utilisateur a été modifié ");
			redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
		} else {
			$session->msg('d', ' Désolé, la modification du mot de passe utilisateur a échoué');
			redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../users/edit_user.php?id='.(int)$e_user['id'], false);
	}
}

?>

<!--     *************************     -->


<?php include_once '../layouts/header.php'; ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>

<!--     *************************     -->

  <div class="col-md-6">
     <div class="panel panel-default">
<!--     *************************     -->
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Modifier <?php echo ucwords($e_user['name']); ?> le compte
        </strong>
       </div>
<!--     *************************     -->

       <div class="panel-body">

          <form method="post" action="../users/edit_user.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
<!--     *************************     -->
            <div class="form-group">
                  <label for="name" class="control-label">Prénom</label>
                  <input type="name" class="form-control" name="name" value="<?php echo ucwords($e_user['name']); ?>">
            </div>
<!--     *************************     -->
            <div class="form-group">
                  <label for="username" class="control-label">Nom d'utilisateur</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $e_user['username']; ?>">
            </div>
<!--     *************************     -->
            <div class="form-group">
              <label for="level">Rôle de l'utilisateur</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option <?php if ($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?>
                     value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
<!--     *************************     -->
            <div class="form-group">
              <label for="status">Statut</label>
                <select class="form-control" name="status">
                  <option <?php if ($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Activer</option>
                  <option <?php if ($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Déactiver</option>
                </select>
            </div>
<!--     *************************     -->
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
                    >Modifier</button>
            </div>
        </form>
       </div>
     </div>
  </div>


  <!-- Formulaire de changement de mot de passe -->

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Changer <?php echo ucwords($e_user['name']); ?> votre mot de passe
        </strong>
      </div>
      <div class="panel-body">
        <form action="../users/edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="Entrez le nouveau mot de passe">
          </div>
          <div class="form-group clearfix">
                  <button type="submit" name="update-pass" class="btn btn-danger pull-right">Changer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!--     *************************     -->

 </div>
<?php include_once '../layouts/footer.php'; ?>
