// Pizzen zum Wahrenkorb hinzufügen
function addPizza(id) {
    // add pizza
    var option = document.createElement("option");
    option.text = id;
    option.value = id;
    document.getElementById("shopping-cart").add(option);

    // update costs
    var totalCost = parseInt(document.getElementById("totalCost").dataset.totalcost);
    var pizzaCost = parseInt(document.getElementById(id).dataset.pizzacost);
    totalCost = totalCost + pizzaCost;
    document.getElementById("totalCost").dataset.totalcost = totalCost;
    document.getElementById("totalCost").innerHTML = "Preis: " + totalCost + "€";
}

function emptyCard() {
    document.getElementById("warenkorbTable").value="";
    document.getElementById("warenkorb-preis").dataset.price = 0;
    document.getElementById("warenkorb-preis").innerHTML = "Preis: 0€";
}

/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}