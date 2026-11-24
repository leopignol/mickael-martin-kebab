
if (window.localStorage.getItem("theme-scheme")) {
  document.documentElement.style.colorScheme =
    window.localStorage.getItem("theme-scheme");
  document.getElementById("toggle-theme")?.checked;
}

function toggleTheme() {
  switch (
  document.documentElement.style.colorScheme ||
  window.localStorage.getItem("theme-scheme") ||
  "dark"
  ) {
    case "light":
      changeTheme("dark");
      break;
    case "dark":
      changeTheme("light");
      break;
    default:
      console.warn(document.documentElement.style.colorScheme)
      break;
  }
}

/**
 * Changes the theme to target scheme
 * @param {String} scheme
 * @returns void
 */
function changeTheme(scheme) {
  if (!scheme || !["light", "dark"].includes(scheme.toLowerCase()))
    return console.error(`Unknown theme: "${scheme}"`);

  console.log(`Switching to ${scheme} theme`);
  document.documentElement.style.colorScheme = scheme;
  window.localStorage.setItem("theme-scheme", scheme);
}
