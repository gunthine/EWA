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
class Baecker extends Page
{
    // to do: declare reference variables for members
    // representing substructures/blocks
    protected  $bestellungid = array();
    protected  $pizzaid = array();
    protected  $pizzaname = array();
    protected  $pizzastatus = array();
    protected $allePizzen = array();


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
        //hier holen wir alle bestellten Pizzen
        $sql = "SELECT * from bestelltepizza;";
        $result = mysqli_query($this->_database, $sql);
        $resultCheck = mysqli_num_rows($result);

        //Hier speichern wir die Bestellungs ID ab
        if ($resultCheck > 0)  {
          while ($row = mysqli_fetch_assoc($result)) {
              array_push($this->bestellungid, $row['BESTELUNGID']);
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





          //ich muss checken wann in der Datenbank eine neue Bestellung vorkommt
          //ich schreibe selects mit den ids von den Bestellungen
          //dann brauche ich nur ein Array mit allen ids
          //ein assoziatives array mit bestellungids und pizzaname
          //ich brauche nur ids den den pizzaname kann man ja auch mit der id dann holen



      $this->bestellungid = array_unique($this->bestellungid); //jetzt haben wir keine doppelten ids mehr
      //wir können für jede einzelne id unsere db durchsuchen und mithilfe von slect alle pizzen der bestellung rausfiltern
        
        foreach ($this->bestellungid as $value)
        {


        $sql = "SELECT (PIZZANAME) FROM bestelltepizza where BESTELUNGID = $value";
        $result = mysqli_query($this->_database, $sql);

        if (mysqli_num_rows($result) > 0) {

          echo "Bestellung Nummer: $value ";
          echo "<p> </p>";
          echo "Pizza: ";
        while($row = mysqli_fetch_assoc($result)) {
          echo $row["PIZZANAME"]."\n";
        }

        echo $value;



//ich will das je nach auswahl der radio button automatisch checked Wird
//also muss ich schuaen was die value ist



        echo <<<END
        <body>
        <form name="myForm" action="beackerform.php" method="POST">
          <input type="radio" name="status" value="In Bearbeitung" checked> In Bearbeitung<br>
          <input type="hidden" name ="bestellid" value=$value>
          <input type="radio" name="status" value="im Ofen" id="im Ofen" > Im Ofen<br>

          <input type="radio" name="status" value="Fertig" id="Fertig" > Fertig<br>

          <input type="submit" name="submit" onclick="setRadio()" class="btn btn-primary">
        </form>
        </body>
END;

          echo "<p> </p>";
        }

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
            $Baecker = new Baecker();
            $Baecker->processReceivedData();
            $Baecker->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page.
// That is input is processed and output is created.
Baecker::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >
