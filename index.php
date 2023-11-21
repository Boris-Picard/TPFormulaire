<?php
    $error = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lastname = htmlspecialchars($_POST['lastname']);
        if(!empty($_POST['lastname']) 
        && strlen($lastname) >= 2
        && strlen($lastname) <= 50 
        && preg_match("/^[A-Za-zéèçà]{2,50}(-| )?([A-Za-zéèçà]{2,50})?$/",$lastname)) {
            $lastname = $_POST['lastname'];
        } else {
            $error['lastname'] = 'Votre nom n\'est pas valide';
        }
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
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-6 left">
                                <!-- EMAIL -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address*</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Dupont@aol.fr" pattern="^[A-Za-z]+@{1}[A-Za-z]+\.{1}[A-Za-z]{2,}$" maxlength="25">
                                </div>
                                <!-- MOT DE PASSE -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe*</label> 
                                    <input type="password" name="password" class="form-control" id="password" minlength="8" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$">
                                </div>
                                <!-- CONFIRMER LE MOT DE PASSE -->
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmer le mot de passe*</label> 
                                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" minlength="8" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$">
                                </div>
                                <!-- GENRE -->
                                <div class="mb-3">
                                <label for="gender" class="form-label">Séléctionnez un genre*</label>
                                <select class="form-select" name="gender">
                                    <option selected disabled>Votre civilité</option>
                                    <option value="1">Mr</option>
                                    <option value="2">Mme</option>
                                </select>
                                </div>
                                <!-- NOM -->
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Nom* <span class="text-danger"><?=$error['lastname'] ?? ''?></span></label>
                                    <input type="text" name="lastname" class="form-control" value="<?=$lastname ?? ''?>" id="lastname" placeholder="Dupont" required pattern="^[A-Za-zéèçà]{2,50}(-| )?([A-Za-zéèçà]{2,50})?$" minlength="2" maxlength="50">
                                </div>
                                <!-- ANNEE DE NAISSANCE -->
                                <div class="mb-3">
                                    <label for="dateBirth" class="form-label">Année de naissance</label>
                                    <input type="date" name="dateBirth" class="form-control" id="dateBirth" min="1950-01-01" max="2005-12-31">
                                </div>
                                <div class="mb-3">
                                <!-- LIEU DE NAISSANCE -->
                                <label for="countryBirth" class="form-label">Pays de naissance*</label>
                                    <select class="form-select" name="countryBirth">
                                        <option selected disabled>Votre Pays</option>
                                        <option value="1">France</option>
                                        <option value="2">Belgique</option>
                                        <option value="3">Suisse</option>
                                        <option value="4">Luxembourg</option>
                                        <option value="5">Allemagne</option>
                                        <option value="6">Italie</option>
                                        <option value="7">Espagne</option>
                                        <option value="8">Portugal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 right">
                                <!-- CODE POSTAL -->
                                <div class="mb-3">
                                    <label for="postalCode" class="form-label">Code postal*</label>
                                    <input type="text" name="postalCode" class="form-control" id="postalCode" placeholder="exemple : 80000" pattern="^((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B)) *([0-9]{3})?$">
                                </div>
                                <!-- IMAGE DE PROFIL -->
                                <div class="mb-3">
                                    <label for="profilPic" class="form-label">Photo de profil</label>
                                    <input type="file" name="profilPic" class="form-control" id="profilPic">
                                </div>
                                <!-- LIEN LINKEDIN -->
                                <div class="mb-3">
                                    <label for="url" class="form-label">Linkedin</label>
                                    <input type="url" name="url" class="form-control" id="url" placeholder="https://www.linkedin.com/name" pattern="https://.*">
                                </div>
                                <!-- LANGAGES CHECKBOX -->
                                <div class="mb-3 d-flex flex-column">
                                    <label for="languages" class="form-label">Quel langages web connaissez-vous?</label>
                                    <div class="form-check d-flex justify-content-around checkboxDiv">
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="html" id="checkboxHtml">
                                        <label class="form-check-label" for="checkbox">
                                            HTML/CSS
                                        </label>
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="php" id="checkboxPhp">
                                        <label class="form-check-label" for="checkbox">
                                            PHP
                                        </label>
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="javascript" id="checkboxJs">
                                        <label class="form-check-label" for="checkbox">
                                            Javascript
                                        </label>
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="python" id="checkboxPython">
                                        <label class="form-check-label" for="checkbox">
                                            Python
                                        </label>
                                        <input class="form-check-input" name="checkbox" type="checkbox" value="others" id="checkboxOthers">
                                        <label class="form-check-label" for="checkbox">
                                            Autres
                                        </label>
                                    </div>
                                </div>
                                <!-- TEXT AREA -->
                                <div class="mb-3">
                                    <label for="textArea" class="form-label">Expérience programmation :</label>
                                    <textarea class="form-control" name="textArea" id="textArea" rows="6" placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir." maxlength="500"></textarea>
                                </div>
                                <!-- BOUTTON SUBMIT -->
                                <button type="submit" class="btn btn-dark form-select mt-2">Submit</button>
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                        <div>
                            <?=$lastname?>
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