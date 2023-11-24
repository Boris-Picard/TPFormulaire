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
        $checkbox = filter_input(INPUT_POST,'checkbox', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
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
            $isOk = filter_var($gender, FILTER_VALIDATE_INT, array("options"=>array("min_range" => 0, "max_range" => 1 )));
            if(!$isOk) {
                $error['gender'] = 'Le genre n\'est pas valide';
            }
        }
        // MOT DE PASSE        
        // TEXTAREA
        // IMAGE DE PROFIL
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <form method="POST" novalidate>
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
                                    <label for="password" class="form-label">Mot de passe*</label> 
                                    <input type="password" 
                                    name="password" 
                                    class="form-control" 
                                    id="password" 
                                    minlength="8" 
                                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$">
                                </div>
                                <!-- CONFIRMER LE MOT DE PASSE -->
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmer le mot de passe*</label> 
                                    <input type="password" 
                                    name="confirmPassword" 
                                    class="form-control" 
                                    id="confirmPassword" 
                                    minlength="8" 
                                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$">
                                </div>
                                <!-- CIVILITE -->
                                <div class="">
                                    <label for="gender" class="form-label" required>Séléctionnez un genre* <span class="text-danger"><?=$error['gender'] ?? ''?></span></label>
                                </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="0" value="0">
                                        <label class="form-check-label" for="0">Mr</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="gender" id="1" value="1">
                                        <label class="form-check-label" for="1">Mme</label>
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
                                    <label for="profilPic" class="form-label">Photo de profil</label>
                                    <input type="file" name="profilPic" class="form-control" id="profilPic">
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
                                    <label for="textArea" class="form-label">Expérience programmation : <span class="text-danger"></span> </label>
                                    <textarea class="form-control" value="" name="textArea" id="textArea" rows="6" placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir." maxlength=""></textarea>
                                </div>
                                <!-- BOUTTON SUBMIT -->
                                <button type="submit" class="btn btn-dark form-select mt-2">Envoyer</button>
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                        <div>
                            <p class="fw-bold">Nom : <?=$lastname?></p>
                            <p class="fw-bold">Email : <?=$email?></p>
                            <p class="fw-bold">Postal Code : <?=$postalCode?></p>
                            <p class="fw-bold">URL : <?=$url?></p>
                            <p class="fw-bold">Country Birth : <?=$countryBirth?></p>
                            <p class="fw-bold">Checkbox : <?php foreach ($checkbox as $langages) { ?>
                                <?=$langages?>
                            <?php } ?></p>
                            <p class="fw-bold">Birthday : <?=$dateBirth?></p>
                            <?php if($gender == 0) { ?>
                                Genre : "Mr"
                            <?php } elseif($gender == 1) { ?>
                                Genre : "Mme"
                            <?php } ?>
                        </div>
                    <?php } ?>
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