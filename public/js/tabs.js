// * Fonctionnement des onglets dans la section profil

function userInfo(evt, infoUser) {
    // Declare toutes les variables
    var i, tabcontent, tablinks;

    // Permet d'avoir tous les elemetns avec la class="tabcontentProfil" et de les cacher
    tabcontent = document.getElementsByClassName("tabcontentProfil");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
  
    // Permet d'avoir tous les elements avec la class="tablinksProfil" et enleve la class "active"
    tablinks = document.getElementsByClassName("tablinksProfil");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
  
    // Montre l'ongle activé et ajoute "active" class à l'onglet que l'on decide d'ouvrir 
    document.getElementById(infoUser).style.display = "flex";
    evt.currentTarget.className += " active";
  }

// Permet d'avoir un onglet ouvert par defaut grace à  id="defaultOpen" 
document.getElementById("defaultOpen").click();





