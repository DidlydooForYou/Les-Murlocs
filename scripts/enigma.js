function afficherDifficulté(){
    let divButton = document.getElementById("questionArgent");
    let divMage = document.getElementById("questionMage");

    if (divButton.style.display == "none"){
        divButton.style.display = "block";
        divMage.style.display = "none";
    }
    else{
        divButton.style.display = "none";
    }

}
function afficherMage(){
    let divMage = document.getElementById("questionMage");
    let divButton = document.getElementById("questionArgent");
    if (divMage.style.display == "none"){
        divMage.style.display = "block";
        divButton.style.display = "none";
    }
    else{
        divMage.style.display = "none";
    }
    
}