<?php

require_once './Page.php';


class signup extends Page {




protected function __construct()
{

    parent::__construct();

}

protected function __destruct()
{
    parent::__destruct();
}

  protected function registerDatabase(){
    $name = $_POST['fullname'];
    $name = $this->_database->real_escape_string($name);
    $adress = $_POST['adress'];
    $adress = $this->_database->real_escape_string($adress);
    $telefon = $_POST['telefon'];
    $telefon = $this->_database->real_escape_string($telefon);

    $heute = date("Y-m-d H:i:s");
//sql insert statement schreiben

$sqlBestellung = "INSERT INTO bestellung (ADRESSE, BESTELLZEITPUNKT, Name, Telefon) VALUES('$adress', '$heute', '$name', '$telefon')";
// INSERT INTO bestellung (BESTELLUNGID, ADRESSE, BESTELLZEITPUNKT, Name, Telefon) VALUES('1', 'baum', '12.12.12', 'alex', '1234');

 if (mysqli_query($this->_database, $sqlBestellung))
 {
   echo "Datenbank zugriff war Erfolgreich!";
   echo "Name: ".$name;
   echo "Haus Adresse: ".$adress;
   echo "Telefon Nummer:".$telefon;
   echo "Datum:".$heute;
//eine neue bestellung wurde aufgenommen, jetzt müssen wir ein eintrag in bestellte pizza machen
   header('location: kunde.php');


}
else echo "Datenbank zugriff ERROR";

//header("Location: Startseite.php");
}

protected function pizzaBestellung(){

}

public static function main()
{
    $signup = new signup();
    $signup->registerDatabase();
}
}

signup::main();
