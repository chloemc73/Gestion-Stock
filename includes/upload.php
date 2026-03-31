<?php
/**
 * includes/upload.php
 *
 * @package default
 */


class Media {

	public $imageInfo;
	public $fileName;
	public $fileType;
	public $fileTempPath;
	// Définir le chemin de destination pour l'upload
	public $userPath = SITE_ROOT.DS.'..'.DS.'/uploads/users';
	public $productPath = SITE_ROOT.DS.'..'.DS.'/uploads/products';


	public $errors = array();
	public $upload_errors = array(
		0 => 'Il n\'y a pas d\'erreur, le fichier a été téléchargé avec succès',
        1 => 'Le fichier téléchargé dépasse la directive upload_max_filesize dans php.ini',
        2 => 'Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML',
        3 => 'Le fichier téléchargé a été partiellement téléchargé',
        4 => 'Aucun fichier n\'a été téléchargé',
        6 => 'Il manque un dossier temporaire',
        7 => 'Échec de l\'écriture du fichier sur le disque.',
        8 => 'Une extension PHP a arrêté le téléchargement du fichier.'
	);
	public$upload_extensions = array(
		'gif',
		'jpg',
		'jpeg',
		'png',
	);

	/**
	 *
	 * @param unknown $filename
	 * @return unknown
	 */
	public function file_ext($filename) {
		$ext = strtolower(substr( $filename, strrpos( $filename, '.' ) + 1 ) );
		if (in_array($ext, $this->upload_extensions)) {
			return true;
		}
	}


	/**
	 *Traiter le fichier téléchargé

	 * @param unknown $file
	 * @return unknown
	 */
	public function upload($file) {
		if (!$file || empty($file) || !is_array($file)):
			$this->errors[] = "Aucun fichier n'a été téléchargé.";
		return false;
		elseif ($file['error'] != 0):
			$this->errors[] = $this->upload_errors[$file['error']];
		return false;
		elseif (!$this->file_ext($file['name'])):
			$this->errors[] = 'Format de fichier incorrect';
		return false;
		else:
			$this->imageInfo = getimagesize($file['tmp_name']);
		$this->fileName  = basename($file['name']);
		$this->fileType  = $this->imageInfo['mime'];
		$this->fileTempPath = $file['tmp_name'];
		return true;
		endif;

	}


	/**
	 * Vérifier et préparer le traitement du fichier média
	 * 
	 * @return unknown
	 */
	public function process() {

		if (!empty($this->errors)):
			return false;
		elseif (empty($this->fileName) || empty($this->fileTempPath)):
			$this->errors[] = "L'emplacement du fichier n'est pas disponible.";
		return false;
		elseif (!is_writable($this->productPath)):
			$this->errors[] = $this->productPath."  Doit être accessible en écriture !!!..";
		return false;
		elseif (file_exists($this->productPath."/".$this->fileName)):
			$this->errors[] = "Le fichier {$this->fileName}  existe déjà.";
		return false;
		else:
			return true;
		endif;
	}


	/*--------------------------------------------------------------*/
	/* Fonction pour traiter l'image média 
 /*--------------------------------------------------------------*/

	/**
	 *
	 * @return unknown
	 */
	public function process_media() {
		if (!empty($this->errors)) {
			return false;
		}
		if (empty($this->fileName) || empty($this->fileTempPath)) {
			$this->errors[] = "L'emplacement du fichier n'est pas disponible.";
			return false;
		}

		if (!is_writable($this->productPath)) {
			$this->errors[] = $this->productPath."  Doit être accessible en écriture !!!.";
			return false;
		}

		if (file_exists($this->productPath."/".$this->fileName)) {
			$this->errors[] = "Le fichier {$this->fileName}  existe déjà.";
			return false;
		}

		if (move_uploaded_file($this->fileTempPath, $this->productPath.'/'.$this->fileName)) {

			if ($this->insert_media()) {
				unset($this->fileTempPath);
				return true;
			}

		} else {

			$this->errors[] = "
			L'upload du fichier a échoué, probablement à
			 cause des permissions incorrectes sur le dossier d'upload.";
			return false;
		}

	}


