<?php

require "./bdd.php";

if (isset($_FILES['filesToUpload'])) {
} else {
    header('Location: index.php');
}

// tableau qui stock les extensions des images
$extensions = array('.png', '.gif', '.jpg', '.jpeg');

// taille max 
define("MAXSIZEFILE", 70*1024*1024);
// taille min
define("MINSIZEFILE", 30*1024*1024);

$totalFileSize = array_sum($_FILES['filesToUpload']['size']);

$filesSize = 0;
$uploadOk = 1;
$erreur = "";
$cpt = 0;
$verifiedFiles = [];

foreach ($_FILES['filesToUpload']['name'] as $file => $error) {

    $singleFileSize = filesize($_FILES['filesToUpload']['tmp_name'][$file]);

    // Verification 
    // Si la taille d'un seul fichier est supérieur à la taille max alors il affiche un message d'erreur
    if ($singleFileSize > $maxSizePerFile) {
        $uploadOk = 0;
        $erreur .= "Le fichier est trop gros \n";
    } else {

        $filesSize += $singleFileSize;

        $extension = strrchr($_FILES['filesToUpload']['name'][$file], '.');

        // Si ce n'est pas une exetnsion qui est correcte
        if (!in_array($extension, $extensions)) {

            $uploadOk = 0;
            $erreur .= "Uniquement des fichiers .png, .jpg, .jpeg ou .gif sont autorisés ! \n";

        } else {

            if (!in_array(pathinfo($_FILES['filesToUpload']['name'][$file], PATHINFO_FILENAME), $verifiedFiles)) {

                array_push($verifiedFiles, pathinfo($_FILES['filesToUpload']['name'][$file], PATHINFO_FILENAME));

            } 
            else {

                $uploadOk = 0;
                $erreur .= "Vos fichier se nomme de la même façon ! \n";

            }
        }
    }

    if ($totalFileSize > $maxSize) {

        $uploadOk = 0;
        $erreur .= "Vos fichiers sont trop gros ! \n";

    }

    // Upload 
    if ($uploadOk == 1) {

        if (isset($_FILES['filesToUpload'])) {

            $upload_folder = "./media/img/updatesImages/";
            $file_location = $_FILES["filesToUpload"]["name"][$file];

            // Deplace l'upload dans media/img
            if (move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$file], $upload_folder.$file_location)) {

                echo 'L\'upload à été effectué avec succès !';
                bddImage($_FILES['filesToUpload']['type'][$file], $_FILES['filesToUpload']['name'][$file]);

            } else {
                echo 'Un problème est survenu lors de l\'upload !';

            }
        }
    } 
    else {
        echo $erreur;
        break;
    }

}

?>