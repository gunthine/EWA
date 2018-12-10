<?php	// UTF-8 marker äöüÄÖÜß€
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

class SpeisekarteListe
{
    // --- ATTRIBUTES ---
    protected $_database = null;
    protected $pizzaName = array();
    protected $pizzaPreis = array();
    protected $pizzaBild = array();

    // to do: declare reference variables for members
    // representing substructures/blocks

    // --- OPERATIONS ---

    /**
     * Gets the reference to the DB from the calling page template.
     * Stores the connection in member $_database.
     *
     * @param $database $database is the reference to the DB to be used
     *
     * @return none
     */
    public function __construct($database)
    {
        $this->_database = $database;
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is stored in an easily accessible way e.g. as associative array.
     *
     * @return none
     */
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

    /**
     * @param $id $id is the unique (!!) id to be used as id in the div-tag
     *
     * @return none
     */
    public function generateView($id = "")
    {
        $this->getViewData();
        if ($id) {
            $id = "class=\"$id\"";
        }
        echo "<div $id>\n";
        echo "<h2>Speisekarte</h2>\n";
        // generate HTML list
        echo "<ol>\n";
        $li_items = count($this->pizzaName);

        for($i = 0; $i < $li_items; $i++) {
          echo '<li id="' . $this->pizzaName[$i] . '" data-price="' . $this->pizzaPreis[$i] . '" onclick="addPizza(this.id)">';
          echo '<img src="' . $this->pizzaBild[$i] . '">';
          echo 'Pizza ' . $this->pizzaName[$i] . ' - ' . $this->pizzaPreis[$i] . '€';
        }
        echo '</ol>';
        echo "</div>\n";
    }

    /**
     * @return none
     */
    public function processReceivedData()
    {
        // to do: call processData() for all members
    }
}
