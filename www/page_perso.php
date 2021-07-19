<?php
//récupération des fonctions
	require_once ("inc/pp.class.php");

	$pp = new pp;
	$pp->connecter_base();
	$pp->authentifier();
	$pp->traiter_commande();
	$pp->afficher_page_accueil();

?>
