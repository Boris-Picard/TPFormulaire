<div class="container">
    <div class="row">
        <div class="col-12 firstContainer">
            <h1 class="text-center h1Title">S'inscrire</h1>
        <?php if($_SERVER['REQUEST_METHOD'] != 'POST' || !empty($error)) { ?>
        <form method="POST" enctype="multipart/form-data">
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
            <label for="profilPic" class="form-label">Photo de profil* <span class="text-danger"><?=$error['profilPic'] ?? ''?></span></label>
            <input type="file" 
            name="profilPic" 
            value="profilPic" 
            class="form-control" 
            id="profilPic" 
            accept=".jpg, .jpeg, .png">
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
            rows="7 " 
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
                    <p class="fw-bold">Profil Pic : <img src="/public/uploads/users/<?=$front?>" alt="uploaded img" class="img-fluid rounded-circle" height="200" width="200"></p>
                    <p class="fw-bold">URL : <?=$url?></p>
                    <?php if($checkbox != null) { ?>
                    <?php foreach ($checkbox as $langages) { ?>
                    <p class="fw-bold">Langages : <?=$langages?></p>
                    <? } ?>
                    <?php } ?></p>
                    <?php } ?>
                    <p class="fw-bold">Expériences : <?=$textArea?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


