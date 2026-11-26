const sponsorContainer = document.getElementById("sponsors");

const rawSponsors = [
  {
    name: "Activision / Blizzard",
    icon: "https://upload.wikimedia.org/wikipedia/commons/6/6e/Activision_Blizzard_logo.svg",
    url: "https://www.activisionblizzard.com/",
    role: "Culture et ambiance de travail"
  },
  {
    name: "Aperture Science",
    icon: "https://upload.wikimedia.org/wikipedia/commons/0/02/Aperture_Laboratories_Logo.svg",
    url: "https://www.aperturescience.com/a/b/c/d/g/h/abcdgh/",
    role: "Fournisseur d'intelligence artificielle"
  },
  {
    name: "Arasaka",
    icon: "https://media.printables.com/media/prints/399302/images/3327506_e8ad9cad-f780-4757-a334-90e975b16c1c/thumbs/inside/1280x960/webp/cp2077_arasaka_logo_red.webp",
    url: "https://arasakainc.com/",
    role: "Fournisseur de viande"
  },
  {
    name: "Bad Dragon",
    icon: "https://logos-world.net/wp-content/uploads/2022/12/Bad-Dragon-Logo.png",
    url: "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
    role: "Création de l'“espace détente”"
  },
  {
    name: "Centre équestre Lyon-Parilly",
    icon: "https://centreequestre-lyonparilly.fr/wp-content/uploads/2020/02/cropped-logo-1.jpg",
    url: "https://centreequestre-lyonparilly.fr/",
    role: "Véhicules de fonction"
  },
  {
    name: "Flock",
    icon: "https://upload.wikimedia.org/wikipedia/commons/6/6f/Flock_Logo_Green.svg",
    url: "https://www.flocksafety.com/",
    role: "Sécurité des locaux"
  },
  {
    name: "Kebab Market",
    icon: "https://kebab-market.alwaysdata.net/image/kebabe.ico",
    url: "https://kebab-market.alwaysdata.net/",
    role: "Notre partenaire en or"
  },
  {
    name: "MAPPA",
    icon: "https://upload.wikimedia.org/wikipedia/commons/0/06/MAPPA_Logo.svg",
    url: "https://www.mappa.co.jp/",
    role: "Gestion des horaires de travail"
  },
  {
    name: "Mickaël Martin Nevot",
    icon: "https://www.mickael-martin-nevot.com/_assets/images/logo/sypher-blue.jpg",
    url: "https://www.mickael-martin-nevot.com/",
    role: "Conseiller d'orientation"
  },
  {
    name: "Montcuq",
    icon: "https://upload.wikimedia.org/wikipedia/commons/e/e0/Blason_ville_fr_Montcuq_46.svg",
    url: "https://www.cahorsvalleedulot.com/explorer/visitez-la-vallee-du-lot/les-plus-beaux-villages-de-la-vallee-du-lot/montcuq/",
    role: "Collaborateur officiel d'implémentation de Kebab Markets"
  },
  {
    name: "Mossad",
    icon: "https://upload.wikimedia.org/wikipedia/commons/8/86/Mossad_seal.svg",
    url: "https://www.mossad.gov.il/",
    role: "\"Support en tout genre\""
  },
  {
    name: "Optifine",
    icon: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStwKCNC0wlFM58jD5VhINObSv2aY-tqMAYR2Eq4K9I2I5qLbPTlH5jiSvq&s=10",
    url: "https://optifine.net",
    role: "Optimisation fiscale"
  },
  {
    name: "Palantir",
    icon: "https://upload.wikimedia.org/wikipedia/commons/1/13/Palantir_Technologies_logo.svg",
    url: "https://www.palantir.com/",
    role: "Support moral officiel"
  },
  {
    name: "Parti Communiste Chinois",
    icon: "https://upload.wikimedia.org/wikipedia/commons/6/6d/Flag_of_the_Chinese_Communist_Party.svg",
    url: "https://www.idcpc.org.cn/",
    role: "Exil politique"
  },
  {
    name: "Piscine municipale Vallier",
    icon: "https://yt3.googleusercontent.com/p2uFYXaTVXwalU7bZo-glsPko5Iccm3D4T0jJLKol5RIkQgHJNpYX8-b4WSl50oEtDD_ZKhh=s900-c-k-c0x00ffffff-no-rj",
    url: "https://www.marseille.fr/sports-loisirs/equipements-sportifs/piscines-municipales",
    role: "Pour offrir des formations, même quand l'environement ne s'y prête pas"
  },
  {
    name: "Rothschild & Co",
    icon: "https://upload.wikimedia.org/wikipedia/en/1/1f/Rothschild_%26_Co_Logo.svg",
    url: "https://www.rothschildandco.com/",
    role: "Support financier"
  },
  {
    name: "SpaceX",
    icon: "https://upload.wikimedia.org/wikipedia/commons/2/2e/SpaceX_logo_black.svg",
    url: "https://www.spacex.com/",
    role: "Nous permet d'offrir nos formations partout dans le monde"
  },
  {
    name: "Torch",
    icon: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9ngj58NRPBwu9LTe1bviUc-G803-FwUI44z2lh8Wo_g&s=10",
    url: "http://xmh57jrknzkhv6y3ls3ubitzfqnkrwxhopf5aygthi7d6rplyvk3noyd.onion/",
    role: "Référencement des formations sur Internet"
  },
  {
    name: "US Lanvallay",
    icon: "https://s2.static-footeo.com/100/uploads/uslanvallay/logo__76jtu0kr3.png",
    url: "https://www.transfermarkt.fr/us-lanvallay/startseite/verein/142751",
    role: "En vrai c'est nous qui les payons"
  },
  {
    name: "Villejuif",
    icon: "https://upload.wikimedia.org/wikipedia/fr/8/83/Logo_Villejuif_-_2023.svg",
    url: "https://www.villejuif.fr/accueil",
    role: "Collaborateur officiel d'implémentation de Kebab Markets"
  },
  {
    name: "Waze",
    icon: "https://upload.wikimedia.org/wikipedia/en/b/bc/Logo_for_waze.svg",
    url: "https://www.waze.com/",
    role: "Pour trouver le chemin vers vos formations"
  }
];

var sponsors = rawSponsors;

for (let i = 0; i < sponsors.length; i++) {
  let j = Math.round(Math.random() * sponsors.length);
  let temp = sponsors[i];
  sponsors[i] = sponsors[j];
  sponsors[j] = temp;
}

console.debug(`${sponsors.length} sponsors`);

for (let sponsor of sponsors) {
  console.debug(sponsor);
  if (!sponsor) continue;
  let link = document.createElement("a");
  link.classList.add("sponsor");
  link.href = sponsor.url;
  link.target = "_blank";
  link.title = `${sponsor.name}\n\n${sponsor.role}`;

  let container = document.createElement("figure");
  container.classList.add("sponsor-container");

  let name = document.createElement("h3");
  name.classList.add("sponsor-name");
  name.textContent = sponsor.name;

  let imageContainer = document.createElement("div");
  imageContainer.classList.add("sponsor-icon-container");

  let image = document.createElement("img");
  image.classList.add("sponsor-icon");
  image.loading = "lazy";
  image.src = sponsor.icon;
  image.alt = sponsor.name;

  let description = document.createElement("figcaption");
  description.classList.add("sponsor-description");
  description.textContent = sponsor.role;

  imageContainer.appendChild(image);

  container.appendChild(name)
  container.appendChild(imageContainer);
  container.appendChild(description);

  link.appendChild(container);

  sponsorContainer.appendChild(link);
}
