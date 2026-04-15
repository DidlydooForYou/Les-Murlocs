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