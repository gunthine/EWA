<?php

require_once './Page.php';


class formBeacker extends Page {




protected function __construct()
{
    parent::__construct();

}

protected function __destruct()
{
    parent::__destruct();
}

  protected function changeStatus(){
    $currentId = $_POST["bestellid"];
    $currentStatus = $_POST['status'];
    echo $currentStatus;
    echo $currentId;



  $sqlBestellung = "UPDATE bestelltepizza SET SATUS = '$currentStatus' WHERE BESTELUNGID = '$currentId'";
 if (mysqli_query($this->_database, $sqlBestellung))
{
   echo "Datenbank zugriff war Erfolgreich!";
   header('location: Baecker.php');
 }

 else echo "Datenbank zugriff ERROR";


//header("Location: Startseite.php");
}



public static function main()
{
    $formBeacker = new formBeacker();
    $formBeacker->changeStatus();
}
}

formBeacker::main();
