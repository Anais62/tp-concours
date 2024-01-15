let image = document.querySelector(".taper")
let audio = document.querySelector(".music")

image.addEventListener("click", function() {
    audio.play();
    console.log("MUSIQUE");
})

