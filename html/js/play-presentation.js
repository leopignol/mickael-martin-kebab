window.addEventListener('DOMContentLoaded', async () => {
  const video = document.getElementById('presentation');
  video.muted = false;

  try {
    await video.play();
  } catch (_) { }
});
