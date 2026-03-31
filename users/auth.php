<?php
/**
 * auth.php
 *
 * @package default
 */


include_once '../includes/load.php';

$req_fields = array('username', 'password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if (empty($errors)) {
	$user_id = authenticate($username, $password);
	if ($user_id) {
		//creation d'une session partir de ID
		$session->login($user_id);
		//Mettre à jour l'heure de connexion
		updateLastLogIn($user_id);
		$session->msg("s", "Bienvenue sur Stock_System.");
		redirect('../users/home.php', false);

	} else {
		$session->msg("d", "Désolé, Nom d'utilisateur ou mot de passe incorrect.");
		redirect('index.php', false);
	}

} else {
	$session->msg("d", $errors);
	redirect('index.php', false);
}

?>
