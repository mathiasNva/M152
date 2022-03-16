
<?php 
require "constantes.inc.php";

function dbconnect(){
    static $connector = null;

    if($connector == null){
        try{
            $connector = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DBNAME, DBUSER, PASSWORD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_PERSISTENT => true));
            
        }
        catch(PDOException $Exception){
            error_log($Exception->getMessage());
            error_log($Exception->getCode());
        };
    }
    $connector->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


    return $connector;
}

/**
 * Ajoute une nouvelle média avec ses paramètres
 * @param mixed $typeMedia Le type du média
 * @param mixed $nomMedia Le nom du média
 * @param mixed $creationDate  La date de création du média
 * @return bool true si réussi
 */
function bddImage($typeMedia, $nomMedia, $creationDate, $idPost)
{
    static $ps = null;
    $sql = "INSERT INTO `M152`.`media` (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) ";
    $sql .= "VALUES (:TYPEMEDIA, :NOMMEDIA, :CREATIONDATE, :IDPOST)";
    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':TYPEMEDIA', $typeMedia, PDO::PARAM_STR);
        $ps->bindParam(':NOMMEDIA', $nomMedia, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, PDO::PARAM_STR);
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $answer = $ps->execute();
    } catch (PDOException $e) {
        error_log(json_encode($e));
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * Met à jour une média existante 
 * @param mixed $idPost
 * @param mixed $commentaire
 * @param mixed $modificationDate 
 * @return bool 
 */
function updateMedia($idMedia, $typeMedia, $nomMedia, $modificationDate)
{
    static $ps = null;

    $sql = "UPDATE `M152`.`media` SET ";
    $sql .= "`typeMedia` = :TYPEMEDIA, ";
    $sql .= "`nomMedia` = :COMMENTAIRE, ";
    $sql .= "`modificationDate` = :MODIFICATIONDATE, ";
    $sql .= "WHERE (`idMedia` = :IDMEDIA)";
    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDMEDIA', $idMedia, PDO::PARAM_INT);
        $ps->bindParam(':TYPEMEDIA', $typeMedia, PDO::PARAM_STR);
        $ps->bindParam(':NOMMEDIA', $nomMedia, PDO::PARAM_STR);
        $ps->bindParam(':MODIFICATIONDATE', $modificationDate, PDO::PARAM_STR);
        $ps->execute();
        $answer = ($ps->rowCount() > 0);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}
function createPost($commentaire, $creationDate)
{
    $sql = "INSERT INTO `M152`.`post` (`commentaire`, `creationDate`) ";
    $sql .= "VALUES (:COMMENTAIRE, :CREATIONDATE)";
    $pdo = dbconnect();
    $ps = $pdo->prepare($sql);
    try {
        $ps->bindParam(':COMMENTAIRE', $commentaire, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, PDO::PARAM_STR);
        //$ps->bindParam(':CREATIONDATE', $creationDate, date("Y-m-d H:i:s"));
        $ps->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $pdo->lastInsertId();
}

function createMediaAndPost($typeMedia, $nomMedia, $creationDate, $commentaire, $alreadyLoop)
{
    static $ps = null;
    static $LastidPost = null; 
    $answer = false;
    $idPost = $LastidPost;
    try { 
        //beginTransaction
        dbconnect()->beginTransaction();
        if ($alreadyLoop == 0) {
            //creation Post
            $sql = "INSERT INTO `M152`.`post` (`commentaire`, `creationDate`) ";
            $sql .= "VALUES (:COMMENTAIRE, :CREATIONDATE)";
            $pdo = dbconnect();
            $ps = $pdo->prepare($sql);
            $ps->bindParam(':COMMENTAIRE', $commentaire, PDO::PARAM_STR);
            $ps->bindParam(':CREATIONDATE', $creationDate, date("Y-m-d H:i:s"));
            $answer = $ps->execute();
            $idPost = $pdo->lastInsertId();
            $ps->close;
        }
        //Creation Media
        $sql = "INSERT INTO `M152`.`media` (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) ";
        $sql .= "VALUES (:TYPEMEDIA, :NOMMEDIA, :CREATIONDATE, :IDPOST)";
        $ps = dbconnect()->prepare($sql);
        $ps->bindParam(':TYPEMEDIA', $typeMedia, PDO::PARAM_STR);
        $ps->bindParam(':NOMMEDIA', $nomMedia, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, PDO::PARAM_STR);
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $answer = $ps->execute();
        $LastidPost = $idPost;
        $ps->close;

        //commit
        dbconnect()->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        //rollBack  
        dbconnect()->rollBack();
    }
    return $answer;
}


function LastIdReturn()
{
    static $ps = null;
    $sql = 'SELECT idPost ';
    $sql .= ' FROM M152.post';
    $sql .= ' ORDER BY idPost DESC LIMIT 1';
    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * Supprime la post avec l'id $idPost.
 * @param mixed $idPost
 * @return bool 
 */
function deletePost($idPost)
{
    static $ps = null;
    $sql = "DELETE FROM `M152`.`post` WHERE (`idPost` = :IDPOST);";
    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $ps->execute();
        $answer = ($ps->rowCount() > 0);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * Supprime la note avec l'id $idMedia.
 * @param mixed $idMedia
 * @return bool 
 */
function deleteMedia($idMedia)
{
    static $ps = null;
    $sql = "DELETE FROM `M152`.`media` WHERE (`idMedia` = :IDMEDIA);";
    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDMEDIA', $idMedia, PDO::PARAM_INT);
        $ps->execute();
        $answer = ($ps->rowCount() > 0);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}


function countImagesMediaAssoc($idPost)
{
    static $ps = null;

    $sql = ' SELECT count(m.idMedia) as nb';
    $sql .= ' FROM M152.media as m ';
    $sql .= ' WHERE m.idPost = :IDPOST; ';

    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);

        if ($ps->execute())
            $answer = $ps->fetch(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function readMediaAssoc($idPost)
{
    static $ps = null;

    $sql = 'SELECT m.idPost, m.nomMedia, m.typeMedia ,p.commentaire';
    $sql .= ' FROM M152.media as m, M152.post as p ';
    $sql .= ' WHERE m.idPost = p.idPost AND m.idPost = :IDPOST; ';

    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);

        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function readPost()
{
    static $ps = null;
    $sql = 'SELECT *';
    $sql .= ' FROM M152.post';

    if ($ps == null) {
        $ps = dbconnect()->prepare($sql);
    }
    $answer = false;
    try {
        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function PostAndMediaToCarousel()
{
    $html = "";

    for ($i = LastIdReturn()[0]["idPost"]; $i >= 1; $i--) {
        $readMediasPost = readMediaAssoc($i);

        $html .= "<div class=\"panel panel-default\">";
        $html .= "<div id=\"myCarousel$i\" class=\"carousel slide\" data-interval=\"false\" data-ride=\"carousel\">";

        // Indicators -->
        $html .= "<ol class=\"carousel-indicators\">";
        for ($g = 0; $g < countImagesMediaAssoc($i); $g++) {
            $active = ($g == 0) ? "active" : "";
            $html .= "<li data-target=\"#myCarousel$i\" data-slide-to=\"$i\" class=\"$active\"></li>";
        }
        $html .= "</ol>";

        $html .= "<div class=\"carousel-inner\">";
        //Wrapper for slides 
        for ($e = 0; $e < countImagesMediaAssoc($i); $e++) {
            $active = ($e == 0) ? "active" : "";
            $html .= "<div class=\"item $active\" align=\"center\">";

            if ($readMediasPost[$e]["typeMedia"] == "image/png" || $readMediasPost[$e]["typeMedia"] == "image/jpg" || $readMediasPost[$e]["typeMedia"] == "image/jpeg" || $readMediasPost[$e]["typeMedia"] == "image/gif" || $readMediasPost[$e]["typeMedia"] == "image/jpg"){
                $html .= "<img src=\"media/img/upload/" . $readMediasPost[$e]["nomMedia"] . "\" alt=\"" . $readMediasPost[$e]["nomMedia"] . "\">";
                $html .= "</div>";
            }

            if ($readMediasPost[$e]["typeMedia"] == "video/mp4" || $readMediasPost[$e]["typeMedia"] == "video/m4v") {
                $html .= "\n <video width=\"100%\" height=\"100%\" controls autoplay loop muted >";
                $html .= "\n <source src=\"media/img/upload/" . $readMediasPost[$e]["nomMedia"] . "\" type=\"video/mp4\">";
                $html .= "\n </video>";
                $html .= "\n </div>";
            }             

            if ($readMediasPost[$e]["typeMedia"] == "audio/mp3" || $readMediasPost[$e]["typeMedia"] == "audio/ogg" || $readMediasPost[$e]["typeMedia"] == "audio/mpeg") {
                $html .= "\n <audio controls>";
                $html .= "\n <source src=\"media/img/upload/" . $readMediasPost[$e]["nomMedia"] . "\">";
                $html .= "\n </audio>";
                $html .= "\n </div>";
            }
        }
        $html .= "</div>";


        // controleurs droite gauche 
        $html .= "<a class=\"left carousel-control\" href=\"#myCarousel$i\" data-slide=\"prev\">";
        $html .= "<span class=\"glyphicon glyphicon-chevron-left\"></span>";
        $html .= "<span class=\"sr-only\">Previous</span>";
        $html .= "</a>";
        $html .= "<a class=\"right carousel-control\" href=\"#myCarousel$i\" data-slide=\"next\">";
        $html .= "<span class=\"glyphicon glyphicon-chevron-right\"></span>";
        $html .= "<span class=\"sr-only\">Next</span>";
        $html .= "</a>";
        $html .= "</div>";

        $html .= "<div class=\"panel-body\">";
        $html .= "<p class=\"lead\">" . $readMediasPost[0]["commentaire"] . "</p>";
        $html .= "</div>";
        $html .= "</div>";
    }

    return $html;
}