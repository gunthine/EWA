// Pizzen zum Warenkorb hinzufügen
function addPizza(id) {
"use strict";
    var button = document.getElementById(id);
    var totalCostDom = document.getElementById("totalCost");
    // add pizza
    var option = document.createElement("option");
    option.text = button.className;
    option.value = button.className;
    document.getElementById("shopping-cart").add(option);

    // update costs
    var totalCost = parseFloat(totalCostDom.dataset.totalcost);
    var pizzaCost = parseFloat(button.dataset.pizzacost);
    totalCost = totalCost + pizzaCost;
    totalCostDom.dataset.totalcost = totalCost;
    totalCostDom.innerHTML = "Preis: " + totalCost.toFixed(2) + "€";
}

function selectAll() {
"use strict";
    var selectBox = document.getElementById("shopping-cart");
    var i;
    for (i = 0; i < selectBox.options.length; i++) {
        selectBox.options[i].selected = true;
    }
}

function emptyCard() {
"use strict";
    var selectBox = document.getElementById("shopping-cart");
    var length = selectBox.options.length;
    var i;
    for (i = 0; i < length; i++) {
        selectBox.remove(0);
    }
    // update costs
    document.getElementById("totalCost").dataset.totalcost = 0;
    document.getElementById("totalCost").innerHTML = "Preis: 0.00€";
}

function removeSelected() {
"use strict";
    var selectBox = document.getElementById("shopping-cart");
    var i;
    for (i = 0; i < selectBox.options.length; i++) {
        var currentOption = selectBox.options[i];
        if (selectBox.options[i].selected) {
            // update costs
            var totalCostDom = document.getElementById("totalCost");
            var totalCost = parseFloat(totalCostDom.dataset.totalcost);
            var button = document.getElementById("btn"+currentOption.text)
            var pizzaCost = parseFloat(button.dataset.pizzacost);
            totalCost = totalCost - pizzaCost;
            totalCostDom.dataset.totalcost = totalCost;
            totalCostDom.innerHTML = "Preis: " + totalCost.toFixed(2) + "€";
            // remove option
            selectBox.remove(i);
            i--;
        }
    }
}


/* Toggle between adding and removing the "responsive" classto topnav
when the user clicks on the icon */
function myFunction() {
"use strict";
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function updateStatus(id, value) {
    "use strict";
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", "updateStatus.php?id=" + id + "&status=" + value, true);
    xmlHttp.responseType = 'json';
    xmlHttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
    		for (var i = 0; i < this.response.length; i++) {
    			changeStatusText(id, this.response[i]);
    		}
    	}
    }
    xmlHttp.send();
}

function changeStatusText(id, text) {
    var status = statusToText(text);
	document.getElementById(id).innerHTML = "Status: " + status;
}

function statusToText(status) {
    switch (status) {
        case 'b': return 'bestellt';
        case 'o': return 'im Ofen';
        case 'f': return 'fertig';
        case 'i': return 'in Zustellung';
        case 'z': return 'zugestellt';
    }
    return status;
}