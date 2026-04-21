function ajouter_panierAJAX(idJoueur, idItem){
    $.ajax({
        url: 'scripts/ajax/ajax-panier-ajouter.php',
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

    console.log('Adding ' + currentValue + ' to ' + addition);

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
    console.log("localRefresh");

    

    $.ajax({
        url: "details.php?id="+idItem,
        success: function(response) {
            console.log('refresh success');

            let html = $("<div>").html(response);

            $('#purchase-box').html(html.find('#purchase-box').html());
        }
    });
}
