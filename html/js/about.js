const params = new URLSearchParams(document.location.search);

const formation = params.get("formation");

document.addEventListener("DOMContentLoaded", () => {
  try {
    document.getElementById(`formation-${formation.toLowerCase()}`)?.click();
  } catch (err) {
    console.error(`Unrecognized formation: ${formation}`);
    console.error(err);
  }
});
