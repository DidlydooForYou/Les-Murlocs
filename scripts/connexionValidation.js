function connexionValidation(){
    let courriel = document.getElementById('email').value;
    let mdp = document.getElementById('password').value;
    let erreur = document.getElementById('erreur');
    erreur.textContent = "";

    if (courriel === ""){
        erreur.textContent = "Courriel vide"
        return false;
    }
    if (mdp === ""){
        erreur.textContent = "Mot de passe vide"
        return false;
    }
    return true;
}