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
        $sql = "SELECT bilddatei, pizzaname, pizzaid, status FROM bestelltepizza NATURAL JOIN angebot WHERE status != 'i' AND status != 'z'";
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
        echo <<<HTML
		<h1>Bäcker</h1>\n
HTML;
        if ($this->available) {
        	echo '		<form class="baecker-wrapper" action="Bäcker.php" method="post" accept-charset="UTF-8">';
            $li_items = count($this->bilddatei);
            for ($i = 0; $i < $li_items; $i++) {
                echo<<<HTML

			<section id="{$this->pizzaid[$i]}" class="bestelltepizza">
			    <img src="{$this->bilddatei[$i]}" alt="{$this->pizzaname[$i]}" />
		        <div class="pizzadata">
		            <h3>{$this->pizzaname[$i]}, Bestellnummer: {$this->pizzaid[$i]}</h3>
		            <label>
		                <input type="radio" onclick="updateStatus(this.name, this.value)" name="{$this->pizzaid[$i]}" value="b"  
HTML;
                if ($this->status[$i] == 'b') {echo 'checked ';}
                echo<<<HTML
/>
            			bestellt
		            </label>
        			<label>
            			<input type="radio" onclick="updateStatus(this.name, this.value)" name="{$this->pizzaid[$i]}" value="o" 
HTML;
                if ($this->status[$i] == 'o') {echo 'checked';}
                echo<<<HTML
/>
            			im Ofen
        			</label>
        			<label>
            			<input type="radio" onclick="updateStatus(this.name, this.value)" name="{$this->pizzaid[$i]}" value="f" 
HTML;
                if ($this->status[$i] == 'f') {echo 'checked';}
                echo<<<HTML
/>
            			fertig
        			</label>
    			</div>
			</section>\n
HTML;
            }
            echo<<<HTML
		</form>\n
HTML;
        } else {
            echo<<<HTML
		<h2>Keine Pizzen bestellt...</h2>\n
HTML;

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