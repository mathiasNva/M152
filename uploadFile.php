<?php


if (isset($_FILES['filesToUpload'])) {
} else {
    header('Location: index.php');
}

$extensions = array('.png', '.gif', '.jpg', '.jpeg');

$maxSize = 70000000;
$maxSizePerFile = 3000000;

$filesSize = 0;
$uploadOk = 1;
$erreur = "";

foreach ($_FILES['filesToUpload']['name'] as $file => $error) {

    $singleFileSize = filesize($_FILES['filesToUpload']['tmp_name'][$file]);

    if ($singleFileSize > $maxSizePerFile) {

        $uploadOk = 0;
        $erreur .= "Un des fichiers est trop gros.\n";
    } else {

        $filesSize += $singleFileSize;
        $extension = strrchr($_FILES['filesToUpload']['tmp_name'][$file], '.');

        if (!in_array($extension, $extensions)) {

            $erreur .= "Uniquement des fichiers .png, .jpg, .jpeg ou .gif sont autorisés.\n";
        } else {

            if (!in_array($_FILES['filesToUpload']['tmp_name'][$file], $_FILES['filesToUpload']['tmp_name'])) {
            } else {
                $uploadOk = 0;
                $erreur .= "Plusieurs fichiers ont des noms identiques.\n";
            }
        }
    }

    if ($_FILES['filesToUpload']['size'] > $maxSize) {

        $erreur .= "L'ensemble des fichiers a une taille trop élevée\n";
    }

    if ($uploadOk == 1) {
        if (isset($_FILES['filesToUpload'])) {
            $folder = './assets/uploaded';
            $file = basename($_FILES['filesToUpload']['name'][$file]);
            if (move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$file], $folder . $file)) {
                echo 'Upload effectué avec succès !';
            } else {
                echo 'Echec de l\'upload !';
            }
        }
    } 
    else {
        echo $erreur;
    }
}

?>