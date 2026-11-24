const arrow = document.querySelector("top-button");

updateArrow();

document.addEventListener("scroll", updateArrow);

function updateArrow() {
  if (window.scrollY > 0)
    arrow.hidden = false;
  else
    arrow.hidden = true;
}
