
var compteur = 0;
var compteurstep = 0;

/**
 * 
 */
function createFormStep() {

    var compteurstep = $('#main_step > *').length + 1;

    //Formulaire pour une étape
    var divStep = document.createElement("div");
    divStep.id = "divStep_" + compteurstep;
    divStep.name = "divstep";
    var labelStep = document.createElement("label");
    labelStep.id = "labelStep_" + compteurstep;
    labelStep.name = "labelStep";
    labelStep.innerText = compteurstep;
    var inputStep = document.createElement("textArea");
    inputStep.cols = 60;
    inputStep.rows = 3;
    inputStep.name = "step";
    var btnDel = document.createElement("button");
    btnDel.innerText = "Supprimer la ligne";
    btnDel.type = "button";
    btnDel.id = compteurstep;
    btnDel.name = "btnDel";
    btnDel.addEventListener('click', function () { delFormStep(btnDel.id) });

    var step = document.getElementById("main_step");
    step.appendChild(divStep);
    divStep.appendChild(labelStep);
    divStep.appendChild(inputStep);
    divStep.appendChild(btnDel);
}

//Formulaire pour une étape
var divStep = document.createElement("div");
divStep.id = "divStep_" + 1;
var labelStep = document.createElement("label");
labelStep.id = "labelStep_" + 1;
labelStep.name = "labelStep";
labelStep.innerText = 1;
var inputStep = document.createElement("textArea");
inputStep.cols = 60;
inputStep.rows = 3;
inputStep.name = "step";
var btnDel = document.createElement("button");
btnDel.innerText = "Supprimer la ligne";
btnDel.type = "button";
btnDel.id = compteurstep;
btnDel.name = "btnDel";
btnDel.addEventListener('click', function () { delFormStep(btnDel.id) });

var step = document.getElementById("main_step");
step.appendChild(divStep);
divStep.appendChild(labelStep);
divStep.appendChild(inputStep);
divStep.appendChild(btnDel);

/**
 * 
 */
function creatFormIngredient() {

    var divIngredient = document.createElement("div");
    divIngredient.id = "divIngredient_" + compteur;

    //Formulaire pour un ingrédient
    var labelQuantity = document.createElement("label");
    labelQuantity.innerText = "Quantité";
    var inputQuantity = document.createElement("input");
    inputQuantity.name = "quantity";
    inputQuantity.type = "text";

    var labelUnit = document.createElement("label");
    labelUnit.innerText = "Unitée de mesure";
    var inputUnit = document.createElement("select");
    inputUnit.name = "unit";
    inputUnit.innerHTML = ' <option value="">(Rien)</option>' + '<option value="grammes">grammes (g)</option>' + '<option value="kilogrammes">kilogrammes (kg)</option>' + '<option value="litres">litres (l)</option>' + '<option value="millilitres">millilitres (ml)</option>' + '<option value="centilitres">centilitres (cl)</option>' + '<option value="c. à café">c. à café</option>' + '<option value="c. à soupe">c. à soupe</option>' + '<option value="c. à thé">c. à thé</option>';
    var labelIngredient = document.createElement("label");
    labelIngredient.innerText = "Ingredients :";
    var inputIngredient = document.createElement("input");
    inputIngredient.name = "Ingredient";
    inputIngredient.type = "text";

    var btnDel = document.createElement("button");
    btnDel.innerText = "Supprimer la ligne";
    btnDel.type = "button";

    btnDel.id = compteur;
    btnDel.addEventListener('click', function () { delFormIngredient(btnDel.id) });

    var ingredient = document.getElementById("main_ingredient");

    ingredient.appendChild(divIngredient);
    divIngredient.appendChild(labelQuantity);
    divIngredient.appendChild(inputQuantity);
    divIngredient.appendChild(labelUnit);
    divIngredient.appendChild(inputUnit);
    divIngredient.appendChild(labelIngredient);
    divIngredient.appendChild(inputIngredient);
    divIngredient.appendChild(btnDel);
    compteur = compteur + 1;
}

/**
 * Fonction qui supprime une ligne d'ingrédient
 * @param {*} nb 
 */
