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

    let idTableau = "#Tableau_" + idItem;
    let idPanel = "#Panel_" + idItem;

    $.ajax({
        url: 'ajax-panier-quantite.php',
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

    changeItemQuantite(idJoueur, idItem, nouvelleQuantite);
}

function localRefresh(){
    $.ajax({
        url: "Panier.php",
        success: function(response) {
            let html = $("<div>").html(response);               // Copie la page html de la reponse dans un <div>
                
            $('#panier').html(html.find('#panier').html());     // Trouve les élements dans la copie et les applique à la page actuelle
            $('#confirmation-panel').html(html.find('#confirmation-panel').html());

            $('#panel-total').html(html.find('#panel-total').html());
            $('#tableau-total').html(html.find('#tableau-total').html());
        }
    });
}


// Enlever un item
function deleteItem(idJoueur, idItem){
    
    $.ajax({
        url: 'ajax-panier-effacer.php',
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
        url: 'ajax-panier-acheter.php',
        type: 'POST',
        data: {
            idJoueur: idJoueur,
            prixTotal: prixTotal
        },
        success: function(response) {
            alert(response);
            let data = JSON.parse(response);

            if(data.success){
                alert("Achat complété !");

                localRefresh();
            } else {
                alert("Erreur: Il vous manque " + data.error + " pieces");
            }
            
        },
        error: function(xhr, status, error) {
            console.log("error: L'achat des items à échoué (" + error + ")");
        }
    });
}