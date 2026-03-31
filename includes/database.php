<?php
/**
 * includes/database.php
 *
 * @package default
 */

// Inclure le fichier de configuration
require_once LIB_PATH_INC.DS."config.php";

class MySqli_DB {

	private $con;
	public $query_id;

	/**
	 * Constructeur de la classe
	 */
	function __construct() {
		$this->db_connect();
	}

	/*--------------------------------------------------------------*/
	/* // Fonction pour ouvrir une connexion à une base de données
	/*--------------------------------------------------------------*/
	public function db_connect() {
		$this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS); // Connexion à la base de données
		if (!$this->con) {
			die("Database connection failed: " . mysqli_connect_error()); // Affiche une erreur en cas d'échec
		} else {
			$select_db = $this->con->select_db(DB_NAME); // Sélection de la base de données
			if (!$select_db) {
				die("Failed to select database: " . mysqli_connect_error()); // Affiche une erreur si la sélection échoue
			}
		}
	}

	/*--------------------------------------------------------------*/
	/*  Fonction pour fermer une connexion à une base de données
	/*--------------------------------------------------------------*/
	public function db_disconnect() {
		if (isset($this->con)) {
			mysqli_close($this->con);
			unset($this->con);
		}
	}

	/*--------------------------------------------------------------*/
	/* Fonction pour exécuter une requête MySQLi
	/*--------------------------------------------------------------*/
	public function query($sql) {
		if (trim($sql != "")) {
			$this->query_id = $this->con->query($sql);
		}
		if (!$this->query_id) {
			die("Error on this query: <pre> " . $sql . "</pre>");
		}
		return $this->query_id;
	}

	/*--------------------------------------------------------------*/
	/* // Fonction d'aide pour exécuter une requête SQL et récupérer les résultats
	/*--------------------------------------------------------------*/
	public function fetch_array($statement) {
		return mysqli_fetch_array($statement);
	}

	public function fetch_object($statement) {
		return mysqli_fetch_object($statement);
	}

	public function fetch_assoc($statement) {
		return mysqli_fetch_assoc($statement);
	}

	public function num_rows($statement) {
		return mysqli_num_rows($statement);
	}

	public function insert_id() {
		return mysqli_insert_id($this->con);
	}

	public function affected_rows() {
		return mysqli_affected_rows($this->con);
	}

	/*--------------------------------------------------------------*/
	/* // Fonction pour échapper les caractères spéciaux dans une chaîne
	//  pour une requête SQL
	/*--------------------------------------------------------------*/
	public function escape($str) {
		return $this->con->real_escape_string($str);
	}

	/*--------------------------------------------------------------*/
	/* // Fonction pour exécuter une boucle while avec un résultat SQL
	/*--------------------------------------------------------------*/
	public function while_loop($loop) {
		global $db;
		$results = array();
		while ($result = $this->fetch_array($loop)) {
			$results[] = $result;
		}
		return $results;
	}
}

$db = new MySqli_DB();
?>