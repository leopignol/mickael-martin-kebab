const params = new URLSearchParams(document.location.search);

const formation = params.get("formation");

if (formation) {
  document.addEventListener("DOMContentLoaded", () => {
    try {
      document.getElementById(`formation-${formation.toLowerCase()}`)?.click();
    } catch (err) {
      console.warn(`Unrecognized formation: ${formation}`);
    }
  });
}
