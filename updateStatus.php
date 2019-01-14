<?php
require_once './Page.php';

class updateStatus extends Page
{

    protected function __construct()
    {
        parent::__construct();
    }

    protected function __destruct()
    {
        parent::__destruct();
    }

    protected function processReceivedData()
    {
        $id = $_GET["id"];
        $status = $_GET["status"];   
        $sql = "UPDATE bestelltepizza SET status = '$status' WHERE pizzaid = '$id'";
        $this->_database->query($sql);
        
        $sql = "SELECT status FROM bestelltepizza WHERE pizzaid = '$id'";
        $recordset = $this->_database->query($sql);
        $statusArray = array(); 
        while ($record = $recordset->fetch_assoc()) {
            $statusArray[] = htmlspecialchars($record["status"]);
        }
        $json_data = json_encode($statusArray);
        header("Content-type: application/json; charset=UTF-8");
        echo $json_data;

    }

    public static function main()
    {
        try {
            $page = new updateStatus();
            $page->processReceivedData();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

updateStatus::main();