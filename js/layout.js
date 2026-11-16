class SiteHeader extends HTMLElement {
  connectedCallback() {
    fetch('layout/header.html')
      .then(res => res.text())
      .then(data => this.innerHTML = data)
      .catch(err => console.error(err));
  }
}

class SiteFooter extends HTMLElement {
  connectedCallback() {
    fetch('layout/footer.html')
      .then(res => res.text())
      .then(data => this.innerHTML = data)
      .catch(err => console.error(err));
  }
}

customElements.define('site-header', SiteHeader);
customElements.define('site-footer', SiteFooter);
