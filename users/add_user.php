<?php
/**
 * add_user.php
 *
 * @package default
 */


$page_title = 'Ajouter un utilisateur';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);


$groups = find_all('user_groups');
$all_users = find_all_user();

if (isset($_POST['add_user'])) {
	$req_fields = array('full-name', 'username', 'password', 'level' );
	validate_fields($req_fields);

	if (empty($errors)) {
		$name   = remove_junk($db->escape($_POST['full-name']));
		$username   = strtolower(remove_junk($db->escape($_POST['username'])));

		foreach ($all_users as $a_user) {
			if ( $username == $a_user['username'] ) {
				//failed
				$session->msg('d', ' Désolé, le nom d utilisateur est déjà utilisé!');
				redirect('../users/add_user.php', false);
			}
		}

		$password   = remove_junk($db->escape($_POST['password']));
		$user_level = (int)$db->escape($_POST['level']);
		$password = sha1($password);
		$query = "INSERT INTO users (";
		$query .="name,username,password,user_level,status";
		$query .=") VALUES (";
		$query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
		$query .=")";
		if ($db->query($query)) {
			//sucess
			$session->msg('s', "Le compte utilisateur a été créé! ");
			redirect('../users/add_user.php', false);
		} else {
			//failed
			$session->msg('d', ' Désolé, la creation du compte a échoué !');
			redirect('../users/add_user.php', false);
		}



	} else {
		$session->msg("d", $errors);
		redirect('../users/add_user.php', false);
	}
}
?>
<?php include_once '../layouts/header.php'; ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Ajouter un nouveau utilisateur</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="../users/add_user.php">
            <div class="form-group">
                <label for="name">Prénom</label>
                <input type="text" class="form-control" name="full-name" placeholder="Entrez ton prenom">
            </div>
            <div class="form-group">
                <label for="username">Non d'utilisateur</label>
                <input type="text" class="form-control" name="username" placeholder="Non d'utilisateur">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name ="password"  placeholder="Mot de passe">
            </div>
            <div class="form-group">
              <label for="level">Rôle de l'utilisateur</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);
                   ?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary" style="background-color:rgb(255, 143, 99)"
              >Ajouter l'utilisateur</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once '../layouts/footer.php'; ?>
