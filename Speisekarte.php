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
        $this->generatePageHeader("Speisekarte");
        echo <<<EOT
        <div class="main">
          <div class="speisekarte">
            <h2>Speisekarte</h2>
            <ol>
              <li id="margherita" data-price="4.30" data-name="Pizza Margherita">
                <img src="http://www.eccopizzaepasta.com/images/pizza_new_ok.png?crc=4173385462">
                <label for="margherita">Pizza Magherita - 4,30€</label>
              </li>
              <li id="salami" data-price="4.80" data-name="Pizza Salami">
                <img src="https://d1d8i24om29pt.cloudfront.net/static/desktop/products/pizza-salami.png">
                <label for="salami">Pizza Salami - 4,80€</label>
              </li>
              <li id="peperoni" data-price="4.80" data-name="Pizza Peperoni">
                <img src="https://dlct0dt1hx57m.cloudfront.net/static/desktop/products/pizza-diabolo.png">
                <label for="peperoni">Pizza Peperoni - 4,80€</label>
              </li>
              <li id="speziale" data-price="5.80" data-name="Pizza Speziale">
                <img src="https://d1d8i24om29pt.cloudfront.net/static/desktop/products/pizza-spezial.png">
                <label for="speziale">Pizza Speziale - 5,80€</label>
              </li>
            </ol>
          </div>
          <!--Warenkorb -->
          <div class="warenkorb">
            <h2>Warenkorb</h2>
            <textarea name="warenkorb"></textarea> <br>
            <button id="emptyCart">Warenkorb leeren</button>
            <p>Preis: 13,40€</p>
          </div>
          <!-- Formular -->
          <section class="form">
              <h2>Ihre Daten</h2>
            <form action="index.html" method="post">
              <input type="text" name="vorname" placeholder="Vorname"> <br>
              <input type="text" name="nachname" placeholder="Nachname"> <br>
              <input type="text" name="adresse" placeholder="Adresse"><br>
              <input type="text" name="ort" placeholder="Ort"><br>
              <input type="text" name="plz" placeholder="PLZ"><br>
              <input type="submit" name="submit" value="Bestellen">
            </form>
          </section>


        </div>
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
