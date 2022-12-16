// Get the modal
var modalUser = document.getElementById('user.id');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modalUser) {
    modalUser.style.display = "none";
  }
}

