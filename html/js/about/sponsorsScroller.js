let direction = 1;
const speed = 1.5;
let isPaused = false;

sponsorContainer.addEventListener('mouseenter', () => isPaused = true);
sponsorContainer.addEventListener('mouseleave', () => isPaused = false);

function autoScroll() {
  if (!isPaused) {
    sponsorContainer.scrollLeft += speed * direction;

    const maxScroll = sponsorContainer.scrollWidth - sponsorContainer.clientWidth;

    if (sponsorContainer.scrollLeft >= maxScroll - 1)
      direction = -1;
    else if (sponsorContainer.scrollLeft <= 0)
      direction = 1;
  }
  requestAnimationFrame(autoScroll);
}

requestAnimationFrame(autoScroll);
