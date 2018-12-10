//Pizzen zum Wahrenkorb hinzufügen
function addPizza(id) {
    var preis = document.getElementById(id).dataset.price;
    document.getElementById("warenkorbTable").value += "1x " + id + " - " + preis + "€ \n";
    var p = parseFloat(document.getElementById("warenkorb-preis").dataset.price) + parseFloat(preis);
    document.getElementById("warenkorb-preis").dataset.price = p;
    document.getElementById("warenkorb-preis").innerHTML = "Preis: " + p + "€";
}

function emptyCard() {
    document.getElementById("warenkorbTable").value="";
    document.getElementById("warenkorb-preis").dataset.price = 0;
    document.getElementById("warenkorb-preis").innerHTML = "Preis: 0€";
}

