<?php
abstract class Page
{
    protected $_database = null;

    protected function __construct()
    {
        $this->_database = new MySQLi("127.0.0.1:3306", "nima", "6462", "pizza");
        if ($this->_database->connect_error) {
            die("Connection failed: " . $this->_database->connect_error);
        }


    }
    
    protected function __destruct()
    {
        $this->_database->close();
    }


    protected function generatePageHeader($headline = "")
    {
        $headline = htmlspecialchars($headline);
        header("Content-type: text/html; charset=UTF-8");
        echo <<<EOT
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="css/master.css"/>
        <link rel="stylesheet" href="css/$headline.css"/>
        <script src="js/javascript.js"></script>
        <title>$headline</title>
    </head>
    <body>
        <nav class="topnav" id="myTopnav">
            <a href="index.php">Startseite</a>
            <a href="Speisekarte.php">Speisekarte</a>
            <a href="Kunde.php">Kunde</a>
            <a href="Bäcker.php">Bäcker</a>
            <a href="Fahrer.php">Fahrer</a>
            <a style="float:right" href="Impressum.php">Impressum</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
        </nav>\n
EOT;
}


    protected function generatePageFooter()
    {
        echo<<<EOT
    </body>
</html>
EOT;
    }

    protected function processReceivedData()
    {
        if (get_magic_quotes_gpc()) {
            throw new Exception
                ("Bitte schalten Sie magic_quotes_gpc in php.ini aus!");
        }
    }

    protected function printStatus($char) {
        switch ($char) {
            case 'b': return 'bestellt';
            case 'o': return 'im Ofen';
            case 'f': return 'fertig';
            case 'i': return 'in Zustellung';
            case 'z': return 'zugestellt';
        }
        return $char;
    }
}