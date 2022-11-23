//* Preview de l'image de l'avatars

function showPreview(event){
    if(event.target.files.length > 0){
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("preview_img");
      preview.src = src;
      preview.style.display = "block";
    }
  }