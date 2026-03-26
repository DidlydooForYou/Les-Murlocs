function Form(){

    let option = document.getElementById("type").value;

    let arme = document.getElementById("formArme");
    let armure = document.getElementById("formArmure");
    let potion = document.getElementById("formPotion");
    let sort = document.getElementById("formSort");

    arme.style.display = "none";
    armure.style.display = "none";
    potion.style.display = "none";
    sort.style.display = "none";

    switch(option){
        case "arme":
          arme.style.display = "block";
          break;
        case "armure":
            armure.style.display = "block";
            break;
        case "potion":
            potion.style.display = "block";
            break;
        case "sort":
            sort.style.display = "block"; 
            break; 
    }
}