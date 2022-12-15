// Permet de rendre inutilisable un champs après qu'un choix a été fait.

const nbTeamLimit=document.querySelector("#tournament_nbTeamLimit")
const reward=document.querySelector("#tournament_reward")


if (document.querySelector('input[name="tournament[limitedInscription]"]')) {
    document.querySelectorAll('input[name="tournament[limitedInscription]"]').forEach((elem) => {
      elem.addEventListener("change", function(event) {
        var checkBox = event.target.value;
        if (checkBox== false){
            nbTeamLimit.disabled=true
        }else{
            nbTeamLimit.disabled=false
            }  
      });
    });
  }
  

  if (document.querySelector('input[name="tournament[rewardChoice]"]')) {
    document.querySelectorAll('input[name="tournament[rewardChoice]"]').forEach((elem) => {
      elem.addEventListener("change", function(event) {
        var checkBox = event.target.value;
        if (checkBox== false){
            reward.disabled=true
        }else{
            reward.disabled=false
            }
      });
    });
  }



