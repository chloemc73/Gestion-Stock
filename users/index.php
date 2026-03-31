<?php
/**
 * users/index.php
 *
 * @package default
 */
// Les espaces avant le code HTML peuvent provoquer des erreurs sur certains serveurs.
ob_start();
require_once '../includes/load.php';
if ($session->isUserLoggedIn()) { redirect('../users/home.php', false);}
?>
<?php include_once '../layouts/header.php'; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin-right: 50px;
    height: 100vh;
    display: flex;
    overflow: hidden;
}

.login-page {
    width: 500%;
    max-width: 500px; /* Largeur du formulaire */
    background: #ffffff;
    padding: 30px; /* Espacement interne */
    border-radius: 15px; /* Coins arrondis */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Ombres pour l'effet visuel */
    text-align: center;
    margin-right: 30px; /* Espacement par rapport au bord droit */
    align-items: center;
    justify-content: center;
    margin-left: 85%;
    margin-top: 40%;
}

.login-page h1 {
    font-size: 28px; /* Taille du titre */
    margin-bottom: 15px;
    color: #333333;
}

.login-page p {
    font-size: 16px; /* Taille du texte descriptif */
    color: #666666;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 20px; /* Espacement entre les champs */
    text-align: left;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #555555;
}

.form-control {
    width: 100%;
    padding: 12px; /* Champs plus grands */
    border: 1px solid #cccccc;
    border-radius: 8px; /* Coins arrondis des champs */
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Effet lumineux au focus */
}

.btn {
    display: inline-block;
    width: 100%;
    padding: 12px; /* Bouton plus grand */
    font-size: 16px;
    color: #ffffff;
    background-color: #007bff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.text-center p {
    margin-top: 15px; /* Espacement en bas */
    font-size: 14px;
    color: #555555;
}

.text-center a {
    color: #007bff;
    text-decoration: none;
}

.text-center a:hover {
    text-decoration: underline;
}
</style>


<div class="login-page">
    <div class="text-center">
       <h1>Bienvenue</h1>
       <p>Connectez-vous pour démarrer votre session</p>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="../users/auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Nom d’utilisateur</label>
              <input type="name" class="form-control" name="username" placeholder="Nom d’utilisateur">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" placeholder="Mot de passe">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info pull-right" 
                style="background-color:rgb(255, 143, 99)"
                >Connectez-vous</button>
        </div>
    </form>
</div>


<?php include_once '../layouts/footer.php'; ?>