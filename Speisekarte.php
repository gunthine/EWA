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
        echo<<<EOT
        <div class="wrapper">
<section class="speisekarte">
    <h2>Speisekarte</h2>
    <ol>
EOT;

        $li_items = count($this->pizzaName);
        for($i = 0; $i < $li_items; $i++) {
            $id = $this->pizzaName[$i];
            $pizzaPreis = $this->pizzaPreis[$i];
            echo '<li>';
            echo '<img src="' . $this->pizzaBild[$i] . '" id="' . $id . '" onclick="addPizza(this.id)" data-pizzacost="' . $pizzaPreis . '">';
            echo '<button>Pizza ' . $id . ' - ' . $pizzaPreis . '€</button></li>';
        }

        echo<<<EOT
    </ol>
</section>

<section class="form">
    <form action="Speisekarte.php" method="post">
        <h2>Warenkorb</h2>
        <select id="shopping-cart" multiple name="pizza[]">
            <!-- shopping cart elements-->
        </select>
        <button>Warenkorb leeren</button>
        <button>Elemente entfernen</button>
        <p id="totalCost" data-totalcost="0">Preis: 0€</p>
        <h2>Ihre Adresse</h2>
        <input type="text" name="vorname" placeholder="Vorname"><br>
        <input type="text" name="nachname" placeholder="Nachname"><br>
        <input type="text" name="adresse" placeholder="Adresse"><br>
        <input type="submit" name="submit" value="Bestellen">
    </form>
</section>
</div>
EOT;
        $this->generatePageFooter();
    }


    protected function processReceivedData()
    {
        if (empty($_POST)) {
            return;
        }

        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $adresse = $_POST['adresse'];
        $date = date('Y-m-d H:i:s');
        $pizza = $_POST['pizza'];

        $sql = "INSERT INTO bestellung(vorname, nachname, adresse, bestellzeitpunkt) VALUES('$vorname', '$nachname', '$adresse', '$date')";
        if ($this->_database->query($sql) === TRUE) {
            echo "New record created successfully ";
        } else {
            echo "Error: " . $sql . "<br>" . $this->_database->error;
        }

        $bestellungid = $this->_database->insert_id;
        $li_items = count($pizza);
        for ($i = 0; $i < $li_items; $i++) {
            $sql = "INSERT INTO bestelltepizza(pizzaname, bestellungid, status) VALUES('$pizza[$i]', '$bestellungid', 'b')";
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
