<?php 
    include('./config/regex.php');
    include('./config/constantes.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = [];
    // LASTNAME
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($lastname)) {
        $error['lastname'] = 'Veuillez entrer un Nom';
    } else {
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.LAST_NAME.'/')));
        if(!$isOk) {
            $error['lastname'] = 'Votre nom n\'est pas valide';
            } 
        }
    // EMAIL
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if(empty($email)) {
        $error['email'] = 'Veuillez entrer un email';
    } else {
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$isOk) {
            $error['email'] = 'Votre email n\'est pas valide';
        }
    }
    // ZIP CODE
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_NUMBER_INT);
    if(empty($postalCode)) {
        $error['postalCode'] = 'Veuillez entrer un code postal valide';
    } else {
        $isOk = filter_var($postalCode, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.POSTAL_CODE.'/')));
        if(!$isOk) {
            $error['postalCode'] = 'Votre code postal n\'est pas valide';
        }
    }
    // URL
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
    if(!empty($url)) {
        $isOk = filter_var($url, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.URL_REGEX.'/')));
        if(!$isOk) {
            $error['url'] = 'Votre url n\'est pas valide';
        }
    }
    // PAYS DE NAISSANCE
    $countryBirth = filter_input(INPUT_POST, 'countryBirth',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(empty($countryBirth)) {
        $error['countryBirth'] = 'Veuillez séléctionner un Pays';
    } elseif (!in_array($countryBirth,COUNTRY_ARRAY)) {
        $error['countryBirth'] = 'Ce n\'est pas un pays valide';
    }
    // CHECKBOX
    $checkbox = filter_input(INPUT_POST,'checkbox', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    if($checkbox != null) {
        foreach ($checkbox as $langages) {
            if(!empty($checkbox) && !in_array($langages,CHECKBOX_ARRAY)) {
                $error['checkbox'] = "Veuillez séléctionner un langage valide";
            }
        }
    }
    // DATE
    $dateBirth = filter_input(INPUT_POST,'dateBirth', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($dateBirth)) {
        $isOk = filter_var($dateBirth, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.DATE_REGEX.'/')));
        if (!$isOk || $dateBirth >= $maxDate || $dateBirth <= $minDate) {
            $error['dateBirth'] = 'Veuillez entrer une date valide';
        }
    }
    // CIVILITE
    $gender = intval(filter_input(INPUT_POST,'gender', FILTER_SANITIZE_NUMBER_INT));
    if(empty($gender)) {
        $error['gender'] = 'Veuillez séléctionner un genre';
    } else {
        $isOk = filter_var($gender, FILTER_VALIDATE_INT, array("options"=>array("min_range" => 1, "max_range" => 2 )));
        if(!$isOk) {
            $error['gender'] = 'Le genre n\'est pas valide';
        }
    }
    // MOT DE PASSE
    $password = filter_input(INPUT_POST, 'password');
    $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
    if(empty($password)) {
        $error['password'] = 'Veuillez entrer un mot de passe';
    } elseif(empty($confirmPassword)) {
        $error['confirmPassword'] = 'Veuillez entrer un mot de passe';
    } else {
        $isOk = filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.PASSWORD_REGEX.'/')));
        $isConfirmOk = filter_var($confirmPassword, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.PASSWORD_REGEX.'/')));
        if(!$isOk && !$isConfirmOk) {
            $error['password'] = "Veuillez entrer un mot de passe valide";
        } elseif($isOk != $isConfirmOk) {
            $error['confirmPassword'] = "Veuillez entrer le même mot de passe";
        } else {
            $hash = password_hash($isOk, PASSWORD_DEFAULT);
        }
    }
    // TEXTAREA
    $textArea = filter_input(INPUT_POST, 'textArea', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($textArea)) {
        if(strlen($textArea) > 500) {
            $error['textArea'] = 'Veuillez ne pas dépasser les 500 caractères';
        } 
    }
    // IMAGE DE PROFIL
    try {
        if(empty($_FILES['profilPic']['name'])) {
            throw new Exception("Photo obligatoire");
        }
        if($_FILES['profilPic']['error'] != 0) {
            throw new Exception("Error");
        }
        if(!in_array($_FILES['profilPic']['type'], IMAGE_TYPES)) {
            throw new Exception("Format non autorisé");
        }
        if($_FILES['profilPic']['size'] > IMAGE_SIZE) {
            throw new Exception("Image trop grande");
        }
        
        $fileName = uniqid('img_');
        $extension = pathinfo($_FILES['profilPic']['name'], PATHINFO_EXTENSION);

        $from = $_FILES['profilPic']['tmp_name'];
        $to = './public/uploads/users/' .$fileName.'.'.$extension;

        $moveFile = move_uploaded_file($from,$to);
        $upload = "<img src=\".$to\" class=\"img-fluid rounded-circle\" height=200 width=300 />";
    } catch (\Throwable $th) {
        $error['profilPic'] = $th->getMessage();
    }
}
?>