function openPanel(){
    let panel = document.getElementById("confirmation-panel");

    panel.style.display = "flex";
}

function closePanel(){
    let panel = document.getElementById("confirmation-panel");

    panel.style.display = "none";
}

function changeItemQuantite(idJoueur, idItem, nouvelleQuantite, nomItem){
    if(nouvelleQuantite <= 0){
        return
    }
    document.getElementById(nomItem + "PanierQte").value = nouvelleQuantite;
    document.getElementById(nomItem + "OverviewQte").textContent = nouvelleQuantite;

    $.ajax({
        url: 'ajax-panier-quantite.php',
        type: 'POST',
        data: {
            idItem: idItem,
            idJoueur: idJoueur,
            qtItem: nouvelleQuantite
        },
        success: function(response) {
            console.log("Success :", response);
        },
        error: function(xhr, status, error) {
            console.log("Error :", error);
        }
    });
}

function addingItemQuantite(idJoueur, idItem, addition, nomItem){
    let currentValue = document.getElementById(nomItem + "PanierQte").value

    let nouvelleQuantite = parseInt(currentValue) + parseInt(addition);

    changeItemQuantite(idJoueur, idItem, nouvelleQuantite, nomItem);
}