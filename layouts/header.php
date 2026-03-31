<?php
/**
 * layouts/header.php
 *
 * @package default
 */


?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>
    <?php
$user = current_user();
if (!empty($page_title))
	echo remove_junk($page_title);
elseif (!empty($user))
	echo ucfirst($user['name']);
else echo "Stock_System";
?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="../libs/css/main.css" />
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn()): ?>
    <header id="header">
      <div class="logo pull-left" style=" background-color: #ffa07a">STOCK_SYSTEM
<!--
      <img src="../img/LOGO.png" height="60" width="140">
-->

      </div>
      <div class="header-content">
      <div class="header-date pull-left">
        <?php
         setlocale(LC_TIME, 'fr_FR.UTF-8');
         echo '<strong>' . strftime("%A %d %B %Y, %H:%M") . '</strong>'
        ?>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="../uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="../users/profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Profil
                  </a>
              </li>
             <li>
                 <a href="../users/edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Paramètres
                 </a>
             </li>
             <li class="last">
                 <a href="../users/logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Déconnexion
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php if ($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once 'admin_menu.php';?>

      <?php elseif ($user['user_level'] === '2'): ?>
        <!-- Special user -->
      <?php include_once 'special_menu.php';?>

      <?php elseif ($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once 'user_menu.php';?>

      <?php else: ?>
        <!-- You shouldn't be here -->
      <?php redirect('../users/logout.php', false); ?>

      <?php endif;?>

   </div>
<?php endif;?>

<div class="page">
  <div class="container-fluid">
