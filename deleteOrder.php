<?php

require_once './Page.php';


class deleteOrder extends Page {




protected function __construct()
{

    parent::__construct();

}

protected function __destruct()
{
    parent::__destruct();
}

protected function deleteData(){

    $id = $_POST['bestellid'];

    $sqldelteBestellung = "DELETE FROM bestellung WHERE BESTELUNGID = $id";
    $sqldeletePizza = "DELETE FROM bestelltepizza WHERE BESTELUNGID = $id";
    mysqli_query($this->_database, $sqldelteBestellung);
    mysqli_query($this->_database, $sqldeletePizza);

    if(isset($_COOKIE["pizza"]))
    {
      setcookie("pizza", "", time() - 3600);
    }

  header("Location: Fahrer.php");
}


public static function main()
{
    $deleteOrder = new deleteOrder();
    $deleteOrder->deleteData();
}
}

deleteOrder::main();
