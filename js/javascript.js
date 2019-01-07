// Pizzen zum Wahrenkorb hinzufügen
function addPizza(id) {
    // add pizza
    var pizzaName = document.getElementById(id).name;
    var option = document.createElement("option");
    option.text = pizzaName;
    option.value = pizzaName;
    document.getElementById("shopping-cart").add(option);

    // update costs
    var totalCost = parseInt(document.getElementById("totalCost").dataset.totalcost);
    var pizzaCost = parseInt(document.getElementById(id).dataset.pizzacost);
    totalCost = totalCost + pizzaCost;
    document.getElementById("totalCost").dataset.totalcost = totalCost;
    document.getElementById("totalCost").innerHTML = "Preis: " + totalCost + "€";
}

function selectAll() {
    var selectBox = document.getElementById("shopping-cart");
    for (var i = 0; i < selectBox.options.length; i++)
    {
        selectBox.options[i].selected = true;
    }
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


