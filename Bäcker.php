<?php
require_once './Page.php';

class Baecker extends Page
{
    protected $bilddatei = array();
    protected $pizzaname = array();
    protected $pizzaid = array();
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
        $sql = "SELECT bilddatei, pizzaname, pizzaid, status FROM bestelltepizza NATURAL JOIN angebot WHERE status != 'f' OR status != 'z';";
        $result = $this->_database->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->bilddatei, $row["bilddatei"]);
                array_push($this->pizzaname, $row["pizzaname"]);
                array_push($this->pizzaid, $row["pizzaid"]);
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
        $this->generatePageHeader('Baecker');
        echo <<<EOT
<h2>Bäcker</h2>
<form class="baecker-wrapper">
EOT;
        if ($this->available) {
            $li_items = count($this->bilddatei);
            for ($i = 0; $i < $li_items; $i++) {
                echo<<<EOT
<div class="bestelltepizza">
    <img src="{$this->bilddatei[$i]}">
        <div class="pizzadata">
            <h3>{$this->pizzaname[$i]}, id: {$this->pizzaid[$i]}</h3>
            <label>
                <input type="radio" name="{$this->pizzaid[$i]}" value="b">
                bestellt
            </label>
            <label>
                <input type="radio" name="{$this->pizzaid[$i]}" value="o">
                im Ofen
            </label>
            <label>
                <input type="radio" name="{$this->pizzaid[$i]}" value="f">
                fertig
            </label>
            <p>Status: {$this->printStatus($this->status[$i])}</p>
        </div>
</div>\n
EOT;
            }
            echo<<<EOT
<input type="submit" value="Aktualisieren">
</form>
EOT;
        } else {
            echo<<<EOT
<h1>Keine Pizzen bestellt...</h1>
EOT;

        }
        $this->generatePageFooter();
    }

    protected function processReceivedData()
    {

    }

    public static function main()
    {
        try {
            $page = new Baecker();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Baecker::main();