const container = document.getElementById('scroll-container');
let direction = 1;
let speed = 1.5;
let isPaused = false;

container.addEventListener('mouseenter', () => isPaused = true);
container.addEventListener('mouseleave', () => isPaused = false);

function autoScroll() {
  if (!isPaused) {
    container.scrollLeft += speed * direction;

    // Calculate maximum scrollable width
    const maxScroll = container.scrollWidth - container.clientWidth;

    // Reverse direction at the right or left edge (1px buffer for subpixel screens)
    if (container.scrollLeft >= maxScroll - 1) {
      direction = -1;
    } else if (container.scrollLeft <= 0) {
      direction = 1;
    }
  }
  requestAnimationFrame(autoScroll);
}

requestAnimationFrame(autoScroll);
