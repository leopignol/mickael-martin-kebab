<?php

if (!isset($_GET["chef"])) {
	include __DIR__ . "/all.html";
	exit;
}

$chef_value = $_GET["chef"] ?? "";

try { $json_data = file_get_contents($chef_value . ".json"); }
catch (Throwable $th) { exit ("Chef introuvable"); }

$expert_data = json_decode($json_data);
$chef = $expert_data->name;
$chef_color = $expert_data->color;
$chef_country = $expert_data->country;

$have_native_name = false;
if (isset($expert_data->native_name)) {
	$have_native_name = true;
	$chef_native_name = $expert_data->native_name;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<script src="/js/layout.js" defer></script>
		<title>Mickaël Martin Kebab - <?php echo $chef ?></title>
		<meta charset="utf-8">
		<meta name="description" content="Découvrez <?php echo $chef ?>, maître kebabier chez Mickaël Martin Kebab.">
		<link rel="stylesheet" href="/css/global.css">
		<link rel="stylesheet" href="/css/chef.css">
		<link rel="icon" href="/img/icons/favicon.svg" type="image/svg+xml">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	</head>

	<body>
		<site-header></site-header>

		<main>
			<article id="chef-profile" style="--chef-color: <?php echo $chef_color ?>">
				<div id="picture-holder">
					<img id="main-picture"
					     src="/img/chefs/<?php echo $chef_value ?>.webp"
					     alt="<?php echo $chef ?> devant une broche à kebab"
					>
				</div>
				<div class="profile-copy">
					<p class="profile-label">Maître kebabier · <?php echo $chef_country ?></p>
					<h2><?php echo $chef ?><?php if ($have_native_name): ?> <span class="korean">(<?php echo $chef_native_name ?>)</span><?php endif; ?></h2>
					<p class="profile-description">
						<?php echo $chef ?> fait partie de l'équipe de maîtres kebabiers de Mickaël Martin Kebab.
						Découvrez son portrait et sa place dans notre univers culinaire.
					</p>
					<a class="back-link" href="/experts">← Découvrir tous nos experts</a>
				</div>
			</article>
		</main>

		<site-footer></site-footer>
		<script src="/js/arrow.js"></script>
		<script src="/js/theme-changer.js"></script>
	</body>
</html>
