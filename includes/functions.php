<?php
/**
 * includes/functions.php
 *
 * @package default
 */


 $errors = array();

 /*--------------------------------------------------------------*/
 /* Fonction pour supprimer les caractères spéciaux dans une chaîne pour une utilisation dans une requête SQL
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $str
  * @return unknown
  */
 function real_escape($str) {
	 global $con;
	 $escape = mysqli_real_escape_string($con, $str);
	 return $escape;
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour supprimer les caractères HTML
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $str
  * @return unknown
  */
 function remove_junk($str) {
	 $str = nl2br($str);
	 $str = trim($str);
	 $str = stripslashes($str);
	 $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
	 return $str;
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour mettre la première lettre en majuscule
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $str
  * @return unknown
  */
 function first_character($str) {
	 $val = str_replace('-', " ", $str);
	 $val = ucfirst($val);
	 return $val;
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour vérifier que les champs de saisie ne sont pas vides
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $var
  * @return unknown
  */
 function validate_fields($var) {
	 global $errors;
	 foreach ($var as $field) {
		 $val = remove_junk($_POST[$field]);
		 if (isset($val) && $val=='') {
			 $errors = $field ." ne peut pas être vide.";
			 return $errors;
		 }
	 }
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour afficher un message de session
	Ex : echo displayt_msg($message);
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $msg (facultatif)
  * @return unknown
  */
 function display_msg($msg ='') {
	 $output = array();
	 if (!empty($msg)) {
		 foreach ($msg as $key => $value) {
			 $output  = "<div class=\"alert alert-{$key}\">";
			 $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
			 $output .= remove_junk(first_character($value));
			 $output .= "</div>";
		 }
		 return $output;
	 } else {
		 return "" ;
	 }
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour rediriger
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $url
  * @param unknown $permanent (facultatif)
  */
 function redirect($url, $permanent = false) {
	 if (headers_sent() === false) {
		 header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
	 }
 
	 exit();
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour trouver le prix total de vente, prix d'achat et profit
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $totals
  * @return unknown
  */
 function total_price($totals) {
	 $sum = 0;
	 $sub = 0;
	 $profit = 0;
	 foreach ($totals as $total ) {
		 $sum += $total['total_selling_price'];
		 $sub += $total['total_buying_price'];
		 $profit = $sum - $sub;
	 }
	 return array($sum, $profit);
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour formater la date et l'heure
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $str
  * @return unknown
  */
 function read_date($str) {
	 if ($str)
		 return date('M j, Y, g:i:s a', strtotime($str));
	 else
		 return null;
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour créer la date et l'heure actuelles
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @return unknown
  */
 function make_date() {
	 return strftime("%Y-%m-%d %H:%M:%S", time());
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour obtenir un identifiant unique
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @return unknown
  */
 function count_id() {
	 static $count = 1;
	 return $count++;
 }
 
 
 /*--------------------------------------------------------------*/
 /* Fonction pour générer une chaîne aléatoire
 /*--------------------------------------------------------------*/
 
 /**
  * 
  * @param unknown $length (facultatif)
  * @return unknown
  */
 function randString($length = 5) {
	 $str='';
	 $cha = "0123456789abcdefghijklmnopqrstuvwxyz";
 
	 for ($x=0; $x<$length; $x++)
		 $str .= $cha[mt_rand(0, strlen($cha))];
	 return $str;
 }
 
?>
