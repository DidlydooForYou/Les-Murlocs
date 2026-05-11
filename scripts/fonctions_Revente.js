function changeReventeQuantite(idJoueur, idItem, nouvelleQuantite){
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

function addingReventeQuantite(idJoueur, idItem, addition){

    let input = document.getElementById("InputQte" + idItem);
    let currentValue = parseInt(input.value) || 0;

    let nouvelleQuantite = currentValue + parseInt(addition);

    if(nouvelleQuantite < 1) nouvelleQuantite = 1;
    if(nouvelleQuantite > 99) nouvelleQuantite = 99;

    input.value = nouvelleQuantite;

    changeReventeQuantite(idJoueur, idItem, nouvelleQuantite);
}

function localRefresh(callback){
    $.ajax({
        url: "revente.php",
        success: function(response) {
            let html = $("<div>").html(response);               // Copie la page html de la reponse dans un <div>
            
            if(html.find('#aucunItem').length > 0){
                $('#main').html(html.find('#main').html());
            } else {
                $('#allItemsContainer').html(html.find('#allItemsContainer').html());     // Trouve les élements dans la copie et les applique à la page actuelle
            }

            if(callback) callback();
        }
    });
}