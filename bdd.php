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

function bddImage($typeFile, $nameFile)
{
  static $ps = null;
  $sql = "INSERT INTO `M152`.`media` (`typeMedia`, `nomMedia`) ";
  $sql .= "VALUES (:TYPE, :NAME)";
  if ($ps == null) {
    $ps = dbconnect()->prepare($sql);
  }
  $answer = false;
  try {
    $ps->bindParam(':TYPE', $typeFile, PDO::PARAM_STR);
    $ps->bindParam(':NAME', $nameFile, PDO::PARAM_STR);

    $answer = $ps->execute();

  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

?>