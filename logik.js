
//Pizzen zum Wahrenkorb hinzufügen
var myPizza ="";

function addPizza(clicked_id) {
  "use strict";
  var id;
  var currentObject = document.getElementById(clicked_id);
  id = currentObject.getAttribute("id");
  var preis = currentObject.getAttribute("data-price");
  var warenkorbObject = document.getElementById("wahrenkorb");
  warenkorbObject.value += "- " + clicked_id + " - " + preis + "€ \n";
  myPizza += id + "|";
}


function warenkorb_leeren() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  textareaObj.value = "";
}

function bestellen()
{
  var newStr = myPizza.substring(0, myPizza.length-1); //um den letzen strich zu löschen
  document.cookie = "pizza =" + newStr + ";" //string von pizzen getrennt mit "|"
}

//mit dieser funktion manipulieren wir den dom damit wir unsere radio buttons dynamisch dchecked setzen können
function setRadio()
{


  var x = document.forms["myForm"]["status"].value;

  if (x == "im Ofen")
  {
    document.getElementById("im Ofen").checked = true;
  }
  else if(x == "Fertig")
  {
    document.getElementById("Fertig").checked = true;
  }

  else {
        document.getElementById("In Bearbeitung").checked = true;
  }
}
