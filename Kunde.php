<?php
require_once './Page.php';

class Kunde extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    protected function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData()
    {

    }

    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader('Kunde');
        echo <<<EOT
<section>
    <h2>Kunde</h2>
    
</section>
EOT;
        $this->generatePageFooter();
    }


    public static function main()
    {
        try {
            $page = new Kunde();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Kunde::main();
