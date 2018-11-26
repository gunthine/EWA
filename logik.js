
//Pizzen zum Wahrenkorb hinzufügen
function addMargherita() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  var tempOrder = textareaObj.value + "Pizza Margherita - 4.3€ \n"; //tempOrder ist ein String
  textareaObj.value = tempOrder;
}

function addSalami() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  var tempOrder = textareaObj.value + "Pizza Salami - 4.8€ \n"; //tempOrder ist ein String
  textareaObj.value = tempOrder;
}

function addPeperoni() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  var tempOrder = textareaObj.value + "Pizza Peperoni - 4.8€ \n"; //tempOrder ist ein String
  textareaObj.value = tempOrder;
}

function addSpeziale() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  var tempOrder = textareaObj.value + "Pizza Speziale - 5.8€ \n"; //tempOrder ist ein String
  textareaObj.value = tempOrder;
}

function warenkorb_leeren() {
  "use strict";
  var textareaObj = document.getElementById("wahrenkorb"); //hier holen wir uns das Text Feld Objekt
  textareaObj.value = "";
}
