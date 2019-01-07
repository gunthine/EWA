<?php
require_once './Page.php';

class Kunde extends Page
{
    protected $vorname = array();
    protected $nachname = array();
    protected $adresse = array();
    protected $pizzaname = array();
    protected $bilddatei = array();
    protected $status = array();
    protected $available;

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
        $sql = "SELECT vorname, nachname, adresse, pizzaname, bilddatei, status FROM bestellung NATURAL JOIN bestelltepizza NATURAL JOIN angebot WHERE status != 'z'";
        $result = $this->_database->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->vorname, $row["vorname"]);
                array_push($this->nachname, $row["nachname"]);
                array_push($this->adresse, $row["adresse"]);
                array_push($this->pizzaname, $row["pizzaname"]);
                array_push($this->bilddatei, $row["bilddatei"]);
                array_push($this->status, $row["status"]);
            }
            $this->available = true;
        } else {
            $this->available = false;
        }
    }

    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader('Kunde');
        echo <<<EOT
<h2>Kunde</h2>
<section class="kunden-wrapper">\n
EOT;
    if ($this->available) {
        $li_items = count($this->vorname);
        for ($i = 0; $i < $li_items; $i++) {
            echo<<<EOT
<div class="bestelltepizza">
    <img src="{$this->bilddatei[$i]}">
    <div class="customerdata">
        <h3>{$this->pizzaname[$i]}</h3>
        <p>{$this->vorname[$i]} {$this->nachname[$i]}, {$this->adresse[$i]}</p>
        <p>Status: {$this->printStatus($this->status[$i])}</p>
    </div>
</div>\n
EOT;
        }
    } else {
        echo '<h1>Keine Pizzen bestellt...</h1>';
    }

    echo<<<EOT
</section>\n
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
