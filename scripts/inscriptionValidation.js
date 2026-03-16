function validationInscription(){
    let nom = document.getElementById('nom').value;
    let prenom = document.getElementById('prenom').value;
    let email = document.getElementById('email').value;
    let mdp = document.getElementById('mdp').value;
    let mdpConfirm = document.getElementById('mdpConfirm').value;
    let alias = document.getElementById('alias').value;
    let erreur = document.getElementById('erreur');
    erreur.textContent = "";

    if (alias === "" || alias.length < 2 || alias.length > 50){
        erreur.textContent = "Erreur dans l'alias";
        return false;
    }
    if (mdp === "" || mdp.length < 8 || mdp.length > 50 || mdpConfirm === "" || mdpConfirm.length < 8 || mdpConfirm.length > 50){
        erreur.textContent = "Erreur dans le mot de passe";
        return false;
    }
    if (mdp !== mdpConfirm){
        erreur.textContent = "Les mots de passes ne sont pas pareils"
        return false;
    }
    if (prenom === "" || prenom.length < 2 || prenom.length > 25){
        erreur.textContent = "Erreur dans le prenom";
        return false;
    }
    if (nom === "" || nom.length < 2 || nom.length > 25 ){
        erreur.textContent = "Erreur dans le nom de famille";
        return false;
    }
    if (email == "" || email.length < 6 || email.length > 254){
        erreur.textContent = "Erreur dans le e-mail";
        return false;
    }
    return true;
}