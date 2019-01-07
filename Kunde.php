<?php	// UTF-8 marker äöüÄÖÜß€
/**
 * Class PageTemplate for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 *
 * PHP Version 5
 *
 * @category File
 * @package  Pizzaservice
 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 * @license  http://www.h-da.de  none
 * @Release  1.2
 * @link     http://www.fbi.h-da.de
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Page.php';

/**
 * This is a template for top level classes, which represent
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class.
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking
 * during implementation.

 * @author   Bernhard Kreling, <b.kreling@fbi.h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 */
class Kunde extends Page
{
    protected $lastID;
    protected $lastAdresse;
    protected $lastName;
    protected $lastTelefon;
    protected $pizzaArray;
    protected $bestellungsStatus;

    // to do: declare reference variables for members
    // representing substructures/blocks

    /**
     * Instantiates members (to be defined above).
     * Calls the constructor of the parent i.e. page class.
     * So the database connection is established.
     *
     * @return none
     */
    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Cleans up what ever is needed.
     * Calls the destructor of the parent i.e. page class.
     * So the database connection is closed.
     *
     * @return none
     */
    protected function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
    protected function getViewData()
    {
        // to do: fetch data for this view from the database
        //ID von Bestellung aus der Datenkbank holen:
        //Prüfen ob eine Bestellung aufgeben wurde, erst dann das alles machen
        $sql = "SELECT * FROM bestellung";
        $result = mysqli_query($this->_database, $sql);
        if (mysqli_num_rows($result))
        {
        $sqlLastID = "SELECT (BESTELUNGID) FROM bestellung ORDER BY BESTELUNGID DESC LIMIT 1";
        $this->lastID = mysqli_query($this->_database, $sqlLastID);
        $row = mysqli_fetch_row($this->lastID);
        $this->lastID = $row[0];

        //Adresse von Bestellung aus der Datenbank holen
        $sqllastAdresse = "SELECT (ADRESSE) FROM bestellung ORDER BY BESTELUNGID DESC LIMIT 1";
        $this->lastAdresse = mysqli_query($this->_database, $sqllastAdresse);
        $row = mysqli_fetch_row($this->lastAdresse);
        $this->lastAdresse = $row[0];

        //Name von Bestellung aus der Datenbank holen
        $sqllastName = "SELECT (Name) FROM bestellung ORDER BY BESTELUNGID DESC LIMIT 1";
        $this->lastName = mysqli_query($this->_database, $sqllastName);
        $row = mysqli_fetch_row($this->lastName);
        $this->lastName = $row[0];

        //Telefonnummer aus der Datenbank holen
        $sqllastTelefon = "SELECT (Telefon) FROM bestellung ORDER BY BESTELUNGID DESC LIMIT 1";
        $this->lastTelefon = mysqli_query($this->_database, $sqllastTelefon);
        $row = mysqli_fetch_row($this->lastTelefon);
        $this->lastTelefon = $row[0];

        //hier erstellen wir für jede Pizza ein eintrag in die Datenkbank tabelle bestelltepizza
        //muss noch prüfen ob Pizzen im Array sind

        $this->pizzaArray = explode("|",$_COOKIE["pizza"]); //hier teilen wir den string in ein Array auf
        $max = sizeof($this->pizzaArray);

        for ($i = 0; $i < $max; $i++)
        {
          //jetzt erstellen wir für jede Pizza ein insert in die Datenbank
          $tempPizza = $this->pizzaArray[$i];
          $this->bestellungsStatus = "Wird bearbeitet";
          $sqlInsertBestelltePizza = "INSERT INTO bestelltepizza(BESTELUNGID, PIZZANAME, PIZZAID, SATUS) VALUES('$this->lastID', '$tempPizza', '$i', '$this->bestellungsStatus')";
          mysqli_query($this->_database, $sqlInsertBestelltePizza);
        }
      }

    }

    /**
     * First the necessary data is fetched and then the HTML is
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if avaialable- the content of
     * all views contained is generated.
     * Finally the footer is added.
     *
     * @return none
     */
    protected function generateView()
    {

        $this->getViewData();
        $this->generatePageHeader('to do: change headline');
        // to do: call generateView() for all members
        // to do: output view of this page
        if(isset($_COOKIE["pizza"]))
        {
          //echo "Cookie Existiert! <p></p>";

          $max = sizeof($this->pizzaArray);

          echo "<h2>Name: ".  $this->lastName.  "</h2>";
          echo "<h2>Adresse: ". $this->lastAdresse."</h2>";


          for ($i = 0; $i < $max; $i++ )
          {
            $anzahl = $i+1;
              echo "<h3>"."$anzahl: Pizza ".$this->pizzaArray[$i]."</h3>";
          }

          echo "<h2>Bestellungs Status: ". $this->bestellungsStatus ."</h2>";


        }


        else
        {
          echo "Bitte Bestellen Sie unter dem Menü Speisekarte!";
        }
        $this->generatePageFooter();
    }

    /**
     * Processes the data that comes via GET or POST i.e. CGI.
     * If this page is supposed to do something with submitted
     * data do it here.
     * If the page contains blocks, delegate processing of the
	 * respective subsets of data to them.
     *
     * @return none
     */
    protected function processReceivedData()
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
    }

    /**
     * This main-function has the only purpose to create an instance
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     *
     * @return none
     */
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

// This call is starting the creation of the page.
// That is input is processed and output is created.
Kunde::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >
