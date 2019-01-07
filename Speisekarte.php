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
class Speisekarte extends Page
{
    // to do: declare reference variables for members
    // representing substructures/blocks
  protected  $bilddatei = array();
  protected  $pizzaname = array();
  protected  $preis = array();




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
        $sql = "SELECT * from angebot;";
        $result = mysqli_query($this->_database, $sql);
        $resultCheck = mysqli_num_rows($result);


        if ($resultCheck > 0)  {
          while ($row = mysqli_fetch_assoc($result)) {
              array_push($this->bilddatei, $row['BILDDATEI']);
              array_push($this->pizzaname, $row['PIZZANAME']);
              array_push($this->preis,     $row['PREIS']);
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
        if(isset($_COOKIE["pizza"]))
        {
          setcookie("pizza", "", time() - 3600);
        }

        $this->getViewData();
        $this->generatePageHeader("Speisekarte");
        $counter = count($this->pizzaname);
        // to do: call generateView() for all members
        // to do: output view of this page

        // Speisekarte:
        echo '<div class="centerpos">';
        echo "<section>";
        echo "<h2>Speisekarte</h2>";
        echo '<ol class="Speisekarte">';

        for ($i = 0; $i < $counter; $i++)
        {
          echo '<li id ="'.$this->pizzaname[$i] . '"data-price="'.$this->preis[$i] .'" onclick="addPizza(this.id)">';
          echo '<img src="'.$this->bilddatei[$i].'" >';
          echo '</li>';
          echo '<label for="'.$this->pizzaname[$i].'" > '. $this->pizzaname[$i].' - '.$this->preis[$i]. '€ </label>';

        }

        //jetzt haben wir alle bestellten pizzen in einer globalen sesseion variable

        echo <<<EOT

        <!DOCTYPE HTML>
        <html>
        <div class="form-group">

          <label for="wahrenkorb">Warenkorb:</label>
          <textarea class="form-control" rows="5" id="wahrenkorb"></textarea>

          <button type="button" class="btn" id="warenkorb_leeren" onclick="warenkorb_leeren()">Warenkorb leeren</button>
        </div>

        <!-- Formular -->
        <section>
          <p>
          </p>
          <h2>Ihre Daten</h2>
          <form action="signup.php" method="post">
            <div class="form-group">
              <label for="Name">Name</label>
              <input type="text" name="fullname" class="form-control" id="Name" aria-describedby="emailHelp" placeholder="Vorname und Nachname eingeben">
            </div>
            <div class="form-group">
              <label for="Adresse">Adresse</label>
              <input type="text" name="adress" class="form-control" id="Adresse" placeholder="Adresse eingeben">
            </div>
            <div class="form-group">
              <label for="Telefonnummer">Telefon Nummer</label>
              <input type="text" name="telefon" class="form-control" id="Telefonnummer" placeholder="Telefon Nummer eingeben">
              <small id="emailHelp" class="form-text text-muted">Wir geben niemals Ihre Daten an Dritte weiter</small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary" onclick="bestellen()">Bestellung Abschicken</button>
          </form>

        </section>
          </div>

      <!--Bootstrap Form: -->



        </main>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


        </script>
      </body>

        </html>

EOT;

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

            $page = new Speisekarte();
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
Speisekarte::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >
