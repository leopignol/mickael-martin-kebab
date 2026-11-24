const headerPromise = fetch("/layout/header.html").then(res => {
  if (!res.ok) throw new Error(`Failed to load header: ${res.status}`);
  return res.text();
});
const footerPromise = fetch("/layout/footer.html").then(res => {
  if (!res.ok) throw new Error(`Failed to load footer: ${res.status}`);
  return res.text();
});
const topButtonPromise = fetch("/layout/top-button.html").then(res => {
  if (!res.ok) throw new Error(`Failed to load top button: ${res.status}`);
  return res.text();
});

customElements.define("site-header", class extends HTMLElement {
  async connectedCallback() {
    try {
      this.innerHTML = await headerPromise;
    } catch (err) {
      console.error(err);
    }
  }
});

customElements.define("site-footer", class extends HTMLElement {
  async connectedCallback() {
    try {
      this.innerHTML = await footerPromise;
    } catch (err) {
      console.error(err);
    }
  }
});

customElements.define("top-button", class extends HTMLElement {
  async connectedCallback() {
    try {
      this.innerHTML = await topButtonPromise;
    } catch (err) {
      console.error(err);
    }
  }
});
