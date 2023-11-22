<?php
    define('LAST_NAME', '^[A-Za-zéèçà \-]{2,50}$');
    define('POSTAL_CODE', '^[0-9]{5}$');
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
            $isOk = filter_var($url, FILTER_VALIDATE_URL);
            if(!$isOk || !str_contains($url, 'linkedin.com/in/')) {
                $error['url'] = 'Votre url n\'est pas valide';
            }
        }
        // PAYS DE NAISSANCE
        $countryBirth = filter_input(INPUT_POST, 'countryBirth',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(empty($countryBirth)) {
            $error['countryBirth'] = 'Veuillez séléctionner un Pays';
        }elseif (!in_array($countryBirth, ['France', 'Belgique', 'Suisse', 'Luxembourg', 'Allemagne', 'Italie', 'Espagne', 'Portugal'])) {
            $error['countryBirth'] = 'Ce n\'est pas un pays valide';
        }
        // CHECKBOX
        // DATE
        // CIVILITE
        // MOT DE PASSE        
        // IMAGE DE PROFIL
        // TEXTAREA
        
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
                                    <label for="gender" class="form-label" required>Séléctionnez un genre*</label>
                                </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender">
                                        <label class="form-check-label" for="genderMr">Mr</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="gender" id="gender">
                                        <label class="form-check-label" for="genderMme">Mme</label>
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
                                    pattern=<?=LAST_NAME?> 
                                    autocomplete="family-name">
                                </div>
                                <!-- ANNEE DE NAISSANCE -->
                                <div class="mb-3">
                                    <label for="dateBirth" class="form-label">Année de naissance</label>
                                    <input type="date" name="dateBirth" class="form-control" id="dateBirth" min="1950-01-01" max="2005-12-31">
                                </div>
                                <div class="mb-3">
                                <!-- LIEU DE NAISSANCE -->
                                <label for="countryBirth" class="form-label">Pays de naissance* <span class="text-danger"><?=$error['countryBirth'] ?? ''?></span></label>
                                    <select class="form-select" 
                                    name="countryBirth" 
                                    id="countryBirth"
                                    required>
                                        <option selected disabled>Votre Pays</option>
                                        <option value="France" <?= (isset($countryBirth) && $countryBirth=='France') ? 'selected' : ''?>>France</option>
                                        
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
                                    pattern=<?=POSTAL_CODE?>
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
                                    pattern="https://.*" 
                                    autocomplete="url">
                                </div>
                                <!-- LANGAGES CHECKBOX -->
                                <div class="mb-3 d-flex flex-column">
                                    <label for="languages" class="form-label">Quel langages web connaissez-vous?</label>
                                    <div class="form-check d-flex justify-content-around checkboxDiv">
                                        <label class="form-check-label" for="checkbox">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="html" id="checkboxHtml">
                                        HTML/CSS</label>
                                        <label class="form-check-label" for="checkboxPhp">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="php" id="checkboxPhp">
                                            PHP
                                        </label>
                                        <label class="form-check-label" for="checkboxJs">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="javascript" id="checkboxJs">
                                            Javascript
                                        </label>
                                        <label class="form-check-label" for="checkboxPython">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="python" id="checkboxPython">
                                            Python
                                        </label>
                                        <label class="form-check-label" for="checkboxOthers">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="others" id="checkboxOthers">
                                            Autres
                                        </label>
                                    </div>
                                </div>
                                <!-- TEXT AREA -->
                                <div class="mb-3">
                                    <label for="textArea" class="form-label">Expérience programmation : <span class="text-danger"></span> </label>
                                    <textarea class="form-control" value="" name="textArea" id="textArea" rows="6" placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir." maxlength=""></textarea>
                                </div>
                                <!-- BOUTTON SUBMIT -->
                                <button type="submit" class="btn btn-dark form-select mt-2">Submit</button>
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
                            <p class="fw-bold">Gender : <?=$gender?></p>
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