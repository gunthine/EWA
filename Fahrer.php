<?php
require_once './Page.php';

class Fahrer extends Page
{
    protected $vorname = array();
    protected $nachname = array();
    protected $adresse = array();
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
        $sql = "SELECT bilddatei, pizzaname, pizzaid, vorname, nachname, adresse, status FROM angebot NATURAL JOIN bestelltepizza NATURAL JOIN bestellung WHERE status = 'f' OR status = 'i';";
        $result = $this->_database->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->vorname, $row["vorname"]);
                array_push($this->nachname, $row["nachname"]);
                array_push($this->adresse, $row["adresse"]);
                array_push($this->bilddatei, $row["bilddatei"]);
                array_push($this->pizzaname, $row["pizzaname"]);
                array_push($this->pizzaid, $row["pizzaid"]);
                array_push($this->status, $row["status"]);
            }
            $this->vorname = $this->escapeArray($this->vorname); 
            $this->nachname = $this->escapeArray($this->nachname);
            $this->adresse = $this->escapeArray($this->adresse);
            $this->available = true;
        } else {
            $this->available = false;
        }
    }

    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader("Fahrer");
        echo <<<HTML
		<h1>Fahrer</h1>\n
HTML;
        if ($this->available) {
        	echo '		<form class="baecker-wrapper" action="Fahrer.php" method="post" accept-charset="UTF-8">';
            $li_items = count($this->bilddatei);
            for ($i = 0; $i < $li_items; $i++) {
                echo<<<HTML

			<section class="bestelltepizza">
			    <img src="{$this->bilddatei[$i]}" alt="{$this->pizzaname[$i]}">
                <div class="adresse">
                    <h3>{$this->pizzaname[$i]}</h3>
                    <p>Name: {$this->vorname[$i]} {$this->nachname[$i]}<p>
                    <p>Adresse: {$this->adresse[$i]}</p>
                </div>
                <div class="labelgroup">
					<label>
						<input type="radio" name="{$this->pizzaid[$i]}" value="f" 
HTML;
                if ($this->status[$i] == 'f') {echo 'checked ';}
                echo<<<HTML
/>
                		fertig
            		</label>
            		<label>
                		<input type="radio" name="{$this->pizzaid[$i]}" value="i" 
HTML;
                if ($this->status[$i] == 'i') {echo 'checked ';}
                echo<<<HTML
/>
                		in Zustellung
            		</label>
            		<label>
                		<input type="radio" name="{$this->pizzaid[$i]}" value="z" />
                		zugestellt
		            </label>
        		    <p>Status: {$this->printStatus($this->status[$i])}</p>
        		</div>
			</section>\n
HTML;
            }
            echo<<<HTML
			<input type="submit" value="Aktualisieren" />
		</form>\n
HTML;
        } else {
            echo<<<HTML
		<h2>Keine Pizzen fertig...</h2>\n
HTML;

        }
        $this->generatePageFooter();
    }

    protected function processReceivedData()
    {
    	if (isset($_POST['']))
        foreach ($_POST as $key => $value) {
            $sql = "UPDATE bestelltepizza SET status = '$value' WHERE pizzaid = '$key'";
            if ($this->_database->query($sql) === TRUE) {
                echo "New record created successfully ";
            } else {
                echo "Error: " . $sql . "<br>" . $this->_database->error;
            }
        }
    }

    public static function main()
    {
        try {
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Fahrer::main();