function delFormIngredient(nb) {
    document.getElementById("divIngredient_" + nb).remove();
}
function delFormStep(nb) {

    document.getElementById("divStep_" + nb).remove();

    var tabLength = $('#main_step > *').length;

    for (let index = 1; index <= tabLength; index++) {
        document.getElementById("main_step").childNodes[index].childNodes[0].id = "labelStep_" + index;
        document.getElementById("main_step").childNodes[index].childNodes[0].innerText = index;
        document.getElementById("main_step").childNodes[index].childNodes[2].id = index;
        document.getElementById("main_step").childNodes[index].id = "divStep_" + index;
    }
}

creatFormIngredient();
creatFormIngredient();

document.getElementById("addIngredient").addEventListener('click', function () { creatFormIngredient() });
document.getElementById("btnValider").addEventListener('click', function () { recordAll() });
document.getElementById("addStep").addEventListener('click', function () { createFormStep() });


/**
 * Fonction qui enregistre une recette
 */
function recordAll() {

    //Récupération du nom de la recette
    var recipe = document.getElementsByName("recipeName")[0].value;
    //Récupération du nombre de personnes
    var personNum = parseInt(document.getElementsByName("personNum")[0].value);
    //Récupération de l'ID de l'utilisateur connecté
    var id = parseInt(document.getElementById("idUser").innerHTML);
    //Création de la recette dans la base de données
    var data = recordRecipe(recipe, personNum, id);

    //Récupérer l'ID de la recette créée
    var id_Recipe = data.id;

    //Récupération de l'id de la catégorie
    var categorie = document.getElementById("category_list");
    var valeur = categorie.value;
    
    
    //Récupération du nombre d'éléments ingrédients
    var tabLength = $('#main_ingredient > *').length;

    for (let index = 0; index < tabLength; index++) {
        let qte = parseFloat(document.getElementsByName("quantity")[index].value);
        let unit = document.getElementsByName("unit")[index].value;
        let ingredient = document.getElementsByName("Ingredient")[index].value;
        recordElement(qte, unit, ingredient, id_Recipe);
    }

    //Récupération du nombre d'étapes

    var tabStepLength = $('#main_step > *').length;
    for (let index = 1; index <= tabStepLength; index++) {
        let stept = document.getElementById("main_step").childNodes[index].childNodes[1];
        let steptext = stept.value;
        recordStep((index), steptext, id_Recipe);
    }
}

/**
 * Fonction qui enregistre une recette dan sla base de données via l'API
 * @param {*} recipe 
 * @param {*} personNum 
 * @param {*} id 
 */
function recordRecipe(recipe, personNum, id) {
    var dateJour = new Date();
    var dataRetour;
    $.ajax({
        type: "POST",
        url: "https://localhost:8000/api/recipes",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            "recipeName": recipe,
            "personNum": personNum,
            "recipeIsValid": false,
            "recipeCreatedAt": dateJour,
            "recipeRate": 0,
            "user": "/api/users/" + id
        }),
        async: false,
        success: function (data) {
            alert("Recette Ajoutée ");
            dataRetour = data;
        }
    });
    return dataRetour;
}

/**
 * Fonction qui enregistre un élément dans la base de données
 */
function recordElement(qte, unit, element, id_Recipe) {
    $.ajax({
        type: "POST",
        url: "https://localhost:8000/api/elements",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            "unit": unit,
            "quantity": qte,
            "ingredient": element,
            "recipe": "/api/recipes/" + id_Recipe
        }),
        async: false,
        success: function (data) {
            alert("Elément Ajouté :" + element);
        }
    });
}

/**
 * Fonction qui enregistre une étape dans la base de données
 */
function recordStep(stepNum, steptext, id_Recipe) {
    $.ajax({
        type: "POST",
        url: "https://localhost:8000/api/steps",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            "stepNum": stepNum,
            "stepText": steptext,
            "recipe": "/api/recipes/" + id_Recipe
        }),
        async: false,
        success: function (data) {
            alert("Étape " + stepNum + " Ajoutée");
        }
    });
}
