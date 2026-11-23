
/**
 * Changes the theme to target
 * @param {String} to
 * @returns void
 */
function changeTheme(to) {
  if (!to) return console.error(`Unknown theme: "${to}"`);
  switch (to.toLowerCase()) {
    case "light":
      console.log("Switching to light theme");
      break;
    case "dark":
      console.log("Switching to dark theme")
      break;
    default:
      console.error(`Unknown theme: "${to}"`);
      break;
  }
}