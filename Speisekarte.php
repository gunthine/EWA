<?php
/**
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

require_once './Page.php';
require_once './SpeisekarteListe.php';

// class Speisekarte
class Speisekarte extends Page
{

    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }


    protected function __destruct()
    {
        parent::__destruct();
    }


    protected function getViewData()
    {
    }


    protected function generateView()
    {
        $this->getViewData();
        $this->generatePageHeader("Speisekarte");
        echo <<<EOT
        <div class="main">
EOT;
        // create list of menu
        $speisekarteListe = new SpeisekarteListe($this->_database);
        $speisekarteListe->generateView("speisekarte");
        echo <<<EOT
          <!--Warenkorb -->
          <div class="warenkorb">
            <h2>Warenkorb</h2>
            <textarea id="warenkorbTable"></textarea>
            <button onClick="emptyCard()">Warenkorb leeren</button>
            <p id="warenkorb-preis" data-price="0">Preis: 0€</p>
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


    protected function processReceivedData()
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
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


