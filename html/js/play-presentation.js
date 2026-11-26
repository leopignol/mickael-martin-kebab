const presentation = document.getElementById("presentation");
const startPresentation = document.getElementById("start-presentation");
const presentationStatus = document.getElementById("presentation-status");

startPresentation.addEventListener("click", async () => {
  try {
    await presentation.play();
    presentationStatus.textContent = "";
  } catch (error) {
    console.error("Could not start the presentation video.", error);
    presentationStatus.textContent =
      "La vidéo n’a pas pu démarrer. Utilisez les commandes de lecture.";
  }
});
