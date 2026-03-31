<?php
/**
 * add_group.php
 *
 * @package default
 */


$page_title = 'Add Group';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>
<?php
if (isset($_POST['add'])) {

	$req_fields = array('group-name', 'group-level');
	validate_fields($req_fields);

	if (find_by_groupName($_POST['group-name']) === false ) {
		$session->msg('d', '<b>Sorry!</b> Entered Group Name already in database!');
		redirect('../users/add_group.php', false);
	}elseif (find_by_groupLevel($_POST['group-level']) === false) {
		$session->msg('d', '<b>Sorry!</b> Entered Group Level already in database!');
		redirect('../users/add_group.php', false);
	}
	if (empty($errors)) {
		$name = remove_junk($db->escape($_POST['group-name']));
		$level = remove_junk($db->escape($_POST['group-level']));
		$status = remove_junk($db->escape($_POST['status']));

		$query  = "INSERT INTO user_groups (";
		$query .="group_name,group_level,group_status";
		$query .=") VALUES (";
		$query .=" '{$name}', '{$level}','{$status}'";
		$query .=")";
		if ($db->query($query)) {
			//sucèss
			$session->msg('s', "Le groupe a été créé! ");
			redirect('../users/add_group.php', false);
		} else {
			//Echec
			$session->msg('d', ' Désolé, échec de la création du groupe!');
			redirect('../users/add_group.php', false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../users/add_group.php', false);
	}
}
?>
<?php include_once '../layouts/header.php'; ?>
<div class="login-page">
    <div class="text-center">
       <h3>Ajouter un nouveau groupe</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="../users/add_group.php" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Nom du groupe</label>
              <input type="name" class="form-control" name="group-name">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Niveau d'accès du group</label>
              <input type="number" class="form-control" name="group-level">
        </div>
        <div class="form-group">
          <label for="status">Statut</label>
            <select class="form-control" name="status">
              <option value="1">Activer</option>
              <option value="0">Déactiver</option>
            </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="add" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
				>Modifier</button>
        </div>
    </form>
</div>

<?php include_once '../layouts/footer.php'; ?>
