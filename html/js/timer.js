
const timers = document.getElementsByClassName("timer");

if (!window.localStorage.getItem("timer-start"))
  window.localStorage.setItem("timer-start", Date.now() + 1);

updateTimers();
setInterval(updateTimers, 1000);

function updateTimers() {
  for (let timer of timers) {
    let difference = new Date(
      window.localStorage.getItem("timer-start") - Date.now()
    );
    timer.textContent =
      `${difference.getMinutes()}:${difference.getSeconds() < 10 ? "0" : ""}${difference.getSeconds()}`;
  }
}
