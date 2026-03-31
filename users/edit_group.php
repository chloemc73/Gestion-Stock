<?php
/**
 * edit_group.php
 *
 * @package default
 */


$page_title = 'Modifier le groupe';
require_once '../includes/load.php';
// Vérifier quel niveau d'utilisateur a la permission de voir cette page
page_require_level(1);
?>

<!--     *************************     -->

<?php
$e_group = find_by_id('user_groups', (int)$_GET['id']);
if (!$e_group) {
	$session->msg("d", "ID groupe manquant.");
	redirect('../users/group.php');
}
?>

<!--     *************************     -->

<?php
if (isset($_POST['update'])) {

	$req_fields = array('group-name', 'group-level');
	validate_fields($req_fields);
	if (empty($errors)) {
		$name = remove_junk($db->escape($_POST['group-name']));
		$level = remove_junk($db->escape($_POST['group-level']));
		$status = remove_junk($db->escape($_POST['status']));

		$query  = "UPDATE user_groups SET ";
		$query .= "group_name='{$name}',group_level='{$level}',group_status='{$status}'";
		$query .= "WHERE ID='{$db->escape($e_group['id'])}'";
		$result = $db->query($query);
		if ($result && $db->affected_rows() === 1) {
			//sucess
			$session->msg('s', "Le groupe a été modifié! ");
			redirect('../users/edit_group.php?id='.(int)$e_group['id'], false);
		} else {
			//failed
			$session->msg('d', ' Désolé, la modification du groupe a échoué!');
			redirect('../users/edit_group.php?id='.(int)$e_group['id'], false);
		}
	} else {
		$session->msg("d", $errors);
		redirect('../users/edit_group.php?id='.(int)$e_group['id'], false);
	}
}
?>

<!--     *************************     -->

<?php include_once '../layouts/header.php'; ?>


<div class="login-page">
    <div class="text-center">
<!--     *************************     -->
       <h3>Modifier le groupe</h3>
<!--     *************************     -->
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="../users/edit_group.php?id=<?php echo (int)$e_group['id'];?>" class="clearfix">
<!--     *************************     -->
        <div class="form-group">
              <label for="name" class="control-label">Nom du groupe</label>
              <input type="name" class="form-control" name="group-name" value="<?php echo ucwords($e_group['group_name']); ?>">
        </div>
<!--     *************************     -->
        <div class="form-group">
              <label for="level" class="control-label">Niveau d'accès du groupe</label>
              <input type="number" class="form-control" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
        </div>
<!--     *************************     -->
        <div class="form-group">
          <label for="status">Status</label>
              <select class="form-control" name="status">
                <option <?php if ($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Activer 

				</option>
                <option <?php if ($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0">Déactiver

				</option>
              </select>
        </div>
<!--     *************************     -->
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info" style="background-color:rgb(255, 143, 99)"
				>Modifier</button>
        </div>
    </form>
</div>

<?php include_once '../layouts/footer.php'; ?>
