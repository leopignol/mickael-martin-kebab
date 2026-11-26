// Play presentation if user accepted auto play with sound
window.addEventListener('DOMContentLoaded', async () => {
  const video = document.getElementById('presentation');
  video.muted = false;

  try {
    await video.play();
  } catch (_) { }
});
