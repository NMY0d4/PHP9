<?php
$monTitre = 'Coucou';
require('inc/function.php');

 $fruits = [
    "banane" => '-- Banane 🍌 --',
    "raisins" => '-- Raisins 🍇 --',
    "cerise" => '-- Cerise 🍒 --',
    "fraise" => '-- Fraise 🍓 --',                
]; 

$errors = [];
$success = false;

// traitement du formulaire
// debug($_POST);
// if (!empty($_GET['nom']) && !empty($_GET['prenom'])) {
//     echo 'Bonjour '.$_GET['nom'].' '.$_GET['prenom'];
// }
// if (!empty($_POST['nom']) && !empty($_POST['prenom'])) {
//      echo 'Bonjour '.$_POST['nom'].' '.$_POST['prenom'];
//  }
// debug($errors);
// debug($_POST);


// traitement du formulaire

if(!empty($_POST['submitted'])) {
   // Faille XSS
   $nom = trim(strip_tags($_POST['nom']));
   $prenom = trim(strip_tags($_POST['prenom']));
   $email = trim(strip_tags($_POST['email']));
   $fruit = trim(strip_tags($_POST['fruits']));   
   

   // Validation
   ///////////////  nom
      
    $errors = check($errors, $nom, 'nom');
    
//    if (!empty($nom)) {
//         if (mb_strlen($nom) < 3) {
//             $errors['nom'] = 'erreurs : 3 caractères minimum';
//         } elseif (mb_strlen($nom) > 10) {
//         $errors['nom'] = 'erreurs : 70 caractères maximum';       
//         } 
//    } else {
//        $errors['nom'] = 'erreurs : veuillez renseignez ce champ';
//    }

   ////////////////   prenom

    $errors = check($errors, $prenom, 'prenom', 5, 50);

//    if (!empty($prenom)) {
//         if (mb_strlen($prenom) < 5) {
//             $errors['prenom'] = 'erreurs : 3 caractères minimum';
//         } elseif (mb_strlen($prenom) > 50) {
//         $errors['prenom'] = 'erreurs : 50 caractères maximum';       
//         } 
//     } else {
//         $errors['prenom'] = 'erreurs : veuillez renseignez ce champ';
//     }

    /////////////   email
    $errors = checkEmail($errors, $email, 'email');

//     if (!empty($email)) {
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $errors['email'] = 'erreurs : rentrez un email valide';               
//         } 
//     } else {
//         $errors['email'] = 'erreurs : veuillez renseignez ce champ';
//     }

    if(!empty($fruit)) {
        if(!array_key_exists($fruit, $fruits)) {
            $errors['fruit'] = 'Error fucking hacker';
        }
    } else {
        $errors['fruits'] = 'Veuillez renseigner un fruit svp';
    }

    if (count($errors) == 0) {
        // die ('ok, pas d\'erreurs');
        $success = true;
    }

 }

// if(!empty($_POST['submitted2'])) {
//     die('ok form soumis numero 2');
// }

include('inc/header.php');
?>
<body>
    
    <div class="wrap">
        <h1>les formulaires à travers les âges.</h1>
        <?php if ($success === true) { ?>
            <h2> Bravo votre formulaire a été envoyé avec succès.. </h2>
        <?php } else {?>            
                <form action="" method="POST" class="flexcol" novalidate>
                    
                <label for="nom">Nom : (min 3, max 70)</label>
                <input type="text" name="nom" id="nom" value="<?php if(!empty($_POST['nom'])) { echo $_POST['nom']; } ?>">            
                <span class="error"><?php if(!empty($errors['nom'])) { echo $errors['nom']; } ?></span>

                <label for="prenom">Prenom : (min 5, max 50)</label>
                <input type="text" name="prenom" id="prenom" value="<?php if(!empty($_POST['prenom'])) { echo $_POST['prenom']; } ?>"> 
                <span class="error"><?php if(!empty($errors['prenom'])) { echo $errors['prenom']; } ?></span>
                
                <label for="mail">mail :</label>
                <input type="email" name="email"id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>"> 
                <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
                
                <label for="fruits">Choisissez un fruit :</label>
                <select name="fruits" id="fruits">
                    <option value="">-- choisissez un fruit --</option>
                    <?php foreach ($fruits as $key => $fruit) { ?>
                        <option value="<?= $key; ?>"<?php 
                        if(!empty($_POST['fruits']) && $_POST['fruits'] === $key) {
                            echo ' selected';                        
                        }
                        ?>> <?= $fruit; ?> </option>
                    <?php } ?>                
                    
                </select>
                <span class="error"><?php if(!empty($errors['fruits'])) { echo $errors['fruits']; } ?></span>            
                
                <!-- Soumettre le formulaire -->
                <input id="valider" type="submit" name="submitted" value="Envoyer">
            </form>
        <?php } ?>
        <!-- <form action="" method="post">
            <input type="submit" name="submitted2" value="Envoyer"> 
        </form>
    </div> -->
    
</body>
<?php
include('inc/footer.php');
