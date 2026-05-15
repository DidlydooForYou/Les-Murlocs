function ajouter_panierAJAX(idJoueur, idItem, idVente, fromRevente){
    $.ajax({
        url: 'scripts/ajax/ajax-panier-ajouter.php',
        type: 'POST',
        data: {
            idJoueur: idJoueur,
            idItem: idItem,
            idVente: idVente,
            fromRevente: fromRevente
        },
        success: function() {
            localRefresh(idItem || idVente);
        }
    });
}


// Changement de quantité
function changeItemQuantite(idJoueur, idItem, nouvelleQuantite){
    if(nouvelleQuantite <= 0){
        nouvelleQuantite = 1;
    }
    if(nouvelleQuantite >= 100){
        nouvelleQuantite = 99;
    }

    $.ajax({
        url: 'scripts/ajax/ajax-panier-quantite.php',
        type: 'POST',
        data: {
            idItem: idItem,
            idJoueur: idJoueur,
            qtItem: nouvelleQuantite
        },
        success: function(response) {
            localRefresh(idItem);
        },
        error: function(xhr, status, error) {
            console.log("Error :", error);
        }
    });
}

function addingItemQuantite(idJoueur, idItem, addition){

    let currentValue = document.getElementById('input_' + idItem).value;
    let nouvelleQuantite = parseInt(currentValue) + parseInt(addition);

    if(nouvelleQuantite > 0)
        changeItemQuantite(idJoueur, idItem, nouvelleQuantite);
    else {
        removeItem(idJoueur, idItem);
    } 
}

function removeItem(idJoueur, idItem){
    
    $.ajax({
        url: 'scripts/ajax/ajax-panier-effacer.php',
        type: 'POST',
        data: {
            idItem: idItem,
            idJoueur: idJoueur
        },
        success: function(response) {
            localRefresh(idItem);
        },
        error: function(xhr, status, error) {
            console.log("Error :", error);
        }
    });
}

function localRefresh(idItem){
    $.ajax({
        url: window.location.pathname.includes("revente.php") ? "revente.php" : "index.php",
        success: function(response) {
            let html = $("<div>").html(response);

            $('#card_' + idItem).html(html.find('#card_' + idItem).html());
        }
    });
}

/* Form dans la vitrine */
function updateSelectText() {
    const isMobile = window.matchMedia("(max-width: 800px)").matches;

    const priceSelect = document.getElementById("sortPrice");
    const categoSelect = document.getElementById("sortCatego");
    const alphaSelect = document.getElementById("sortAlphabete");

    if(isMobile){
        priceSelect.options[0].text = "Prix";
        categoSelect.options[0].text = "Categorie";
        alphaSelect.options[0].text = "A-Z";
    } else {
        priceSelect.options[0].text = "Trier par prix";
        categoSelect.options[0].text = "Trier par catégorie";
        alphaSelect.options[0].text = "Trier par ordre alphabétique";
    }
}

updateSelectText();

window.addEventListener("resize", updateSelectText);

document.getElementById("sortPrice").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortPrice", this.value);

    url.searchParams.delete("sortAlphabete");
    url.searchParams.delete("sortCatego");

    window.location.href = url.toString();
});

document.getElementById("sortAlphabete").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortAlphabete", this.value);

    url.searchParams.delete("sortPrice");
    url.searchParams.delete("sortCatego");

    window.location.href = url.toString();
});

document.getElementById("sortCatego").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortCatego", this.value);

    url.searchParams.delete("sortPrice");
    url.searchParams.delete("sortAlphabete");

    window.location.href = url.toString();
});