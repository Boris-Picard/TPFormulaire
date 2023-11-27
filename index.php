<?php
    $minDate = (date('Y') - 100)."-01-01";
    $maxDate = date('Y-m-d');
    define('LAST_NAME', '^[A-Za-zéèçà \-]{2,50}$');
    define('POSTAL_CODE', '^[0-9]{5}$');
    define('URL_REGEX','^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)');
    define('COUNTRY_ARRAY', [
            'France', 
            'Belgique', 
            'Suisse', 
            'Luxembourg', 
            'Allemagne', 
            'Italie', 
            'Espagne', 
            'Portugal'
    ]);
    define('CHECKBOX_ARRAY', [
        'HTML/CSS', 
        'PHP', 
        'Javascript', 
        'Python', 
        'Others']);
    define('DATE_REGEX', '^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$');
    define('PASSWORD_REGEX', '(?=.*[A-Z])(?=.*[0-9]).{8,}');
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
        $file = $_FILES['profilPic'];
        $fileTemp = $_FILES['profilPic']['tmp_name'];
        $fileError = $_FILES['profilPic']['error'];
        $maxSize = 500000;
        $allowedExtension = ['jpg', 'jpeg', 'png'];
        $notAllowedExtension = ['php'];
        $allowedType = ['image/jpg', 'image/jpeg', 'image/png'];
        $fileName = pathinfo($_FILES['profilPic']['name']);
        $fileType = $_FILES['profilPic']['type'];
        $fileSize = $_FILES['profilPic']['size'];
        // $profilPic = filter_input(INPUT_POST, 'profilPic', FILTER_SANITIZE_SPECIAL_CHARS);
        if(!empty($file) && $fileError == 0) {
            if(!in_array($fileName['extension'], $allowedExtension)) {
                $error['profilPic'] = 'Veuillez upload une extension valide';
            } elseif(!in_array($fileType, $allowedType)) {
                $error['profilPic'] = 'Le type de format n\'est pas valide';
            } elseif($fileSize > $maxSize) {
                $error['profilPic'] = 'L\'image est trop grande ne dépassez pas les 500 Ko';
            } elseif(in_array($fileName['extension'], $notAllowedExtension)) {
                $error['profilPic'] = 'Fichier PHP non autorisé';
            } else {
                $filePath = './public/assets/img/' .  $_FILES['profilPic']['name'];
                $moveFile = move_uploaded_file($fileTemp, $filePath);
                $upload = "<img src=\".$filePath\" class=\"img-fluid rounded\" height=200 width=300 />";
            }
        } 
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <link rel="stylesheet" href="./public/assets/framework/bootstrap.min.css">
    <link rel="stylesheet" href="./public/assets/framework/bootstrap.min.js">
    <title>Formulaire</title>
