let collection, addButton, span;
window.onload = () => {
    collection = document.querySelector("#members");
    span = collection.querySelector("span");

    addButton = document.createElement("button");
    addButton.className ="add-member btn secondary";
    addButton.innerText ="Ajouter dans l'équipe";

    let newButton = span.append(addButton);

    collection.dataset.index = collection.querySelectorAll("input").length;

    addButton.addEventListener("click", function(){
        ajoutBouton(collection, newButton);
    });
}

function ajoutBouton(collection, newButton){
    let prototype = collection.dataset.prototype;

    let index = collection.dataset.index;

    prototype =prototype.replace(/__pseudonyme__/g, index);

    let content = document.createElement("html");
    content.innerHTML = prototype;

    let newForm = content.querySelector("ajouterMembre");

    let deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.className = "btn red"
    deleteButton.id = "delete-member" + index;
    deleteButton.innerHTML = "Enlever de l'équipe";

    newForm.append(deleteButton);

    collection.dataset.index++;

    let addButton = collection.querySelector(".add-member");

    span.insertBefore(newForm, addButton);

}