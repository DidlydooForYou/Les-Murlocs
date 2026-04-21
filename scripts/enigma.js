function afficherDifficulté(){
    let divButton = document.getElementById("questionArgent");
    let divMage = document.getElementById("questionMage");
        let divstat = document.getElementById("stats");

    if (divButton.style.display == "none"){
        divButton.style.display = "block";
        divMage.style.display = "none";
        divstat.style.display = "none";
    }
    else{
        divButton.style.display = "none";
    }

}
function afficherMage(){
    let divMage = document.getElementById("questionMage");
    let divButton = document.getElementById("questionArgent");
    let divstat = document.getElementById("stats");
    if (divMage.style.display == "none"){
        divMage.style.display = "block";
        divButton.style.display = "none";
        divstat.style.display = "none";

    }
    else{
        divMage.style.display = "none";
    }
    
}
function afficherStats(){
    let divstat = document.getElementById("stats");
    let divMage = document.getElementById("questionMage");
    let divButton = document.getElementById("questionArgent");
    if (divstat.style.display == "none"){
        divstat.style.display = "block";
        divMage.style.display = "none";
        divButton.style.display = "none";
    }
    else{
        divstat.style.display = "none";
    }
}
function submitEnigma(){
    const radios = document.getElementsByName("reponse");
    let validation = false;
    radios.forEach(radio => {
        if (radio.checked)  {
            validation = true;
        }
    });
    if (validation){
        return true;
    }
    else{
        return false;
    }

}
function submitEnigmaMagie(){
    const radios = document.getElementsByName("reponseMagie");
    let validation = false;
    radios.forEach(radio => {
        if (radio.checked)  {
            validation = true;
        }
    });
    if (validation){
        return true;
    }
    else{
        return false;
    }

}