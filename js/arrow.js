const arrow = document.getElementById("top-button");

updateArrow();

document.addEventListener('scroll', updateArrow);

function updateArrow() {
  if (window.scrollY >= 400) {
    arrow.hidden = false;
  } else {
    arrow.hidden = true;
  }
}
