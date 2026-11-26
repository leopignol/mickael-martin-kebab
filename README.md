# S1 R1.02 – Mickaël Martin Kebab
https://github.com/leopignol/mickael-martin-kebab

* Disponible en HHTP sur http://mickael-martin-kebab.site/
  * Hébergé sur un Raspberry PI 5 4GB
* Avec un fallback HTTPS *[Alwaysdata](https://www.alwaysdata.com/)* sur https://mickael-martin-kebab.alwaysdata.net/

## Contact
* LIAUTAUD Loevan: `loevan.liautaud@etu.univ-amu.fr`
* PIGNOL Léo: `leo.pignol.1@etu.univ-amu.fr`
* VINAS Lian: `lian.vinas@etu.univ-amu.fr`

## Données
* Sources: https://app.notion.com/p/424e07d7699180bf8c0bfa193fa08b07?v=424e07d7699180428482000c46074d3e
* Historique des prompts: https://app.notion.com/p/Historique-des-prompts-423e07d7699180749b22ef68668b08b0

## Structure
```py
agent/
  - client.py # Modèle de réponse d'emails
editor/ # Fichiers pour la coloration syntaxique des fichiers sans extension
html/ # Répertoire accessible
  - admin/ # Panel administrateur
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
```