</head>
<body>
    <header>
    </header>
    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col-12 firstContainer">
                    <h1 class="text-center h1Title">S'inscrire</h1>
                    <?php if($_SERVER['REQUEST_METHOD'] != 'POST' || !empty($error)) { ?>
                    <form method="POST" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-6 left">
                                <!-- EMAIL -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address* <span class="text-danger"><?=$error['email'] ?? ''?></span></label>
                                    <input type="email" 
                                    name="email" 
                                    value="<?=$email ?? ''?>" 
                                    class="form-control" 
                                    id="email" 
                                    required 
                                    placeholder="exemple@gmail.com" 
                                    maxlength="40" 
                                    autocomplete="email">
                                </div>
                                <!-- MOT DE PASSE -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe* <span class="text-danger"><?=$error['password'] ?? ''?></span></label> 
                                    <input type="password" 
                                    name="password" 
                                    class="form-control" 
                                    id="password" 
                                    minlength="8" 
                                    required
                                    pattern="<?=PASSWORD_REGEX?>">
                                </div>
                                <div class="eyeNone">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2"></i>
                                </div>
                                <!-- CONFIRMER LE MOT DE PASSE -->
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmer le mot de passe* <span class="text-danger"><?=$error['confirmPassword'] ?? ''?></span></label> 
                                    <input type="password" 
                                    name="confirmPassword" 
                                    class="form-control" 
                                    id="confirmPassword" 
                                    required 
                                    pattern="<?=PASSWORD_REGEX?>">
                                </div>
                                <!-- CIVILITE -->
                                <div class="">
                                    <label for="gender" class="form-label" required>Séléctionnez un genre* <span class="text-danger"><?=$error['gender'] ?? ''?></span></label>
                                </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="1" value="1" <?=(isset($gender) && $gender == 1 ? 'checked' : '')?>>
                                        <label class="form-check-label" for="1">Mr</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="gender" id="2" value="2" <?=(isset($gender) && $gender == 2 ? 'checked' : '')?>>
                                        <label class="form-check-label" for="2">Mme</label>
                                    </div>
                                <!-- NOM -->
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Nom* <span class="text-danger"><?=$error['lastname'] ?? ''?></span></label>
                                    <input type="text" 
                                    name="lastname" 
                                    class="form-control" 
                                    value="<?=$lastname ?? ''?>" 
                                    id="lastname" 
                                    placeholder="Dupont" 
                                    required 
                                    pattern="<?=LAST_NAME?>" 
                                    autocomplete="family-name">
                                </div>
                                <!-- ANNEE DE NAISSANCE -->
                                <div class="mb-3">
                                    <label for="dateBirth" class="form-label">Année de naissance <span class="text-danger"><?=$error['dateBirth'] ?? ''?></span></label>
                                    <input type="date" name="dateBirth" class="form-control" id="dateBirth" pattern="<?=DATE_REGEX?>" value="<?=$dateBirth ?? date('Y-m-d')?>" min="<?=$minDate?>" max="<?=$maxDate?>">
                                </div>
                                <div class="mb-3">
                                <!-- LIEU DE NAISSANCE -->
                                <label for="countryBirth" class="form-label">Pays de naissance* <span class="text-danger"><?=$error['countryBirth'] ?? ''?></span></label>
                                    <select class="form-select" 
                                    name="countryBirth" 
                                    id="countryBirth"
                                    required>
                                        <option selected disabled>Votre Pays</option>
                                        <?php foreach (COUNTRY_ARRAY as $country) {?>
                                            <option value="<?=$country?>"<?=(isset($countryBirth) && $countryBirth==$country) ? 'selected' : ''?>><?=$country?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 right">
                                <!-- CODE POSTAL -->
                                <div class="mb-3">
                                    <label for="postalCode" class="form-label">Code postal* <span class="text-danger"><?=$error['postalCode'] ?? ''?></span></label>
                                    <input type="text" 
                                    name="postalCode" 
                                    class="form-control" 
                                    value="<?=$postalCode ?? ''?>" 
                                    id="postalCode" 
                                    placeholder="exemple : 80000" 
                                    required 
                                    pattern="<?=POSTAL_CODE?>"
                                    autocomplete="postal-code" 
                                    inputmode="numeric">
                                </div>
                                <!-- IMAGE DE PROFIL -->
                                <div class="mb-3">
                                    <label for="profilPic" class="form-label">Photo de profil <span class="text-danger"><?=$error['profilPic'] ?? ''?></span></label>
                                    <input type="file" 
                                    name="profilPic" 
                                    value="<?=$file ?? ''?>" 
                                    class="form-control" 
                                    id="profilPic" 
                                    size="500000"
                                    accept=".jpg, .jpeg, .png"
                                    >
                                </div>
                                <!-- LIEN LINKEDIN -->
                                <div class="mb-3">
                                    <label for="url" class="form-label">Linkedin <span class="text-danger"><?=$error['url'] ?? ''?></span></label>
                                    <input type="url" 
                                    name="url" 
                                    value="<?=$url ?? '' ?>" 
                                    class="form-control" 
                                    id="url" 
                                    placeholder="https://www.linkedin.com" 
                                    pattern="<?=URL_REGEX?>"
                                    autocomplete="url">
                                </div>
                                <!-- CHECKBOX -->
                                <div class="mb-3 d-flex flex-column">
                                    <label for="languages" class="form-label">Quel langages web connaissez-vous? <span class="text-danger"><?=$error['checkbox'] ?? ''?></span></label>
                                    <div class="form-check d-flex justify-content-around checkboxDiv">
                                        <?php foreach (CHECKBOX_ARRAY as $langages) { ?>
                                            <label class="form-check-label" for="<?=$langages?>"><?=$langages?></label>
                                            <input class="form-check-input" name="checkbox[]" type="checkbox" value="<?=$langages?>" id="<?=$langages?>" <?=(isset($checkbox) && in_array($langages,$checkbox)) ? 'checked' : ''?>>
                                        <?php } ?> 
                                    </div>
                                </div>
                                <!-- TEXT AREA -->
                                <div class="mb-3">
                                    <label for="textArea" class="form-label">Expérience programmation : <span class="text-danger"><?=$error['textArea'] ?? ''?></span></label>
                                    <textarea class="form-control" 
                                    value="textArea" 
                                    name="textArea" 
                                    id="textArea" 
                                    rows="6" 
                                    maxlength="500"
                                    placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir."><?=$textArea ?? ''?></textarea>
                                </div>
                                <!-- BOUTTON SUBMIT -->
                                <button type="submit" class="btn btn-dark form-select mt-2">Envoyer</button>
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                            <p class="fw-bold">Nom : <?=$lastname?></p>
                                            <p class="fw-bold">Email : <?=$email?></p>
                                            <p class="fw-bold">Country Birth : <?=$countryBirth?></p>
                                            <p class="fw-bold">Checkbox : 
                                            <p class="fw-bold">Birthday : <?=$dateBirth?></p>
                                            <?php if($gender == 1) { ?>
                                                <p class="fw-bold">Genre : Mr</p>
                                            <?php } elseif($gender == 2) { ?>
                                                <p class="fw-bold">Genre : Mme</p>
                                            <?php } ?>
                                            <p class="fw-bold">Password : <?php if(password_verify($isOk, $hash)) { ?>
                                                <span class='text-success bg-dark fw-bold'>Success</span>
                                            <?php } ?></p>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <p class="fw-bold">Postal Code : <?=$postalCode?></p>
                                            <p class="fw-bold">Profil Pic : <?=$upload?></p>
                                            <p class="fw-bold">URL : <?=$url?></p>
                                            <?php if($checkbox != null) { ?>
                                            <?php foreach ($checkbox as $langages) { ?>
                                            <?=$langages?>
                                            <? } ?>
                                            <?php } ?></p>
                                            <?php } ?>
                                            <p class="fw-bold">Expériences : <?=$textArea?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="./public/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>