	/*--------------------------------------------------------------*/
	/* Fonction pour traiter l'image de l'utilisateur
  /*--------------------------------------------------------------*/

	/**
	 *
	 * @param unknown $id
	 * @return unknown
	 */
	public function process_user($id) {

		if (!empty($this->errors)) {
			return false;
		}
		if (empty($this->fileName) || empty($this->fileTempPath)) {
			$this->errors[] = "L'emplacement du fichier n'est pas disponible.";
			return false;
		}
		if (!is_writable($this->userPath)) {
			$this->errors[] = $this->userPath." Doit être accessible en écriture !!!.";
			return false;
		}
		if (!$id) {
			$this->errors[] = " ID utilisateur manquant.";
			return false;
		}
		$ext = explode(".", $this->fileName);
		$new_name = randString(8).$id.'.' . end($ext);
		$this->fileName = $new_name;
		if ($this->user_image_destroy($id)) {
			if (move_uploaded_file($this->fileTempPath, $this->userPath.'/'.$this->fileName)) {

				if ($this->update_userImg($id)) {
					unset($this->fileTempPath);
					return true;
				}

			} else {
				$this->errors[] = "L'upload du fichier a échoué, probablement à
				 cause des permissions incorrectes sur le dossier d'upload.";
				return false;
			}
		}
	}


	/*--------------------------------------------------------------*/
	/* Fonction pour mettre à jour l'image de l'utilisateur dans 
	la base de données
 /*--------------------------------------------------------------*/

	/**
	 *
	 * @param unknown $id
	 * @return unknown
	 */
	private function update_userImg($id) {
		global $db;
		$sql = "UPDATE users SET";
		$sql .=" image='{$db->escape($this->fileName)}'";
		$sql .=" WHERE id='{$db->escape($id)}'";
		$result = $db->query($sql);
		return $result && $db->affected_rows() === 1 ? true : false;

	}


	/*--------------------------------------------------------------*/
	/* Fonction Supprimer l'ancienne image de l'utilisateur
 /*--------------------------------------------------------------*/

	/**
	 *
	 * @param unknown $id
	 * @return unknown
	 */
	public function user_image_destroy($id) {
		$image = find_by_id('users', $id);
		if ($image['image'] === 'no_image.jpg') {
			return true;
		} else {
			unlink($this->userPath.'/'.$image['image']);
			return true;
		}

	}


	/*--------------------------------------------------------------*/
	/* Fonction pour insérer un fichier média dans la base de données
/*--------------------------------------------------------------*/

	/**
	 *
	 * @return unknown
	 */
	private function insert_media() {

		global $db;
		$sql  = "INSERT INTO media ( file_name,file_type )";
		$sql .=" VALUES ";
		$sql .="(
                  '{$db->escape($this->fileName)}',
                  '{$db->escape($this->fileType)}'
                  )";
		return $db->query($sql) ? true : false;

	}


	/*--------------------------------------------------------------*/
	/* Fonction Supprimer un fichier média par ID
/*--------------------------------------------------------------*/

	/**
	 *
	 * @param unknown $id
	 * @param unknown $file_name
	 * @return unknown
	 */
	public function media_destroy($id, $file_name) {
		$this->fileName = $file_name;
		if (empty($this->fileName)) {
			$this->errors[] = "Le nom du fichier photo est manquant.";
			return false;
		}
		if (!$id) {
			$this->errors[] = "ID photo manquant.";
			return false;
		}
		if (delete_by_id('media', $id)) {
			unlink($this->productPath.'/'.$this->fileName);
			return true;
		} else {
			$this->error[] = "Échec de la suppression de la photo ou permission manquante.";
			return false;
		}

	}



}


?>
