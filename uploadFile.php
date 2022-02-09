<?php

if (isset($_FILES['filesToUpload'])) {
} else {
    header('Location: index.php');
}

// tableau qui stock les extensions des images
$extensions = array('.png', '.gif', '.jpg', '.jpeg');

// taille max 
$maxSize = 70000000;
// taille min
$maxSizePerFile = 3000000;

$filesSize = 0;
$uploadOk = 1;
$erreur = "";
$cpt = 0;

foreach ($_FILES['filesToUpload']['name'] as $file => $error) {

    $singleFileSize = filesize($_FILES['filesToUpload']['tmp_name'][$file]);

    // Si la taille d'un seul fichier est supérieur à la taille max alors il affiche un message d'erreur
    if ($singleFileSize > $maxSizePerFile) {
        
        $uploadOk = 0;
        $erreur .= "Le fichier est trop gros \n";

    } else {

        $filesSize += $singleFileSize;

        $extension = strrchr($_FILES['filesToUpload']['tmp_name'][$file], '.');

        if (!in_array($extension, $extensions)) {

            $uploadOk = 0;
            $erreur .= "Uniquement des fichiers .png, .jpg, .jpeg ou .gif sont autorisés.\n";

        } else {

            if (!in_array($_FILES['filesToUpload']['tmp_name'][$file], $_FILES['filesToUpload']['tmp_name'])) {
            } else {

                $uploadOk = 0;
                $erreur .= "Vos fichier se nomme de la même façon \n";
            }
        }
    }

    if ($_FILES['filesToUpload']['size'] > $maxSize) {

        $uploadOk = 0;
        $erreur .= "Vos fichiers sont trop gros \n";
    }

    if ($uploadOk == 1) {

        if (isset($_FILES['filesToUpload'])) {

            $folder = './assets/uploaded/';

            if (move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$file], $folder . $_FILES['filesToUpload']['name'][$file])) {

                echo 'L\'upload à été effectué avec succès !';

            } else {

                echo 'L\'upload est un échec !';
                echo $folder . $file;

            }
        }
    } 
    else {
        echo $erreur;
        
break;
    }

}

?>