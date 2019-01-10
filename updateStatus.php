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
        if ($this->_database->query($sql) === TRUE) {
            echo "New record created successfully ";
        } else {
            echo "Error: " . $sql . "<br>" . $this->_database->error;
        }
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