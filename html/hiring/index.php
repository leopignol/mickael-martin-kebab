<html>
  <head>
		<script src="/js/layout.js" defer></script>
		<title>Mickaël Martin Kebab – Recrutement</title>
		<meta charset="utf-8">
		<meta name="description" content="Mickaël Martin Kebab – Recrutement">
		<meta name="keywords"
		      content="mickael, martin, kebab, mickael-martin, formation, kebabier, maitre"
		>
		<meta name="application-name" content="Mickaël Martin Kebab">
		<meta name="subject"
		      content="Mickaël Martin Kebab – Formations maître kebabiers – Recrutement"
		>
		<meta name="language" content="FR">
		<meta name="summary"
		      content="Mickaël Martin Kebab – Formations maître kebabiers"
		>
		<meta name="classification" content="Business">
		<meta name="author" content="LIAUTAUD Loevan, PIGNOL Léo, VINAS Lian">
		<meta name="designer" content="VINAS Lian">
		<meta name="reply-to" content="mickael-martin-kebab@mailo.com">
		<meta name="owner" content="Mickaël Martin">
		<meta name="url" content="https://mickael-martin-kebab.site">
		<meta name="distribution" content="Global">
		<meta name="rating" content="General">
		<meta name="subtitle" content="Formations maître kebabier">
		<meta name="target" content="all">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/css/global.css">
		<link rel="stylesheet" href="/css/fonts.css">
		<link rel="stylesheet" href="/css/hiring.css">
		<link rel="icon" href="/img/icons/favicon.svg" type="image/svg+xml">
		<link rel="apple-touch-icon" href="/img/icons/apple-touch-icon.png">
	</head>
	<body>
		<site-header></site-header>

		<main>
			<form id="hiring-form" action="send.php" method="post">
				<label id="title">Formulaire d'inscription</label>

				<div class="field">
					<input type="text" autocomplete="given-name" id="first-name" name="first_name" placeholder=" " required/>
					<label for="first-name">Prénom</label>
				</div>

				<div class="field">
					<input type="text" autocomplete="family-name" id="name" name="last_name" placeholder=" " required/>
					<label for="name">Nom</label>
				</div>

				<div class="field">
					<input type="email" autocomplete="email" id="mail" name="email" placeholder=" " required/>
					<label for="mail">E-mail</label>
				</div>

				<div class="field">
					<input type="tel" autocomplete="tel" id="phone" name="phone" placeholder=" " required>
					<label for="phone">Numéro de téléphone</label>
				</div>

				<div class="field training-field">
					<select id="training" name="training" required>
						<option value="simple" <?php if ($_GET["training"] === "simple") echo "selected"; ?>  >Simple</option>
						<option value="pro" <?php if ($_GET["training"] === "pro") echo "selected"; ?> >Pro</option>
						<option value="pro-max" <?php if ($_GET["training"] === "pro-ultra") echo "selected"; ?> >Pro Ultra</option>
					</select>
					<label for="training">Formation</label>
				</div>

				<div class="field address-field">
					<input type="text" autocomplete="street-address" id="address" name="address" placeholder=" " required/>
					<label for="address">Adresse du domicile</label>
				</div>

				<fieldset class="card-information">
					<legend>Informations bancaires</legend>
					<div class="card-fields">
						<div class="field">
							<input
								type="text"
								id="card-number"
								name="card_number"
								inputmode="numeric"
								autocomplete="cc-number"
								placeholder=" "
								maxlength="23"
								pattern="[0-9 ]{12,23}"
								required
							/>
							<label for="card-number">Numéro de carte</label>
						</div>

						<div class="field">
							<input
								type="text"
								id="card-expiry"
								name="card_expiry"
								inputmode="numeric"
								autocomplete="cc-exp"
								placeholder=" "
								maxlength="5"
								pattern="(0[1-9]|1[0-2])\/?([0-9]{2})"
								required
							/>
							<label for="card-expiry">Expiration (MM/AA)</label>
						</div>

						<div class="field">
							<input
								type="text"
								id="card-cvc"
								name="card_cvc"
								inputmode="numeric"
								autocomplete="cc-csc"
								placeholder=" "
								maxlength="4"
								pattern="[0-9]{3,4}"
								required
							/>
							<label for="card-cvc">Cryptogramme (CVC)</label>
						</div>
					</div>
				</fieldset>

				<label class="message-label" for="content">Lettre de motivation (2000 caractères maximum)</label>
				<textarea id="content" name="message" maxlength="1000" required></textarea>
				<div class="cgu-label"><labe>En cliquant sur "Envoyer" vous confirmez avoir lu et approuver les <a href="/terms" class="underline-link"> Condition Générales d'Utilisation</a></label></div>
				<input type="submit" id="send-button" value="Envoyer"/>
			</form>
		</main>

		<top-button></top-button>
		<site-footer></site-footer>

		<script src="/js/arrow.js"></script>
		<script src="/js/theme-changer.js"></script>
	</body>
</html>
