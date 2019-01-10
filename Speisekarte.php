<?php
require_once './Page.php';

class Speisekarte extends Page
{
    protected $pizzaName = array();
    protected $pizzaPreis = array();
    protected $pizzaBild = array();

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
        $sql = "SELECT pizzaname, preis, bilddatei FROM angebot";
        $result = $this->_database->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->pizzaName, $row["pizzaname"]);
                array_push($this->pizzaPreis, $row["preis"]);
                array_push($this->pizzaBild, $row["bilddatei"]);
            }
        } else {
            echo "0 results";
        }
    }

    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader("Speisekarte");
        echo<<<HTML
		<div class="wrapper">
			<section class="speisekarte">
				<h1>Speisekarte</h1>
				<ul>\n
HTML;

        $li_items = count($this->pizzaName);
        for($i = 0; $i < $li_items; $i++) {
            $id = $this->pizzaName[$i];
            $pizzaPreis = $this->pizzaPreis[$i];
            echo <<<HTML
					<li>
						<img src="{$this->pizzaBild[$i]}" id="img{$id}" class="{$id}" alt="" onclick="addPizza(this.id)" data-pizzacost="{$pizzaPreis}" />
						<button id="btn{$id}" class="{$id}" data-pizzacost="{$pizzaPreis}" onclick="addPizza(this.id)">Pizza {$id} - {$pizzaPreis} €</button>
					</li>\n
HTML;
        }

        echo<<<HTML
				</ul>
			</section>

			<section class="form">
				<form action="Speisekarte.php" method="post">
					<h2>Warenkorb</h2>
					<select id="shopping-cart" multiple name="pizza[]">
		    			<!-- shopping cart elements-->
					</select>
					<button type="button" class="redBtn" onclick="emptyCard()">Warenkorb leeren</button>
					<button type="button" class="redBtn" onclick="removeSelected()">Elemente entfernen</button>
					<p id="totalCost" data-totalcost="0">Preis: 0.00€</p>

			        <input type="text" name="vorname" placeholder="Vorname" maxlength="20" required><br>
			        <input type="text" name="nachname" placeholder="Nachname" maxlength="20" required><br>
			        <input type="text" name="adresse" placeholder="Adresse" maxlength="60" required><br>
			        <input type="submit" name="submit" value="Bestellen" onclick="selectAll()">
			        <input type="reset" class="redBtn">
				</form>
			</section>
		</div>\n
HTML;
        $this->generatePageFooter();
    }


    protected function processReceivedData()
    {
    	if (empty($_POST)) {
    		return;
    	}

        $vorname = $this->_database->real_escape_string($_POST['vorname']);
        $nachname = $this->_database->real_escape_string($_POST['nachname']);
        $adresse = $this->_database->real_escape_string($_POST['adresse']);
        $date = date('Y-m-d H:i:s');
        $pizza = $_POST['pizza'];

        // add bestellung
        $sql = "INSERT INTO bestellung(vorname, nachname, adresse, bestellzeitpunkt) VALUES('$vorname', '$nachname', '$adresse', '$date')";
        $this->_database->query($sql);

        //add bestelltepizza
        $bestellungid = $this->_database->insert_id;
        $li_items = count($pizza);
        for ($i = 0; $i < $li_items; $i++) {
            $sql = "INSERT INTO bestelltepizza(pizzaname, bestellungid, status) VALUES('$pizza[$i]', '$bestellungid', 'b')";
           	$this->_database->query($sql);
        }
    }


    public static function main()
    {
        try {
            $page = new Speisekarte();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Speisekarte::main();
