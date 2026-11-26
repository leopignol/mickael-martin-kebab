# Mickaël Martin Kebab
https://github.com/leopignol/mickael-martin-kebab

* Disponible sur http://mickael-martin-kebab.site/
* Avec un fallback *[Alwaysdata](https://www.alwaysdata.com/)* sur https://mickael-martin-kebab.alwaysdata.net/

## Structure
```py
agent/
  - client.py # Modèle de réponse d'emails
editor/ # Fichiers pour la coloration syntaxique des fichiers sans extension
html/ # Répertoire accessible
  - admin/ #Panel administrateur
  - contact/ # Répertoire de la page de contact
    - index.html # Page affichée
    - send.php # Envoi des informations au serveur
  - css/ # Fichiers CSS
    - fonts.css # Charge les polices d'écriture
    - global.css # Fichier demandé par toutes les pages
                 # Contient les variables de thèmes
  - experts/ # Répertoire des pages
    - data/ # Fichiers JSON contenant les informations de maîtres kebabiers
    - all.html # Affiché si aucun query n'est passé
    - index.php # Gestion de quelle page afficher
  - fonts/ # Polices d'écriture
  - hiring/ # Répertoire de la page de recrutement
    - index.php # Page affichée
    - send.php # Envoi des informations au serveur
  - img/ # Images
    - books/ # Images de la partie formations (/about)
    - certification/ # Images de la partie certification (/about)
    - chefs/ # Maîtres kebabiers
    - flames/ # Flammes
    - icons/ # Icônes
    - people/ # Images des personnalités importantes
    - profile-pictures/ # Photos de profil des avis (/about)
    - students/ # Anciens élèves (/about)
  - js/ # Fichiers javascript
    - about/ # Fichiers javascript de la page /about
    - arrow.js # Gestion de la flèche de remontée (#top-button)
    - layout.js # Charge les types de layout (site-header, site-footer, top-button)
    - play-presentation.js # Démarre automatiquement la vidéo si l'utilisateur accepte l'autoplay avec son
    - theme-changer.js # Fonctions de changement de thème
  - layout/
    - footer.html # site-footer chargé par layout.js
    - header.html # site-header chargé par layout.js
    - top-button.html # top-button chargé par layout.js
  - video/ # Vidéos
    - presentation.webm # Présentation du site
  - .htaccess # Fichier de configuration Apache2
  - 404.html # Redirection quand une page n'est pas trouvée
  - about # "À propos", HTML sans extension
  - favicon.ico # Fallback d'icône
  - index.html # Page principale de présentation
  - shop # "Achat", HTML sans extension
  - terms # "Conditions d'utilisation", HTML sans extension
Makefile # Compacte le projet dans un .tar.xz
```
