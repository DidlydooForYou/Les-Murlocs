function afficherDifficulté(){
    let divButton = document.getElementById("divButton");

    if (divButton.style.display == "none"){
        divButton.style.display = "block";
    }
    else{
        divButton.style.display = "none";
    }

}
function afficherMage(){
    let divMage = document.getElementById("questionMage");

    if (divMage.style.display == "none"){
        divMage.style.display = "block";
    }
    else{
        divMage.style.display = "none";
    }
    
}