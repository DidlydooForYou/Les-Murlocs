function ajouter_panier(idItem){
    fetch("ajax-panier-ajouter.php", {
        method : "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "idItem=" + idItem
    })
    .then(res => res.text())
    .then(data => data === "oui" ?alert("Ajouté au panier !") : alert("Erreur dans l'ajout au panier"))
    .catch(err => console.log(err));
}

function ajouter_panierAJAX(idJoueur, idItem){
    $.ajax({
        url: 'ajax-panier-ajouter.php',
        type: 'POST',
        data: {
            idJoueur: idJoueur,
            idItem: idItem
        },
        success: function() {
            localRefresh(idItem);
        }
    })
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
        url: 'ajax-panier-quantite.php',
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

    changeItemQuantite(idJoueur, idItem, nouvelleQuantite);
}

function localRefresh(idItem){
    $.ajax({
        url: "index.php",
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