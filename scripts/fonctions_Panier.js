function openPanel(){
    let panel = document.getElementById("confirmation-panel");

    panel.style.display = "flex";
}

function closePanel(){
    let panel = document.getElementById("confirmation-panel");

    panel.style.display = "none";
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
            localRefresh();
        },
        error: function(xhr, status, error) {
            console.log("Error :", error);
        }
    });
}

function addingItemQuantite(idJoueur, idItem, addition){

    let currentValue = document.getElementById("InputQte" + idItem).value
    let nouvelleQuantite = parseInt(currentValue) + parseInt(addition);

    if(nouvelleQuantite > 0)
        changeItemQuantite(idJoueur, idItem, nouvelleQuantite);
    else {
        deleteItem(idJoueur, idItem);
    } 
}

function localRefresh(callback){
    $.ajax({
        url: "panier.php",
        success: function(response) {
            let html = $("<div>").html(response);               // Copie la page html de la reponse dans un <div>
            
            if(html.find('#aucunItem').length > 0){
                $('#main').html(html.find('#main').html());
            } else {
                $('#panier').html(html.find('#panier').html());     // Trouve les élements dans la copie et les applique à la page actuelle
                $('#confirmation-panel').html(html.find('#confirmation-panel').html());

                $('#panel-total').html(html.find('#panel-total').html());
                $('#tableau-total').html(html.find('#tableau-total').html());
            }

            if(callback) callback();
        }
    });
}


// Enlever un item
function deleteItem(idJoueur, idItem){
    
    console.log('deleteItem function reached');

    $.ajax({
        url: 'scripts/ajax/ajax-panier-effacer.php',
        type: 'POST',
        data: {
            idItem: idItem,
            idJoueur: idJoueur
        },
        success: function(response) {
            localRefresh();
        },
        error: function(xhr, status, error) {
            console.log("Error :", error);
        }
    });
}

// Acheter le panier
function acheterPanier(idJoueur, prixTotal){
    $.ajax({
        url: 'scripts/ajax/ajax-panier-acheter.php',
        type: 'POST',
        data: {
            idJoueur: idJoueur,
            prixTotal: prixTotal
        },
        success: function(response) {
            let data = JSON.parse(response);

            localRefresh(function() {
                afficherResultat(data.success, data.error);
            });
        },
        error: function(xhr, status, error) {
            console.log("error: L'achat des items à échoué (" + error + ")");
        }
    });
}

function afficherResultat(success, error){
    document.getElementById("result-fieldset").style.display = "block";
    let legend = document.getElementById("result-legend");
    let description = document.getElementById("result-desc");

    if(success){
        legend.classList.add('success');
        description.classList.add('success');

        legend.textContent = "Confirmation";
        description.textContent = "Achat complété !";
    } else {
        legend.classList.add('error');
        description.classList.add('error');

        legend.textContent = "Erreur";
        description.textContent = error;

        closePanel();
    }
}