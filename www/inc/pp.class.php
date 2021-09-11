<?php
class pp
{
	var $lien_mysql;
	var $messages;
	
	function pp()
	{
		$this->messages = new messages;
	}

	function authentifier()
	{
		session_start() ;
		//on vÃ©rifie si l'utilisateur est identifiÃ©
		if ( !isset( $_SESSION['nom'] ) ) {

	if ( isset( $_POST['pseudo'] ) && isset( $_POST['motdepasse'] ) ) {

	//on les rÃ©cupÃ¨re
	$nom = $_POST['pseudo'] ;
	$motdepasse = $_POST['motdepasse'] ;
	
	//on teste si le mot de passe est valide :
	if ( $this->verification( $nom, $motdepasse ) ) {
	//le mot de passe est valide, l'utilisateur est identifiÃ©
	//on change d'identifiant de session
		session_regenerate_id();

	//on sauvegarde donc son nom dans la session
		$_SESSION['nom'] = $nom ;
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'info', 'Bonjour '.$nom.', vous &ecirc;tes correctement identifi&eacute;'));
		$this->afficher_page_accueil();
		exit;
	} else {
	//sinon on avertit l'utilisateur :
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'erreur', 'Echec de l\'authentification !'));
		$this->afficher_page_authentication();
		exit;
	}
} else {
//un des champs n'est pas rempli
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'erreur', 'Echec de l\'authentification !'));
		$this->afficher_page_authentication();
		exit;
}

		//la variable de session n'existe pas,
		//donc l'utilisateur n'est pas authentifiÃ©
		//On redirige sur la page permettant de s'authentifier
		$this->afficher_page_authentication();

		//On arrÃªte l'exÃ©cution
		exit() ;
	}

	}
	
	function connecter_base()
	{
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'dbug', 'connecter_base...'));

		// connection Ã  mysql
		
		//Connexion SQL
		$dbhote = 'john.doe.sql.free.fr'; //Enter here the database address 
		$dbuser = 'john.doe'; // Enter here the user ID
		$dbpass = 'qwerty123'; // Enter here the password for the database
		$dbase = 'joe_doe'; // Enter here the name of the database
		$this->lien_mysql = mysql_connect ($dbhote,$dbuser,$dbpass);
		mysql_query("SET NAMES 'utf8'");
		
		if(!$this->lien_mysql)
		{
			$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'erreur', 'Impossible de se connecter à la base de données.'));
		}

		// sÃ©lection de la base de donnÃ©es
		$mysql = mysql_select_db($dbase,$link);
		if(!$mysql)
		{
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'erreur', 'Impossible de sÃ©lectionner la base de données.'));
		};
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'dbug', 'connecter_base... OK.'));
	}

	function traiter_commande()
	{
		$this->messages->ajouter( $this->utilisateur->admin_on, new message(NULL, 'dbug', 'traiter_commande'));
		if(isset($_REQUEST["commande"]))
		{
			$commande = $_REQUEST["commande"];
			switch($commande)
			{
				case "deconnecter" :
					session_destroy();
					unset($_SESSION);
					$this->authentifier();
					break;

				case "afficher_liste_de_courses" :
					$this->mettre_a_jour_liste();
					$this->afficher_liste_de_courses();
					exit;
				case "supprimer_articles_barres" :
					$this->supprimer_articles_barres();
					$this->afficher_liste_de_courses();
					exit;
				case "afficher_edition_article" :
					$this->afficher_edition_article();
					exit;
				case "afficher_edition_article_recette" :
					$this->afficher_edition_article_recette();
					exit;
				case "afficher_edition_materiel_recette" :
					$this->afficher_edition_materiel_recette();
					exit;
				case "modifier_article" :
					$this->modifier_article();
					$this->afficher_liste_de_courses();
					exit;
				case "modifier_article_recette" :
					$this->modifier_article_recette();
					$this->editer_item_menu();
					exit;
				case "modifier_materiel_recette" :
					$this->modifier_materiel_recette();
					$this->editer_item_menu();
					exit;
				case "modifier_rayon" :
					$this->modifier_rayon();
					$this->editer_les_rayons();
					exit;
				case "confirmer_suppression_article" :
					$this->confirmer_suppression_article();
					exit;
				case "confirmer_suppression_article_recette" :
					$this->confirmer_suppression_article_recette();
					exit;
				case "confirmer_suppression_materiel_recette" :
					$this->confirmer_suppression_materiel_recette();
					exit;
				case "supprimer_article" :
					$this->supprimer_article();
					$this->afficher_liste_de_courses();
					exit;
				case "supprimer_article_recette" :
					$this->supprimer_article();
					$this->editer_item_menu();
					exit;
				case "supprimer_materiel_recette" :
					$this->supprimer_article();
					$this->editer_item_menu();
					exit;
				case "retirer_type_repas" :
					$this->retirer_type_repas();
					$this->editer_item_menu();
					exit;
				case "editer_les_rayons" :
					$this->editer_les_rayons();
					exit;
				case "remonter_liste_rayon" :
					$this->remonter_liste_rayon();
					$this->editer_les_rayons();
					exit;
				case "redescendre_liste_rayon" :
					$this->redescendre_liste_rayon();
					$this->editer_les_rayons();
					exit;
				case "afficher_edition_rayon" :
					$this->afficher_edition_rayon();
					exit;
				case "confirmer_suppression_rayon" :
					$this->confirmer_suppression_rayon();
					exit;
				case "ajouter_rayon" :
					$this->ajouter_rayon();
					$this->editer_les_rayons();
					exit;
				case "ajouter_etape_recette" :
					$this->ajouter_etape_recette();
					$this->editer_item_menu();
					exit;
				case "modifier_etape_recette" :
					$this->modifier_etape_recette();
					$this->editer_item_menu();
					exit;
				case "supprimer_etape_recette" :
					$this->supprimer_etape_recette();
					$this->editer_item_menu();
					exit;
				case "supprimer_rayon" :
					$this->supprimer_rayon();
					$this->editer_les_rayons();
					exit;
				case "afficher_menu_de_la_semaine" :
					$this->afficher_menu_de_la_semaine();
					exit;
				case "imprimer_liste_de_courses" :
					$this->imprimer_liste_de_courses();
					$this->afficher_liste_de_courses();
					exit;
				case "edition_menu_jour" :
					$this->edition_menu_jour();
					exit;
				case "ajouter_item_menu_au_menu" :
					$this->ajouter_item_menu_au_menu();
					$this->edition_menu_jour();
					exit;
				case "retirer_item_menu" :
					$this->retirer_item_menu();
					$this->edition_menu_jour();
					exit;
				case "afficher_liste_des_recettes" :
					$this->mettre_a_jour_liste_recettes();
					$this->afficher_liste_des_recettes();
					exit;
				case "afficher_edition_etape_recette" :
					$this->afficher_edition_etape_recette();
					exit;
				case "supprimer_recette" :
					$this->supprimer_recette();
					$this->afficher_liste_des_recettes();
					exit;
				case "detail_item_menu" :
					$this->detail_item_menu();
					exit;
				case "editer_item_menu" :
					$this->mettre_a_jour_recette();
					$this->editer_item_menu();
					exit;
				case "completer_liste_de_courses_depuis_menu" :
					$this->completer_liste_de_courses_depuis_menu();
					exit;
				case "confirmer_suppression_recette" :
					$this->confirmer_suppression_recette();
					exit;
			};
		};
	}

	function verification($nom,$pass)
	{
		$this->connecter_base();
		//CrÃ©ation de la requÃªte SQL
		$nom_sql = mysql_real_escape_string($nom) ;
		$pass_sql = mysql_real_escape_string($pass) ;
		$sql ="SELECT * FROM user WHERE login='$nom_sql' AND pass='$pass_sql'" ;

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);
		if(mysql_num_rows($result)>0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	Function completer_liste_de_courses_depuis_menu()
	{
$sql = "SELECT ldc_rayons.designation as designation_rayon, ldc_articles.ID, ldc_articles.designation, SUM(mds_recettes.quantite) AS quantite, ldc_articles.unite, ldc_liste.quantite AS quantite_deja_notee FROM mds_repas_prevus LEFT JOIN mds_recettes ON mds_repas_prevus.item_menu = mds_recettes.ID_item_menu LEFT JOIN ldc_articles ON mds_recettes.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_rayons.ID = ldc_articles.ID_rayon LEFT JOIN ldc_liste ON mds_recettes.ID_article = ldc_liste.ID_article WHERE date BETWEEN ";

If (isset($_POST["date_debut"]) AND isset($_POST["date_fin"]))
{
	$sql .= "'".$_POST["date_debut"]."' AND '".$_POST["date_fin"]."'";
}
else
{
	$sql .= "'".date("Y-m-d")."' AND '".date("Y-m-d")."'";
};
$sql .= " AND NOT(ldc_articles.ID IS NULL) GROUP BY mds_recettes.ID_article ORDER BY ldc_rayons.ordre, ldc_articles.designation";

//Execution de la requÃªte SQL
$result = mysql_query($sql,$this->lien_mysql);
$nombre_articles = mysql_num_rows($result)

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="./styles/liste_de_courses_depuis_menu.css">
		<title>Liste de courses depuis le menu</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses depuis le menu
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se dÃ©connecter</a>
				</li>
			</ul>
		</div>
		<div class="selection_jour">
				<h2>Liste de courses du __ au __</h2>
				<form method="POST" action="page_perso.php?commande=completer_liste_de_courses_depuis_menu">
				<p class="champs_centres">
					<input class="champ" name="date_debut" type="date" value="<?
					if (isset($_POST["date_debut"]))
					{
						echo $_POST["date_debut"];
					}
					else
					{
						echo date("Y-m-d");
					};?>">
					<input class="champ" name="date_fin" type="date" value="<?
					if (isset($_POST["date_fin"]))
					{
						echo $_POST["date_fin"];
					}
					else
					{
						echo date("Y-m-d");
					};?>">
					<input class="bouton" type="submit" value="GÃ©nÃ©rer la liste">
				</p>
				</form>
		</div>
		<div class="liste_de_courses">
				<h2>Liste dans l'ordre des rayons (<? echo $nombre_articles; ?> entrÃ©e(s))</h2>
			<form method="POST" action="page_perso.php?commande=afficher_liste_de_courses">
<?
$titre = "";
$premier_titre = true;
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$nouveau_titre = $row["designation_rayon"];
			$ID_article = $row["ID"];
			$designation = $row["designation"];
			$unite = $row["unite"];
			$quantite = $row["quantite"];
			$quantite_deja_notee = $row["quantite_deja_notee"];
			if ($nouveau_titre <> $titre)
			{
				$titre = $nouveau_titre;
				if ($premier_titre <> true)
				{
					echo "</ul>";
				};
				$premier_titre = false;
				echo "<h3>".$titre."</h3><ul>";
			};
			$texte_article = "<li><span class=\"etiquette_article\">".$designation." (".$unite.") : ";
			if ($quantite_deja_notee <> "")
			{
				$texte_article .= "(".$quantite_deja_notee." sur la liste)";
			};
			$texte_article .= " </span><input class=\"champ_quantite\" type='number'";
			if ($row["unite"] == "litre(s)")
			{
				$texte_article .= " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				$texte_article .= " step='0.01'";
			};
			if ($quantite_deja_notee <> "")
			{
				$texte_article .= "name='quantite_modifiee[".$ID_article."]' value='".$quantite."'></li>";
			}
			else
			{
				$texte_article .= "name='quantite_ajoutee[".$ID_article."]' value='".$quantite."'></li>";
			};
			echo $texte_article;
		};
		echo "</ul>";
?>
				<p class="champs_centres">
				<input class="bouton" type="submit" value="Ajouter Ã  la liste">
				</p>
			</form>

		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?		
	}
	
	Function detail_item_menu()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="./styles/detail_recette.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>DÃ©tail de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_liste_des_recettes">Liste des recettes</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se dÃ©connecter</a>
				</li>
			</ul>
		</div>
<?
	$sql = "SELECT ID, designation FROM mds_items_menu WHERE ID = ".$_GET["ID_item_menu"];

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$designation =  $row["designation"];
?>
		<div class="liste_des_recettes">
				<h2><? echo $designation; ?></h2>
				<h3>IngrÃ©dients</h3>
<?
	$sql = "SELECT ID_article, designation, quantite, unite FROM mds_recettes LEFT JOIN ldc_articles ON ID_article = ID WHERE ID_item_menu =".$_GET["ID_item_menu"];
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = stripslashes($row["designation"]);
			$quantite = $row["quantite"];
			$unite = $row["unite"];
			$texte_liste .= "<li><span class=\"etiquette_recette\">".$designation." : ".$quantite." ".$unite."</span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun ingrÃ©dient</em>";
	};

?>
				<h3>MatÃ©riel</h3>
<?
	$sql = "SELECT ID_article, designation, quantite, unite FROM mds_materiel LEFT JOIN ldc_articles ON ID_article = ID WHERE ID_item_menu =".$_GET["ID_item_menu"];
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = $row["designation"];
			$quantite = $row["quantite"];
			$unite = $row["unite"];
			$texte_liste .= "<li><span class=\"etiquette_recette\">".$designation." : ".$quantite." ".$unite."</span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun matÃ©riel</em>";
	};
?>
				<h3>PrÃ©paration</h3>
<?
	$sql = "SELECT ID_item_menu, ordre, texte FROM mds_instructions WHERE ID_item_menu =".$_GET["ID_item_menu"]." ORDER BY ordre";
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte = $row["texte"];
			$texte_liste .= "<li><span class=\"etiquette_recette\">".$texte."</span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucune instruction</em>";
	};
?>
				<h3>Type de repas</h3>
<?
	$sql = "SELECT ID_item_menu, ID_type_repas, designation FROM mds_items_menu_types_repas LEFT JOIN mds_types_repas ON ID_type_repas = ID WHERE ID_item_menu =".$_GET["ID_item_menu"]." ORDER BY ID_type_repas";
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = $row["designation"];
			$texte_liste .= "<li><span class=\"etiquette_recette\">".$designation."</span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun typage</em>";
	};
?>
		</div>
		<div class="edition_de_la_recette">
				<h2>Edition de la recette</h2>
				<form action="page_perso.php">
					<p class="champs_centres">
					<input type="hidden" name="commande" value="editer_item_menu">
					<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"]; ?>">
					<input class="bouton" type="submit" value="Editer la recette">
					</p>
				</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?
	}
	
	function editer_item_menu()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="./styles/edition_recette.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_liste_des_recettes">Liste des recettes</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se dÃ©connecter</a>
				</li>
			</ul>
		</div>
<?
	$sql = "SELECT ID, designation FROM mds_items_menu WHERE ID = ".$_REQUEST["ID_item_menu"];

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$designation_item_menu =  $row["designation"];
?>
		<div class="liste_des_recettes">
				<h2><? echo $designation_item_menu; ?></h2>
				<h3>IngrÃ©dients</h3>
<?
	$sql = "SELECT ID_article, designation, quantite, unite FROM mds_recettes LEFT JOIN ldc_articles ON ID_article = ID WHERE ID_item_menu =".$_REQUEST["ID_item_menu"];
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = stripslashes($row["designation"]);
			$quantite = $row["quantite"];
			$unite = $row["unite"];
			$ID_article = $row["ID_article"];
			$texte_liste .= "<li><span class=\"etiquette_recette\"> <a href=\"page_perso.php?commande=afficher_edition_article_recette&ID_item_menu=".$_REQUEST["ID_item_menu"]."&ID_article=".$ID_article."\">".$designation." : ".$quantite." ".$unite."</a></span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun ingrÃ©dient</em>";
	};

?>
				<h3>MatÃ©riel</h3>
<?
	$sql = "SELECT ID_article, designation, quantite, unite FROM mds_materiel LEFT JOIN ldc_articles ON ID_article = ID WHERE ID_item_menu =".$_REQUEST["ID_item_menu"];
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = $row["designation"];
			$quantite = $row["quantite"];
			$unite = $row["unite"];
			$ID_article = $row["ID_article"];
			$texte_liste .= "<li><span class=\"etiquette_recette\"><a href=\"page_perso.php?commande=afficher_edition_materiel_recette&ID_item_menu=".$_REQUEST["ID_item_menu"]."&ID_article=".$ID_article."\">".$designation." : ".$quantite." ".$unite."</a></span></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun matÃ©riel</em>";
	};
?>
				<h3>PrÃ©paration</h3>
<?
	$sql = "SELECT ID_item_menu, ordre, texte FROM mds_instructions WHERE ID_item_menu =".$_REQUEST["ID_item_menu"]." ORDER BY ordre";
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<form action=\"page_perso.php\"><ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte = $row["texte"];
			$ordre = $row["ordre"];
			$texte_liste .= "<li><span class=\"etiquette_recette\"><a href=\"page_perso.php?commande=afficher_edition_etape_recette&numero_instruction_editee=".$ordre."&ID_item_menu=".$_REQUEST["ID_item_menu"]."\">".$texte."</a></span></li>";
		};	
		echo $texte_liste."</ul><p class=\"champs_centres\"><input type=\"hidden\" name=\"commande\" value=\"afficher_edition_etape_recette\"><input type=\"hidden\" name=\"numero_instruction_editee\" value=\"".($ordre + 1)."\"><input type=\"hidden\" name=\"ID_item_menu\" value=\"".$_REQUEST["ID_item_menu"]."\"><input class=\"bouton\" type=\"submit\" value=\"Ajouter une Ã©tape\"></p></form>";
	}
	else
	{
		echo "<em>Aucune instruction</em><form action=\"page_perso.php\"><p class=\"champs_centres\"><input type=\"hidden\" name=\"commande\" value=\"afficher_edition_etape_recette\"><input type=\"hidden\" name=\"numero_instruction_editee\" value=\"1\"><input type=\"hidden\" name=\"ID_item_menu\" value=\"".$_REQUEST["ID_item_menu"]."\"><input class=\"bouton\" type=\"submit\" value=\"Ajouter une Ã©tape\"></p></form>";
	};


?>
				<h3>Type de repas</h3>
<?
	$sql = "SELECT ID_item_menu, ID_type_repas, designation FROM mds_items_menu_types_repas LEFT JOIN mds_types_repas ON ID_type_repas = ID WHERE ID_item_menu =".$_REQUEST["ID_item_menu"]." ORDER BY ID_type_repas";
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "<ul class=\"types_repas\">";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$designation = $row["designation"];
			$ID_type_repas = $row["ID_type_repas"];
			$texte_liste .= "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php\"><input type=\"hidden\" name=\"commande\" value=\"retirer_type_repas\"><input type=\"hidden\" name=\"ID_type_repas\" value=\"".$ID_type_repas."\"><input name=\"ID_item_menu\" value=\"".$_REQUEST["ID_item_menu"]."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
		};	
		echo $texte_liste."</ul>";
	}
	else
	{
		echo "<em>Aucun typage</em>";
	};
?>
			</div>
		<div class="edition_nom_de_la_recette">
				<h2>Nom de la recette</h2>
				<form method="GET" action="page_perso.php">
					<p class="champs_centres">
					<input type="hidden" name="commande" value="editer_item_menu">
					<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"];?>">
					<input class="champ" name="Nouvelle_designation" value="<? echo $designation_item_menu?>">
					<input class="bouton" type="submit" value="Modifier">
					</p>
				</form>
		</div>
		<div ID="ajout_ingredient_a_la_recette" class="ajout_ingredient_a_la_recette">
				<h2>Ajouter un ingrÃ©dient Ã  la recette</h2>
				<? echo $this->composition_liste_ingredients_a_ajouter($_REQUEST["ID_item_menu"])
?>
		</div>
		<div class="ajout_materiel_a_la_recette">
				<h2>Ajouter du matÃ©riel Ã  la recette</h2>
				<? echo $this->composition_liste_materiel_a_ajouter($_REQUEST["ID_item_menu"])
?>
		</div>
		<div class="ajout_type_repas_a_la_recette">
				<h2>Ajouter un type de repas Ã  la recette</h2>
				<? echo $this->composition_liste_type_repas_a_ajouter($_REQUEST["ID_item_menu"])
?>
		</div>
		<div class="suppression_de_la_recette">
				<h2>Suppression de la recette</h2>
				<form method="GET" action="page_perso.php">
					<p class="champs_centres">
					<input type="hidden" name="commande" value="confirmer_suppression_recette">
					<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"];?>">
					<input class="bouton_annuler" type="submit" value="Supprimer la recette">
					</p>
				</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?
	}
	
	function afficher_page_accueil()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv = "Content-Type" content="text / html; charset = utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="menu_de_la_semaine.css">
		<title>Page personnelle</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Page personnelle
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_liste_des_recettes">Liste des recettes</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_liste_de_courses">Liste de courses</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	}

	function afficher_edition_article()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv = "Content-Type" content="text / html; charset = utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Liste de courses</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un article</h2>

			<form method="post" action="page_perso.php">
				<p class="champs_centres">
<?
				$ID_article = $_GET["ID_article"];
				$ID_article = mysql_real_escape_string($ID_article);
				$sql ="SELECT ldc_articles.designation, ldc_liste.quantite, ldc_liste.checked, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, ldc_liste.ID_article as ID_article FROM `ldc_liste` LEFT JOIN ldc_articles ON ldc_liste.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE ldc_articles.ID = ".$ID_article." ORDER BY ldc_rayons.ordre, ldc_articles.designation";

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$designation =  $row["designation"];

?>
				<input type="hidden" name="commande" value="modifier_article"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input class="champ" name="nouvelle_designation" value="<? echo $designation; ?>" type="text">
				<input class="champ" name="nouvelle_quantite" value="<? echo $row["quantite"]."\""; 
			if ($row["unite"] == "litre(s)")
			{
				echo " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				echo " step='0.01'";
			};
?> type="number">
				<input class="champ" name="nouvelle_unite" value="<? echo $row["unite"]; ?>" type="text">
				<? echo $this->composition_select_rayons($row["ID_rayon"]) ?>
				<input class="bouton" type="submit" value="Modifier l'article">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="confirmer_suppression_article"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_liste_de_courses"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	}

	function afficher_edition_article_recette()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv = "Content-Type" content="text / html; charset = utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2><?
$sql = "SELECT designation FROM mds_items_menu WHERE ID = ".$_GET["ID_item_menu"];
$result = mysql_query($sql,$this->lien_mysql);
$row = mysql_fetch_array($result);
$designation =  $row["designation"];

echo $designation;				
?></h2>

			<form method="post" action="page_perso.php">
				<p class="champs_centres">
<?
				$ID_article = $_GET["ID_article"];
				$ID_article = mysql_real_escape_string($ID_article);
				$sql ="SELECT ldc_articles.designation, mds_recettes.quantite, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, mds_recettes.ID_article as ID_article FROM `mds_recettes` LEFT JOIN ldc_articles ON mds_recettes.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE mds_recettes.ID_item_menu = ".$_GET["ID_item_menu"]." AND ldc_articles.ID = ".$ID_article;

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$designation =  stripslashes($row["designation"]);

?>
				<input type="hidden" name="commande" value="modifier_article_recette"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input class="champ" name="nouvelle_designation" value="<? echo $designation; ?>" type="text">
				<input class="champ" name="nouvelle_quantite" value="<? echo $row["quantite"]."\""; 
			if ($row["unite"] == "litre(s)")
			{
				echo " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				echo " step='0.01'";
			};
?> type="number">
				<input class="champ" name="nouvelle_unite" value="<? echo $row["unite"]; ?>" type="text">
				<? echo $this->composition_select_rayons($row["ID_rayon"]) ?>
				<input class="bouton" type="submit" value="Modifier l'article">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="confirmer_suppression_article_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="editer_item_menu"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	}

	function afficher_edition_materiel_recette()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv = "Content-Type" content="text / html; charset = utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2><?
$sql = "SELECT designation FROM mds_items_menu WHERE ID = ".$_GET["ID_item_menu"];
$result = mysql_query($sql,$this->lien_mysql);
$row = mysql_fetch_array($result);
$designation =  $row["designation"];

echo $designation;				
?></h2>

			<form method="post" action="page_perso.php">
				<p class="champs_centres">
<?
				$ID_article = $_GET["ID_article"];
				$ID_article = mysql_real_escape_string($ID_article);
				$sql ="SELECT ldc_articles.designation, mds_materiel.quantite, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, mds_materiel.ID_article as ID_article FROM `mds_materiel` LEFT JOIN ldc_articles ON mds_materiel.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE mds_materiel.ID_item_menu = ".$_GET["ID_item_menu"]." AND ldc_articles.ID = ".$ID_article;

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$designation =  stripslashes($row["designation"]);

?>
				<input type="hidden" name="commande" value="modifier_materiel_recette"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input class="champ" name="nouvelle_designation" value="<? echo $designation; ?>" type="text">
				<input class="champ" name="nouvelle_quantite" value="<? echo $row["quantite"]."\""; 
			if ($row["unite"] == "litre(s)")
			{
				echo " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				echo " step='0.01'";
			};
?> type="number">
				<input class="champ" name="nouvelle_unite" value="<? echo $row["unite"]; ?>" type="text">
				<? echo $this->composition_select_rayons($row["ID_rayon"]) ?>
				<input class="bouton" type="submit" value="Modifier l'article">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="confirmer_suppression_materiel_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $ID_article ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="editer_item_menu"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	}

	function afficher_edition_rayon()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv = "Content-Type" content="text / html; charset = utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Liste de courses</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un rayon</h2>

			<form method="post" action="page_perso.php">
				<p class="champs_centres">
<?
				$ID_rayon = $_GET["ID_rayon"];
				$ID_rayon = mysql_real_escape_string($ID_rayon);
				$sql ="SELECT ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon FROM ldc_rayons WHERE ldc_rayons.ID = ".$ID_rayon;

	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$rayon =  $row["rayon"];

?>
				<input type="hidden" name="commande" value="modifier_rayon"/>
				<input type="hidden" name="ID_rayon" value="<? echo $ID_rayon ?>"/>
				<input class="champ" name="nouvelle_designation" value="<? echo $rayon; ?>" type="text">
				<input class="bouton" type="submit" value="Modifier le rayon">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="confirmer_suppression_rayon"/>
				<input type="hidden" name="ID_rayon" value="<? echo $ID_rayon ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer le rayon de la base">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="editer_les_rayons"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	}

	function confirmer_suppression_article()
	{
		$sql = "SELECT ldc_articles.designation FROM ldc_articles WHERE ID = ".$_GET["ID_article"];
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Liste de courses</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un article</h2>

				<p class="champs_centres">
				Confirmer la suppression de l'article <? echo $row["designation"]; ?> ?
				</p>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="supprimer_article"/>
				<input type="hidden" name="ID_article" value="<? echo $_GET["ID_article"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base ">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_edition_article"/>
				<input type="hidden" name="ID_article" value="<? echo $_GET["ID_article"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>		
<?
	}
	
	function confirmer_suppression_article_recette()
	{
		$sql = "SELECT ldc_articles.designation FROM ldc_articles WHERE ID = ".$_REQUEST["ID_article"];
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un article</h2>

				<p class="champs_centres">
				Confirmer la suppression de l'article <? echo $row["designation"]; ?> ?
				</p>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="supprimer_article_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $_REQUEST["ID_article"] ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base ">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_edition_article_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $_REQUEST["ID_article"] ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>		
<?
	}
	
	function confirmer_suppression_materiel_recette()
	{
		$sql = "SELECT ldc_articles.designation FROM ldc_articles WHERE ID = ".$_REQUEST["ID_article"];
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un article</h2>

				<p class="champs_centres">
				Confirmer la suppression de l'article <? echo $row["designation"]; ?> ?
				</p>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="supprimer_materiel_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $_REQUEST["ID_article"] ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer l'article de la base ">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_edition_materiel_recette"/>
				<input type="hidden" name="ID_article" value="<? echo $_REQUEST["ID_article"] ?>"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_REQUEST["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>		
<?
	}
	
	function confirmer_suppression_recette()
	{
		$sql = "SELECT mds_items_menu.designation FROM mds_items_menu WHERE ID = ".$_GET["ID_item_menu"];
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_des_recettes_modification_recette.css">
		<title>Liste des recettes</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste des recettes
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_recette">
				<h2>Edition d'une recette</h2>

				<p class="champs_centres">
				Confirmer la suppression de la recette <? echo $row["designation"]; ?> ?
				</p>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="supprimer_recette"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer la recette de la base">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="editer_item_menu"/>
				<input type="hidden" name="ID_item_menu" value="<? echo $_GET["ID_item_menu"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>		
<?
	}
	
	function confirmer_suppression_rayon()
	{
		$sql = "SELECT ldc_rayons.designation FROM ldc_rayons WHERE ID = ".$_GET["ID_rayon"];
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses_modification_article.css">
		<title>Liste de courses</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="modification_article">
				<h2>Edition d'un rayon</h2>

				<p class="champs_centres">
				Confirmer la suppression du rayon <? echo $row["designation"]; ?> ?
				</p>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="supprimer_rayon"/>
				<input type="hidden" name="ID_rayon" value="<? echo $_GET["ID_rayon"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Supprimer le rayon de la base ">
				</p>
			</form>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_edition_rayon"/>
				<input type="hidden" name="ID_rayon" value="<? echo $_GET["ID_rayon"] ?>"/>
				<input class="bouton_annuler" type="submit" value="Annuler">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>		
<?
	}
	
	
	function editer_les_rayons()
	{
?>	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_des_rayons.css">
		<title>Rayons</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste des rayons
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="ordre_des_rayons">
			<h2>Ordre des rayons
			</h2>
			<ol>
<?
//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, ldc_rayons.ordre as ordre FROM ldc_rayons ORDER BY ordre";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0)
	{
		$texte_liste = "";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<li><span class=\"etiquette_rayon\"><a id=\"ID_rayon_".$row["ID_rayon"]."\"><a href=\"page_perso.php?commande=afficher_edition_rayon&ID_rayon=".$row["ID_rayon"]."\">".$row["rayon"]."</a></span><div class=\"boutons_haut_bas\">";
			if ($i <> 0)
			{
				$texte_liste .= "<form action=\"page_perso.php#ID_rayon_".$row["ID_rayon"]."\" method=\"POST\"><input type=\"hidden\" name=\"commande\" value=\"remonter_liste_rayon\"><input type=\"hidden\" name=\"nouveau_numero_ordre\" value=\"".($i - 1)."\"><input name=\"ID_rayon\" value=\"".$row["ID_rayon"]."\" type=\"hidden\"><button class=\"bouton_avant\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" > <g     inkscape:label=\"Calque 1\"     inkscape:groupmode=\"layer\"     id=\"layer1\"     transform=\"translate(0,-1022.3621)\">    <path   class=\"fill\"       d=\"m 5.142053,1050.4403 20,0 0,-10 5,0 -15,-15 -15.00000011,15 5.00000011,0 z\"       id=\"path4167\"       inkscape:connector-curvature=\"0\" />  </g></svg></button></form>";
			};
			if ($i <> mysql_num_rows($result) - 1)
			{
				$texte_liste .= "<form action=\"page_perso.php#ID_rayon_".$row["ID_rayon"]."\" method=\"POST\"><input type=\"hidden\" name=\"commande\" value=\"redescendre_liste_rayon\"><input type=\"hidden\" name=\"nouveau_numero_ordre\" value=\"".($i + 1)."\"><input name=\"ID_rayon\" value=\"".$row["ID_rayon"]."\" type=\"hidden\"><button class=\"bouton_apres\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\"  >    <g     inkscape:label=\"Calque 1\"     inkscape:groupmode=\"layer\"     id=\"layer1\"     transform=\"translate(0,-1022.3621)\">    <path  class=\"fill\"      d=\"m 5.142053,1025.4403 20,0 0,10 5,0 -15,15 -15.00000011,-15 5.00000011,0 z\"       />  </g></svg></button></form>";
			};
			$texte_liste .= "</div></li>";
		};	
		echo $texte_liste;
	}
				?>
			<form action="page_perso.php">
				<p class="champs_centres">
				<input type="hidden" name="commande" value="afficher_liste_de_courses">
				<input class="bouton_annuler" type="submit" value="Quitter">
				</p>
			</form>
		</div>
		<div class="ajout_article_a_la_liste">
			<h2>Ajouter un rayon</h2>
			<form action="page_perso.php">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_rayon">
					<input class="champ" name="designation_nouveau_rayon" value="" placeholder="Entrez la dÃ©signation du rayon" type="text">
					<input class="bouton" type="submit" value="Ajouter">
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?	
	}

	function afficher_page_authentication()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/authentification.css">
		<title>Authentification</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Authentification
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="authentification">
			<form action="page_perso.php" method="POST">
				<h2>Merci de saisir les informations suivantes :</h2>
				<h3>Pseudo</h3>
				<p>
					<label for="pseudo">Pseudo</label>
					<input class="champ" type="text" name="pseudo">
				</p>
				<h3>Mot de passe</h3>
				<p>
					<label for="motdepasse">Mot de passe</label>
					<input class="champ" type="password" name="motdepasse">
				</p>
			<p>
				<input class="bouton" type="submit" value="S'identifier">
			</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?
	}

	function afficher_liste_de_courses()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_de_courses.css">
		<title>Liste de courses</title>
</head>

<body><?
//		echo "<div id=\"avancement_course\"><p>Avancement des courses : ".$this->affiche_jauge()."</p></div>";
		echo "<div id=\"avancement_course\">".$this->affiche_jauge()."</div>";
?>

	<div class="grid">
		<div class="titre">
			<h1>Liste de courses
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=imprimer_liste_de_courses">Imprimer</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="liste_de_courses">
				<? echo $this->composition_liste(); ?>
		</div>
		<div ID="ajout_article_a_la_liste" class="ajout_article_a_la_liste">
				<h2>Ajouter un article &agrave; la liste</h2>
				<? echo $this->composition_liste_articles_a_ajouter()
?>
		</div>
		<div class="fin_des_courses">
			<h2>Fin des courses</h2>
			<form>
			<input type="hidden" name="commande" value="supprimer_articles_barres"/>
				<p class="champs_centres">
						<input class="bouton" type="submit" value="Supprimer les articles barr&eacute;s !"/>	
				</p>
			</form>
		</div>
		<div class="parametres">
			<h2>Param&egrave;tres</h2>
			<form action="page_perso.php">
			<input type="hidden" name="commande" value="editer_les_rayons"/>
				<p class="champs_centres">
						<input class="bouton" type="submit" value="Editer les rayons"/>	
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?
	}
	
	function afficher_menu_de_la_semaine()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/menu_de_la_semaine.css">
		<title>Menu de la semaine</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Menu de la semaine
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=completer_liste_de_courses_depuis_menu">ComplÃ©ter la liste de courses</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="selection_jour">
				<h2>SÃ©lection du premier jour de la semaine</h2>
				<form method="POST" action="page_perso.php">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="afficher_menu_de_la_semaine">
					<input class="champ" type="date" name="date_premier_jour_semaine" value="<?
					if (isset($_POST["date_premier_jour_semaine"]))
					{
						echo $_POST["date_premier_jour_semaine"];
					}
					else
					{
						echo date("Y-m-d");
					};?>">
					<input class="bouton" type="submit" value="Afficher">
				</p>
				</form>
		</div>
<?
			if ((!isset($_POST["date_premier_jour_semaine"])) OR ($_POST["date_premier_jour_semaine"] == ""))
			{
				$date_premier_jour_semaine = date("Y-m-d");
			}
			else
			{
				$date_premier_jour_semaine = $_POST["date_premier_jour_semaine"];
			};

			for ($i = 0; $i < 7; $i++)
			{
				$j = substr($date_premier_jour_semaine,8,2);
				$m = substr($date_premier_jour_semaine,5,2);
				$a = substr($date_premier_jour_semaine,0,4);
				
				echo "<div class=\"jour".($i + 1)."\">";
				echo "<h2>".$this->jour_semaine(date("w", (mktime(0, 0, 0, $m, ($j+$i), $a))))."</h2>";
				echo "<ul><li><a class=\"bouton\" href=\"page_perso.php?commande=edition_menu_jour&jour=".date("Y-m-d", (mktime(0, 0, 0, $m, ($j+$i), $a)))."\">Editer</a></li></ul>";
				echo "<p>".date("d/m/Y",(mktime(0, 0, 0, $m, ($j+$i), $a)))."</p>";
				
				$sql = "SELECT mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.ID, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, ($j+$i), $a)))."' ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<p><em>Aucun repas prÃ©vu</em></p>";
				}
				else
				{
					$type_repas = 100;
					$fermeture_liste = false;
					
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID_item_menu = $row["ID"];
		
						if ($this->texte_type_repas($type_repas) <> $this->texte_type_repas($type_repas_base))
						{
							if ($fermeture_liste OR ($j == (mysql_num_rows($result) - 1)))
							{
								echo "</ul>";
							};
							echo "<h3>".$this->texte_type_repas($type_repas_base)."</h3><ul>";
							$type_repas = $type_repas_base;
							$fermeture_liste = true;
						};
						
						echo "<li><a href=\"page_perso.php?commande=detail_item_menu&ID_item_menu=".$ID_item_menu."\">".$designation."</a></li>";
					};
				};
				
				echo "</ul></div>";
			};
	
?>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>
<?
	}
	
	function edition_menu_jour()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/edition_menu_jour.css">
		<title>Menu de la semaine</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition du menu
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="jour_edite">
<?
			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

			echo "<h2>".$this->jour_semaine(date("w", (mktime(0, 0, 0, $m, ($j+$i), $a))))."</h2><p class=\"champs_centres\">";
			echo date("d/m/Y", mktime(0,0,0,$m,$j,$a));
?>
				</p>
				<a id="petit_dejeuner"></a>
				<h3>Petit d&eacute;jeuner</h3>
<?

			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

				$sql = "SELECT mds_repas_prevus.ID, mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, $j, $a)))."' AND type_repas BETWEEN 0 AND 1 ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<ul><li><span class=\"etiquette_recette\"><em>Aucun repas prÃ©vu</em></span></li></ul>";
				}
				else
				{

			echo "<ul>";
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID = $row["ID"];

						echo "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php#petit_dejeuner\"><input type=\"hidden\" name=\"commande\" value=\"retirer_item_menu\"><input type=\"hidden\" name=\"jour\" value=\"".$jour."\"><input name=\"ID\" value=\"".$ID."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
					};
			echo "</ul>";
				};
?>				
				<form method="POST" action="page_perso.php#petit_dejeuner">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_item_menu_au_menu">
					<input type="hidden" name="type_repas" value="0">
<?
				echo "<input type=\"hidden\" name=\"date\" value=".$jour.">";
				echo "<input type=\"hidden\" name=\"jour\" value=".$jour.">";
?>
					<input class="champ" name="designation_nouvel_item_menu_petit_dejeuner" list="designations_item_menu_petit_dejeuner" placeholder="Entrer la dÃ©signation">
					<datalist id="designations_item_menu_petit_dejeuner">
<?
				$sql = "SELECT mds_items_menu_types_repas.ID_type_repas, mds_items_menu.designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas BETWEEN 0 AND 1 ORDER BY mds_items_menu.designation";

	
				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<option value=\"Aucun item dans la base\">";
				}
				else
				{
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$designation = $row["designation"];

						echo "<option value=\"".$designation."\">";
					};
				};

?>
					</datalist>
					<input class="bouton" type="submit" value="Ajouter">
				</p>
				</form>
				<a id="dejeuner"></a>
				<h3>D&eacute;jeuner</h3>
<?

			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

				$sql = "SELECT mds_repas_prevus.ID, mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, $j, $a)))."' AND type_repas BETWEEN 2 AND 6 ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<ul><li><span class=\"etiquette_recette\"><em>Aucun repas prÃ©vu</em></span></li></ul>";
				}
				else
				{

			echo "<ul>";
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID = $row["ID"];

						echo "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php#dejeuner\"><input type=\"hidden\" name=\"commande\" value=\"retirer_item_menu\"><input type=\"hidden\" name=\"jour\" value=\"".$jour."\"><input name=\"ID\" value=\"".$ID."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
					};
			echo "</ul>";
				};
?>				
				<form method="POST" action="page_perso.php#dejeuner">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_item_menu_au_menu">
					<input type="hidden" name="type_repas" value="2">
<?
				echo "<input type=\"hidden\" name=\"date\" value=".$jour.">";
				echo "<input type=\"hidden\" name=\"jour\" value=".$jour.">";
?>
					<input class="champ" name="designation_nouvel_item_menu_dejeuner" list="designations_item_menu_dejeuner" placeholder="Entrer la dÃ©signation">
					<datalist id="designations_item_menu_dejeuner">
<?
				$sql = "SELECT mds_items_menu_types_repas.ID_type_repas, mds_items_menu.designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas BETWEEN 2 AND 6 ORDER BY mds_items_menu.designation";

				
				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<option value=\"Aucun item dans la base\">";
				}
				else
				{
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$designation = $row["designation"];

						echo "<option value=\"".$designation."\">";
					};
				};

?>
					</datalist>
					<input class="bouton" type="submit" value="Ajouter">
				</p>
				</form>
				<a id="gouter"></a>
				<h3>GoÃ»ter</h3>
<?

			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

				$sql = "SELECT mds_repas_prevus.ID, mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, $j, $a)))."' AND type_repas BETWEEN 7 AND 8 ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<ul><li><span class=\"etiquette_recette\"><em>Aucun repas prÃ©vu</em></span></li></ul>";
				}
				else
				{

			echo "<ul>";
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID = $row["ID"];

						echo "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php#gouter\"><input type=\"hidden\" name=\"commande\" value=\"retirer_item_menu\"><input type=\"hidden\" name=\"jour\" value=\"".$jour."\"><input name=\"ID\" value=\"".$ID."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
					};
			echo "</ul>";
				};
?>				
				<form method="POST" action="page_perso.php#gouter">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_item_menu_au_menu">
					<input type="hidden" name="type_repas" value="7">
<?
				echo "<input type=\"hidden\" name=\"date\" value=".$jour.">";
				echo "<input type=\"hidden\" name=\"jour\" value=".$jour.">";
?>

					<input class="champ" name="designation_nouvel_item_menu_gouter" list="designations_item_menu_gouter" placeholder="Entrer la dÃ©signation">
					<datalist id="designations_item_menu_gouter">
<?
				$sql = "SELECT mds_items_menu_types_repas.ID_type_repas, mds_items_menu.designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas BETWEEN 7 AND 8 ORDER BY mds_items_menu.designation";

				
				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<option value=\"Aucun item dans la base\">";
				}
				else
				{
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$designation = $row["designation"];

						echo "<option value=\"".$designation."\">";
					};
				};

?>
					</datalist>
					<input class="bouton" type="submit" value="Ajouter">
				</p>
				</form>
				<a id="diner"></a>
				<h3>DÃ®ner</h3>
<?

			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

				$sql = "SELECT mds_repas_prevus.ID, mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, $j, $a)))."' AND type_repas BETWEEN 9 AND 13 ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<ul><li><span class=\"etiquette_recette\"><em>Aucun repas prÃ©vu</em></span></li></ul>";
				}
				else
				{

			echo "<ul>";
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID = $row["ID"];

						echo "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php#diner\"><input type=\"hidden\" name=\"commande\" value=\"retirer_item_menu\"><input type=\"hidden\" name=\"jour\" value=\"".$jour."\"><input name=\"ID\" value=\"".$ID."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
					};
			echo "</ul>";
				};
?>				
				<form method="POST" action="page_perso.php#diner">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_item_menu_au_menu">
					<input type="hidden" name="type_repas" value="9">
<?
				echo "<input type=\"hidden\" name=\"date\" value=".$jour.">";
				echo "<input type=\"hidden\" name=\"jour\" value=".$jour.">";
?>

					<input class="champ" name="designation_nouvel_item_menu_diner" list="designations_item_menu_diner" placeholder="Entrer la dÃ©signation">
					<datalist id="designations_item_menu_diner">
<?
				$sql = "SELECT mds_items_menu_types_repas.ID_type_repas, mds_items_menu.designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas BETWEEN 9 AND 13 ORDER BY mds_items_menu.designation";

				
				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<option value=\"Aucun item dans la base\">";
				}
				else
				{
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$designation = $row["designation"];

						echo "<option value=\"".$designation."\">";
					};
				};

?>
					</datalist>
					<input class="bouton" type="submit" value="Ajouter">
				</p>
				</form>
				<a id="encas"></a>
				<h3>Encas</h3>
<?

			if ((!isset($_REQUEST["jour"])) OR ($_REQUEST["jour"] == ""))
			{
				$jour = date("Y-m-d");
			}
			else
			{
				$jour = $_REQUEST["jour"];
			};

				$j = substr($jour,8,2);
				$m = substr($jour,5,2);
				$a = substr($jour,0,4);

				$sql = "SELECT mds_repas_prevus.ID, mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation FROM mds_repas_prevus LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_repas_prevus.item_menu WHERE mds_repas_prevus.date = '".date("Y-m-d",(mktime(0, 0, 0, $m, $j, $a)))."' AND type_repas = 14 ORDER BY mds_repas_prevus.date, mds_repas_prevus.type_repas, mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<ul><li><span class=\"etiquette_recette\"><em>Aucun repas prÃ©vu</em></span></li></ul>";
				}
				else
				{

			echo "<ul>";
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$type_repas_base = $row["type_repas"];
						$designation = $row["designation"];
						$ID = $row["ID"];

						echo "<li><span class=\"etiquette_recette\">".$designation."</span><form method=\"POST\" action=\"page_perso.php#encas\"><input type=\"hidden\" name=\"commande\" value=\"retirer_item_menu\"><input type=\"hidden\" name=\"jour\" value=\"".$jour."\"><input name=\"ID\" value=\"".$ID."\" type=\"hidden\"><button class=\"bouton_NOK\" type=\"submit\"><svg width=\"30\"   height=\"30\"   viewBox=\"0 0 30 30\" >   <g inkscape:label=\"Calque 1\" inkscape:groupmode=\"layer\" id=\"layer1\" transform=\"translate(0,-1022.3621)\">    <path class=\"fill\" d=\"m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z\" id=\"path4159\" inkscape:connector-curvature=\"0\" sodipodi:nodetypes=\"ccccccccc\" /> </g></svg></button></form></li>";
					};
			echo "</ul>";
				};
?>				
				<form method="POST" action="page_perso.php#encas">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="ajouter_item_menu_au_menu">
					<input type="hidden" name="type_repas" value="14">
<?
				echo "<input type=\"hidden\" name=\"date\" value=".$jour.">";
				echo "<input type=\"hidden\" name=\"jour\" value=".$jour.">";
?>

					<input class="champ" name="designation_nouvel_item_menu_encas" list="designations_item_menu_encas" placeholder="Entrer la dÃ©signation">
					<datalist id="designations_item_menu_encas">
<?
				$sql = "SELECT mds_items_menu_types_repas.ID_type_repas, mds_items_menu.designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas = 14 ORDER BY mds_items_menu.designation";

				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<option value=\"Aucun item dans la base\">";
				}
				else
				{
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$designation = $row["designation"];

						echo "<option value=\"".$designation."\">";
					};
				};

?>
					</datalist>
					<input class="bouton" type="submit" value="Ajouter">
				</p>
				</form>
		</div>
		<div class="selection_jour">
				<h2>SÃ©lection du jour</h2>
				<form method="POST" action="page_perso.php">
				<p class="champs_centres">
					<input type="hidden" name="commande" value="edition_menu_jour">
					<input class="champ" name="jour" type="date" value="<? echo $jour;?>">
					<input class="bouton" type="submit" value="Editer">
				</p>
				</form>
		</div>
		<div class="pied_de_page">
		</div>
	</div>
</body>
</html>
<?		
	}
	
	
	function jour_semaine($n)
	{
			switch($n)
			{
				case 0 :
					return "Dimanche";
					break;
				case 1 :
					return "Lundi";
					break;
				case 2 :
					return "Mardi";
					break;
				case 3 :
					return "Mercredi";
					break;
				case 4 :
					return "Jeudi";
					break;
				case 5 :
					return "Vendredi";
					break;
				case 6 :
					return "Samedi";
					break;
			};
	}
	
	function texte_type_repas($type_repas)
	{
			switch($type_repas)
			{
				case 0 :
					return "Petit dÃ©jeuner";
					break;
				case 1 :
					return "Petit dÃ©jeuner";
					break;
				case 2 :
					return "DÃ©jeuner";
					break;
				case 3 :
					return "DÃ©jeuner";
					break;
				case 4 :
					return "DÃ©jeuner";
					break;
				case 5 :
					return "DÃ©jeuner";
					break;
				case 6 :
					return "DÃ©jeuner";
					break;
				case 7 :
					return "GoÃ»ter";
					break;
				case 8 :
					return "GoÃ»ter";
					break;
				case 9 :
					return "DÃ®ner";
					break;
				case 10 :
					return "DÃ®ner";
					break;
				case 11 :
					return "DÃ®ner";
					break;
				case 12 :
					return "DÃ®ner";
					break;
				case 13 :
					return "DÃ®ner";
					break;
				case 14 :
					return "Encas";
					break;
			};
	}
	
	function texte_type_repas_detaille($type_repas)
	{
			switch($type_repas)
			{
				case 0 :
					return "Petit dÃ©jeuner";
					break;
				case 1 :
					return "Petit dÃ©jeuner (boissons)";
					break;
				case 2 :
					return "DÃ©jeuner (entrÃ©e)";
					break;
				case 3 :
					return "DÃ©jeuner (plat de rÃ©sistance)";
					break;
				case 4 :
					return "DÃ©jeuner (boissons)";
					break;
				case 5 :
					return "DÃ©jeuner (fromage)";
					break;
				case 6 :
					return "DÃ©jeuner (dessert)";
					break;
				case 7 :
					return "GoÃ»ter";
					break;
				case 8 :
					return "GoÃ»ter (boissons)";
					break;
				case 9 :
					return "DÃ®ner (entrÃ©e)";
					break;
				case 10 :
					return "DÃ®ner (plat de rÃ©sistance)";
					break;
				case 11 :
					return "DÃ®ner (boissons)";
					break;
				case 12 :
					return "DÃ®ner (fromage)";
					break;
				case 13 :
					return "DÃ®ner (desserts)";
					break;
				case 14 :
					return "Encas";
					break;
			};
	}
	
	
	function afficher_liste_des_recettes()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/liste_des_recettes.css">
		<title>Liste des recettes</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Liste des recettes
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
<?
				$sql = "SELECT ID_item_menu, ID_type_repas, mds_types_repas.designation, mds_items_menu.designation as designation FROM mds_items_menu_types_repas LEFT JOIN mds_items_menu ON mds_items_menu_types_repas.ID_item_menu = mds_items_menu.ID LEFT JOIN mds_types_repas ON mds_items_menu_types_repas.ID_type_repas = mds_types_repas.ID"; 

				if (isset($_REQUEST["item_menu_recherche"]) AND ($_REQUEST["item_menu_recherche"]))
				{
					$item_menu_recherche = $_REQUEST["item_menu_recherche"];
					$sql .= " WHERE mds_items_menu.designation LIKE '%".$item_menu_recherche."%'";
				};

				$sql .= " ORDER BY ID_type_repas, mds_items_menu.designation";

				$sql_count = "SELECT COUNT(*) FROM mds_items_menu WHERE mds_items_menu.designation LIKE '%".$item_menu_recherche."%'";

				$result_count = mysql_query($sql_count,$this->lien_mysql);
				$row = mysql_fetch_array($result_count);
				$count = $row["COUNT(*)"];
				
?>
		<div class="liste_des_recettes">
				<h2>Liste des Ã©lÃ©ments de menu<? if (isset($item_menu_recherche)){echo " (".$item_menu_recherche.")";}; echo " (".$count.")";?></h2>
				<form>
				<input type="hidden" name="commande" value="afficher_liste_des_recettes"/>
					<p class="champs_centres">
						<input class="champ" name="item_menu_recherche" placeholder="Nom de la recette" type="text">
						<input class="bouton" type="submit" value="Filtrer les recettes"/>	
					</p>
				</form>
<?
		$sql1 = "SELECT * FROM mds_items_menu LEFT JOIN mds_items_menu_types_repas ON mds_items_menu.ID = mds_items_menu_types_repas.ID_item_menu WHERE ID_type_repas IS NULL AND mds_items_menu.designation LIKE '%".$item_menu_recherche."%' ORDER BY designation";
		
		
		$result1 = mysql_query($sql1,$this->lien_mysql);
				if(mysql_num_rows($result1) == 0)
				{
//					echo "<p><em>Aucun item dans la base</em></p>";
				}
				else
				{
					$liste_recettes_sans_categorie = "<h3>Sans categorie</h3><ul>";
					for ( $k = 0; $k < mysql_num_rows($result1); $k++)
					{
						$row = mysql_fetch_array($result1);
						$designation = $row["designation"];
						$ID_item_menu = $row["ID"];
						$liste_recettes_sans_categorie .= "<li><span class=\"etiquette_recette\"><a href=\"page_perso.php?commande=detail_item_menu&ID_item_menu=".$ID_item_menu."\">".$designation."</a></span></li>";
					};
					echo $liste_recettes_sans_categorie."</ul>";
				};


				$result = mysql_query($sql,$this->lien_mysql);

				if(mysql_num_rows($result) == 0)
				{
					echo "<p><em>Aucun item dans la base</em></p>";
				}
				else
				{
					$type_repas = 100;
					$fermeture_liste = false;
					
					for ( $j = 0; $j < mysql_num_rows($result); $j++)
					{
						$row = mysql_fetch_array($result);
						$ID_item_menu = $row["ID_item_menu"];
						$type_repas_base = $row["ID_type_repas"];
						$designation = $row["designation"];
		
						if ($this->texte_type_repas_detaille($type_repas) <> $this->texte_type_repas_detaille($type_repas_base))
						{
							if ($fermeture_liste OR ($j == (mysql_num_rows($result) - 1)))
							{
								echo "</ul>";
							};
							echo "<h3>".$this->texte_type_repas_detaille($type_repas_base)."</h3><ul>";
							$type_repas = $type_repas_base;
							$fermeture_liste = true;
						};
						
						echo "<li><span class=\"etiquette_recette\"><a href=\"page_perso.php?commande=detail_item_menu&ID_item_menu=".$ID_item_menu."\">".$designation."</a></span></li>";
					};
				};
				
?>
		</div>
		<div class="ajout_recette_a_la_liste">
			<h2>Ajout d'une recette</h2>
			<form action="page_perso.php?commande=afficher_liste_des_recettes" method="POST">
				<p class="champs_centres">
					<input class="champ" name="nouvelle_recette" placeholder="Nouvelle recette" type="text">
					<input class="bouton" type="submit" value="Ajouter une recette"/>	
				</p>
			</form>
		</div>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>


<?	
	}

	function afficher_edition_etape_recette()
	{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initia-scale=1.0">
		<link rel="stylesheet" href="styles/edition_etape_recette.css">
		<title>Edition de la recette</title>
</head>

<body>

	<div class="grid">
		<div class="titre">
			<h1>Edition de la recette
			</h1>
		</div>
		<div class="entete">
		</div>
		<div class="menu">
			<ul>
				<li><a class="bouton" href="page_perso.php">Accueil</a>
				</li>
				<li><a class="bouton" href="page_perso.php?commande=afficher_menu_de_la_semaine">Menu de la semaine</a>
				</li>
				<li><a class="bouton_deco" href="page_perso.php?commande=deconnecter">Se d&eacute;connecter</a>
				</li>
			</ul>
		</div>
		<div class="liste_des_recettes">
			<h2>Etape <?echo $_GET["numero_instruction_editee"]?></h2>
			<form action="page_perso.php" method="POST">
<?
		$sql = "SELECT * FROM mds_instructions WHERE ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ordre = ".$_GET["numero_instruction_editee"];
		
//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$texte = $row["texte"];
		$commande = "modifier_etape_recette";
		$bouton = "Modifier l'Ã©tape";
	}
	else
	{
		$texte = "";
		$commande = "ajouter_etape_recette";
		$bouton = "Ajouter l'Ã©tape";
	};
?>
				<input type="hidden" name ="commande" value="<?echo $commande ?>" />
				<input type="hidden" name="numero_instruction_ajoutee" value="<?echo $_GET["numero_instruction_editee"]?>" />
				<input type="hidden" name="ID_item_menu" value="<?echo $_REQUEST["ID_item_menu"]?>" />
				<p class="champs_centres">
<?


					echo "<textarea name=\"texte_etape\" class=\"champ_texte\" rows=\"30\" cols=\"39\">".$texte."</textarea>"
?>					<input class="bouton" type="submit" value="<?echo $bouton ?>"/>	
				</p>
			</form>
			</div>
<?
	if ($commande == "modifier_etape_recette")
	{
?>
		<div class="suppression_de_l_etape">
				<h2>Suppression de l'Ã©tape</h2>
			<form action="page_perso.php" method="POST">
				<p class="champs_centres">
				<input type="hidden" name ="commande" value="supprimer_etape_recette" />
				<input type="hidden" name="numero_instruction_supprimee" value="<?echo $_GET["numero_instruction_editee"]?>" />
				<input type="hidden" name="ID_item_menu" value="<?echo $_REQUEST["ID_item_menu"]?>" />
					<input class="bouton_annuler" type="submit" value="Supprimer l'Ã©tape"/>
				</p>
			</form>
		</div>
<?
	};
?>
		<div class="pied_de_page"></div>
	</div>
</body>
</html>


<?	
	}
	
	function affiche_jauge()
	{
	
	//Compter les articles rayÃ©s
	$sql = "SELECT COUNT(*) as fait FROM ldc_liste WHERE checked = 1";
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$fait =  $row["fait"];
	//Compter le total des articles
	$sql = "SELECT COUNT(*) as total FROM ldc_liste";
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$total =  $row["total"];

		if ($total <> 0)
		{
			$jauge = '<meter min="0" max="'.$total.'" value="'.$fait.'">'.round(($fait / $total)*100).'%</meter>';
		}
		else
		{
			$jauge = "";
		}
		return $jauge;
	}
	
	function composition_liste()
	{

//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_articles.designation, ldc_liste.quantite, ldc_liste.checked, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, ldc_liste.ID_article as ID_article FROM `ldc_liste` LEFT JOIN ldc_articles ON ldc_liste.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID ORDER BY ldc_rayons.ordre, ldc_articles.designation";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$ID_rayon = 0;
	if(mysql_num_rows($result)>0) {
		$texte_liste = "<h2>Liste dans l'ordre des rayons (".mysql_num_rows($result)." entr&eacute;e(s))</h2><ul>";
//		$texte_liste .= "<div id=\"avancement_course\"><p>Avancement des courses : ".$this->affiche_jauge()."</p></div>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			if ($ID_rayon <> $row["ID_rayon"])
			{
				$texte_liste .= "<h3>".htmlentities($row["rayon"], ENT_QUOTES, "UTF-8")."</h3>";
				$ID_rayon = $row["ID_rayon"];
			};
			$texte_liste .= "<li><a id='ID_article_".$row["ID_article"]."'></a><span class=\"etiquette_article\"><a href=\"page_perso.php?commande=afficher_edition_article&ID_article=".$row["ID_article"]."\">";
			if ($row["checked"] == 1)
			{
				$texte_liste .= "<del>";
			};
			$texte_liste .= htmlentities(stripslashes($row["designation"]), ENT_QUOTES, "UTF-8");
			$texte_liste .= " : ".$row["quantite"]." ".htmlentities(stripslashes($row["unite"]), ENT_QUOTES, "UTF-8");
			if ($row["checked"] == 1)
			{
			$texte_liste .= "</del>";
			};
			$texte_liste .= "</a></span><form action='page_perso.php?commande=afficher_liste_de_courses#ID_article_".$row["ID_article"]."' method='POST'>";
			if ($row["checked"] == 1)
			{
				$texte_liste .= "<input type='hidden' name='ID_article_not_checked' value='".$row["ID_article"]."'><button class='bouton_NOK' type='submit'><svg width='30'   height='30'   viewBox='0 0 30 30' >   <g inkscape:label='Calque 1' inkscape:groupmode='layer' id='layer1' transform='translate(0,-1022.3621)'>    <path class='fill' d='m 3.8737309,1034.9608 8.6741751,3.9898 14.26269,-9.894 -11.26269,12.6516 4.969542,8.717 -8.295367,-5.9064 -8.1894041,5.7678 5.8838835,-8.6517 z' id='path4159' inkscape:connector-curvature='0' sodipodi:nodetypes='ccccccccc' />  </g></svg></button>";
			}
			else
			{
				$texte_liste .= " <input type='hidden' name='ID_article_checked' value='".$row["ID_article"]."'><button class='bouton_OK' type='submit'><svg width='30'   height='30'   viewBox='0 0 30 30' > <g          inkscape:label='Calque 1' inkscape:groupmode='layer' id='layer1' transform='translate(0,-1022.3621)'>>    <path class='fill' d='m 4,1037.3621 8,13 c 0,0 2,-7 7,-13.5581 2.768286,-3.6309 7.873731,-8.3134 7.873731,-8.3134 0,0 -5.747985,2.8265 -9.484771,7.124 -2.38896,2.7475 -6.325825,7.7903 -6.325825,7.7903 z' id='path4143' inkscape:connector-curvature='0' sodipodi:nodetypes='ccscscc' />  </g></svg></button>";
			};
			$texte_liste .= "</form></li>";
		};
		$texte_liste .= "</ul>";
//		$texte_liste .= "<p>Avancement des courses : ".$this->affiche_jauge()."</p>";
		return $texte_liste;
	} else {
		return "<h2>Liste de courses</h2><p><em>La liste de courses est vide !</em></p>";
	}
}

	function composition_datalist_articles()
	{

//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_articles.designation FROM `ldc_articles` ORDER BY ldc_articles.designation ASC";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$ID_rayon = 0;
	if(mysql_num_rows($result)>0) {
		$texte_liste = "<datalist id='designations_articles'>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<option value=\"".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))."\">";
		};
		$texte_liste .= "</datalist>";
		return $texte_liste;
	} else {
		return "Aucun article dans la base";
	}
}

	function composition_select_types_repas()
	{

//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ID, designation FROM `mds_types_repas` ORDER BY ID ASC";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$ID_rayon = 0;
	if(mysql_num_rows($result)>0) {
		$texte_liste = "<select class='champ' name='type_repas_ajoute'>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<option value=\"".$row["ID"]."\">".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))."</option>";
		};
		$texte_liste .= "</select>";
		return $texte_liste;
	} else {
		return "Aucun type de repas dans la base";
	}
}

	function composition_select_rayons($ID_rayon_selectionne)
	{

//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_rayons.ID, ldc_rayons.designation, ldc_rayons.ordre FROM `ldc_rayons` ORDER BY ldc_rayons.ordre ASC";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$ID_rayon = 0;
	if(mysql_num_rows($result)>0) {
		$texte_liste = "<select class=\"champ\" name=\"ID_rayon\">";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<option value=\"".stripslashes(htmlentities($row["ID"], ENT_QUOTES, "UTF-8"))."\" ";
			if ($row["ID"] == $ID_rayon_selectionne)
			{
				$texte_liste .= "selected";
			}
			$texte_liste .= ">".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))."</option>";
		};
		$texte_liste .= "</select>";
		return $texte_liste;
	} else {
		return "Aucun article dans la base";
	}
}

	function supprimer_articles_barres()
	{
		$sql = "DELETE FROM ldc_liste WHERE checked = 1";

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		
	}

	function supprimer_article()
	{
		$sql = "DELETE FROM ldc_liste WHERE ID_article = ".$_GET["ID_article"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_recettes WHERE ID_article = ".$_GET["ID_article"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_materiel WHERE ID_article = ".$_GET["ID_article"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM ldc_articles WHERE ID = ".$_GET["ID_article"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		
	}
	
	function retirer_type_repas()
	{
		$sql = "DELETE FROM mds_items_menu_types_repas WHERE ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ID_type_repas = ".$_REQUEST["ID_type_repas"];
		
		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

	}
	
	function supprimer_recette()
	{
		$sql = "DELETE FROM mds_repas_prevus WHERE item_menu = ".$_GET["ID_item_menu"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_recettes WHERE ID_item_menu = ".$_GET["ID_item_menu"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_items_menu_types_repas WHERE ID_item_menu = ".$_GET["ID_item_menu"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_items_menu WHERE ID = ".$_GET["ID_item_menu"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

		$sql = "DELETE FROM mds_instructions WHERE ID_item_menu = ".$_GET["ID_item_menu"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		
	}
	
	
	function supprimer_rayon()
	{
		
		$sql = "DELETE FROM ldc_rayons WHERE ID = ".$_GET["ID_rayon"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

	}
	
	function retirer_item_menu()
	{
		$sql = "DELETE FROM mds_repas_prevus WHERE ID = ".$_REQUEST["ID"];

		//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		

	}
	
	function remonter_liste_rayon()
	{
		$nouveau_numero_ordre = $_POST["nouveau_numero_ordre"];
		$ID_rayon = $_POST["ID_rayon"];
		
		$sql = "UPDATE ldc_rayons SET ordre = '".($nouveau_numero_ordre + 1)."' WHERE ordre = ".$nouveau_numero_ordre;
		
		$result = mysql_query($sql,$this->lien_mysql);
		
		$sql = "UPDATE ldc_rayons SET ordre = '".$nouveau_numero_ordre."' WHERE ID = ".$ID_rayon;
		
		$result = mysql_query($sql,$this->lien_mysql);
		
	}
	
	function redescendre_liste_rayon()
	{
		$nouveau_numero_ordre = $_POST["nouveau_numero_ordre"];
		$ID_rayon = $_POST["ID_rayon"];
		
		$sql = "UPDATE ldc_rayons SET ordre = '".($nouveau_numero_ordre - 1)."' WHERE ordre = ".$nouveau_numero_ordre;
		
		$result = mysql_query($sql,$this->lien_mysql);
		
		$sql = "UPDATE ldc_rayons SET ordre = '".$nouveau_numero_ordre."' WHERE ID = ".$ID_rayon;
		
		$result = mysql_query($sql,$this->lien_mysql);
		
	}
	
	function modifier_article()
	{
		//RÃ©cupÃ©rer les informations associÃ©es Ã  l'ID_article
		$ID_article = $_POST["ID_article"];
		$ID_article = mysql_real_escape_string($ID_article);
		$sql ="SELECT ldc_articles.designation, ldc_liste.quantite, ldc_liste.checked, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, ldc_liste.ID_article as ID_article FROM `ldc_liste` LEFT JOIN ldc_articles ON ldc_liste.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE ldc_articles.ID = ".$ID_article." ORDER BY ldc_rayons.ordre, ldc_articles.designation";
		
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		$designation =  $row["designation"];
		$quantite =  $row["quantite"];
		$unite =  $row["unite"];
		$ID_rayon = $row["ID_rayon"];
		
		$nouvelle_designation = $_POST["nouvelle_designation"];
		$nouvelle_quantite = $_POST["nouvelle_quantite"];
		$nouvelle_unite = $_POST["nouvelle_unite"];
		$nouvel_ID_rayon = $_POST["ID_rayon"];

		if (($designation == $nouvelle_designation) AND ($quantite == $nouvelle_quantite) AND ($unite == $nouvelle_unite) AND ($ID_rayon == $nouvel_ID_rayon))
		{
			echo "Aucune modification apportÃ©e Ã  l'article.";
		}
		else
		{

			//Si la nouvelle quantitÃ© est de 0, supprimer l'article de la liste de courses
			if ($nouvelle_quantite == 0)
			{
				$sql = "DELETE  FROM ldc_liste WHERE ID_article = ".$ID_article;
				
				$result = mysql_query($sql,$this->lien_mysql);
				
			}
			else
			//Mettre Ã  jour la quantitÃ©
			{
				if ($quantite <> $nouvelle_quantite)
				{
					$sql = "UPDATE ldc_liste SET quantite = ".$nouvelle_quantite." WHERE ID_article = ".$ID_article;
					
					$result = mysql_query($sql,$this->lien_mysql);
				}
			}
		//Mettre Ã  jour la dÃ©signation, l'unitÃ© et le rayon
			$sql = "UPDATE ldc_articles SET designation = '".$nouvelle_designation."', unite = '".$nouvelle_unite."', ID_rayon = ".$nouvel_ID_rayon." WHERE ID = ".$ID_article;

			$result = mysql_query($sql,$this->lien_mysql);

		}
	}

	function modifier_article_recette()
	{
		//RÃ©cupÃ©rer les informations associÃ©es Ã  l'ID_article
		$ID_article = $_POST["ID_article"];
		$ID_article = mysql_real_escape_string($ID_article);
		$sql ="SELECT ldc_articles.designation, mds_recettes.quantite, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, mds_recettes.ID_article as ID_article FROM `mds_recettes` LEFT JOIN ldc_articles ON mds_recettes.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE mds_recettes.ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ldc_articles.ID = ".$ID_article;
		
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		$designation =  $row["designation"];
		$quantite =  $row["quantite"];
		$unite =  $row["unite"];
		$ID_rayon = $row["ID_rayon"];
		
		$nouvelle_designation = $_POST["nouvelle_designation"];
		$nouvelle_quantite = $_POST["nouvelle_quantite"];
		$nouvelle_unite = $_POST["nouvelle_unite"];
		$nouvel_ID_rayon = $_POST["ID_rayon"];

		if (($designation == $nouvelle_designation) AND ($quantite == $nouvelle_quantite) AND ($unite == $nouvelle_unite) AND ($ID_rayon == $nouvel_ID_rayon))
		{
			echo "Aucune modification apportÃ©e Ã  l'article.";
		}
		else
		{

			//Si la nouvelle quantitÃ© est de 0, supprimer l'article de la liste de courses
			if ($nouvelle_quantite == 0)
			{
			$sql = "DELETE  FROM mds_recettes WHERE ID_article = ".$ID_article." AND ID_item_menu = ".$_REQUEST["ID_item_menu"];
				
				$result = mysql_query($sql,$this->lien_mysql);
				
			}
			else
			//Mettre Ã  jour la quantitÃ©
			{
				if ($quantite <> $nouvelle_quantite)
				{
					$sql = "UPDATE mds_recettes SET quantite = ".$nouvelle_quantite." WHERE ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ID_article = ".$ID_article;
					
					$result = mysql_query($sql,$this->lien_mysql);
				}
			}
		//Mettre Ã  jour la dÃ©signation, l'unitÃ© et le rayon
			$sql = "UPDATE ldc_articles SET designation = '".$nouvelle_designation."', unite = '".$nouvelle_unite."', ID_rayon = ".$nouvel_ID_rayon." WHERE ID = ".$ID_article;

			$result = mysql_query($sql,$this->lien_mysql);

		}
	}

	function modifier_materiel_recette()
	{
		//RÃ©cupÃ©rer les informations associÃ©es Ã  l'ID_article
		$ID_article = $_POST["ID_article"];
		$ID_article = mysql_real_escape_string($ID_article);
		$sql ="SELECT ldc_articles.designation, mds_materiel.quantite, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, mds_materiel.ID_article as ID_article FROM `mds_materiel` LEFT JOIN ldc_articles ON mds_materiel.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID WHERE mds_materiel.ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ldc_articles.ID = ".$ID_article;
		
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		$designation =  $row["designation"];
		$quantite =  $row["quantite"];
		$unite =  $row["unite"];
		$ID_rayon = $row["ID_rayon"];
		
		$nouvelle_designation = $_POST["nouvelle_designation"];
		$nouvelle_quantite = $_POST["nouvelle_quantite"];
		$nouvelle_unite = $_POST["nouvelle_unite"];
		$nouvel_ID_rayon = $_POST["ID_rayon"];

		if (($designation == $nouvelle_designation) AND ($quantite == $nouvelle_quantite) AND ($unite == $nouvelle_unite) AND ($ID_rayon == $nouvel_ID_rayon))
		{
			echo "Aucune modification apportÃ©e Ã  l'article.";
		}
		else
		{

			//Si la nouvelle quantitÃ© est de 0, supprimer l'article de la liste de courses
			if ($nouvelle_quantite == 0)
			{
				$sql = "DELETE FROM mds_materiel WHERE ID_article = ".$ID_article." AND ID_item_menu = ".$_REQUEST["ID_item_menu"];
				
				$result = mysql_query($sql,$this->lien_mysql);
				
			}
			else
			//Mettre Ã  jour la quantitÃ©
			{
				if ($quantite <> $nouvelle_quantite)
				{
					$sql = "UPDATE mds_materiel SET quantite = ".$nouvelle_quantite." WHERE ID_item_menu = ".$_REQUEST["ID_item_menu"]." AND ID_article = ".$ID_article;
					
					$result = mysql_query($sql,$this->lien_mysql);
				}
			}
		//Mettre Ã  jour la dÃ©signation, l'unitÃ© et le rayon
			$sql = "UPDATE ldc_articles SET designation = '".$nouvelle_designation."', unite = '".$nouvelle_unite."', ID_rayon = ".$nouvel_ID_rayon." WHERE ID = ".$ID_article;

			$result = mysql_query($sql,$this->lien_mysql);

		}
	}

	function ajouter_rayon()
	{
//RÃ©cupÃ©ration du dernier numÃ©ro d'ordre
	$sql = "SELECT MAX(ordre) FROM ldc_rayons";
	
//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);
	$ordre =  $row["MAX(ordre)"];
		
//CrÃ©ation de la requÃªte SQL
	$sql = "INSERT INTO ldc_rayons VALUES ( NULL, '".$_GET['designation_nouveau_rayon']."', '".($ordre + 1)."')";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);


	}
	
	function ajouter_etape_recette()
	{

		
		if (isset($_POST["ID_item_menu"]))
		{
			$ID_item_menu = $_POST["ID_item_menu"];
		};

		if (isset($_POST["numero_instruction_ajoutee"]))
		{
			$numero_instruction_ajoutee = $_POST["numero_instruction_ajoutee"];
		};

		if (isset($_POST["texte_etape"]))
		{
			$texte_etape = $_POST["texte_etape"];
		};

//VÃ©rifier que l'entrÃ©e n'existe pas dÃ©jÃ 
	$sql = "SELECT * FROM mds_instructions WHERE ID_item_menu = ".$ID_item_menu." AND ordre = ".$numero_instruction_ajoutee."";
	
	$result = mysql_query($sql,$this->lien_mysql);

	if ((mysql_num_rows($result) == 0) AND (trim($texte_etape) <> ""))
	{
//CrÃ©ation de la requÃªte SQL
	$sql = "INSERT INTO mds_instructions VALUES ( ".$ID_item_menu.", ".$numero_instruction_ajoutee.", '".$texte_etape."')";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	};
	
	}
	
	function modifier_etape_recette()
	{

		
		if (isset($_POST["ID_item_menu"]))
		{
			$ID_item_menu = $_POST["ID_item_menu"];
		};

		if (isset($_POST["numero_instruction_ajoutee"]))
		{
			$numero_instruction_ajoutee = $_POST["numero_instruction_ajoutee"];
		};

		if (isset($_POST["texte_etape"]))
		{
			$texte_etape = $_POST["texte_etape"];
		};

if (trim($texte_etape) <> "")
{
//CrÃ©ation de la requÃªte SQL
	$sql = "UPDATE mds_instructions SET texte = '".$texte_etape."' WHERE ID_item_menu = ".$ID_item_menu." AND ordre = ".$numero_instruction_ajoutee;

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
};	
	}
	
	function supprimer_etape_recette()
	{

		
		if (isset($_POST["ID_item_menu"]))
		{
			$ID_item_menu = $_POST["ID_item_menu"];
		};

		if (isset($_POST["numero_instruction_supprimee"]))
		{
			$numero_instruction_supprimee = $_POST["numero_instruction_supprimee"];
		};

//CrÃ©ation de la requÃªte SQL
	$sql = "DELETE FROM mds_instructions WHERE ID_item_menu = ".$ID_item_menu." AND ordre = ".$numero_instruction_supprimee;

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	
//CrÃ©ation de la requÃªte SQL
	$sql = "UPDATE mds_instructions SET ordre = ordre - 1 WHERE ID_item_menu = ".$ID_item_menu." AND ordre > ".$numero_instruction_supprimee;

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	
	}
	
	function ajouter_item_menu_au_menu()
	{

		
		$date = mysql_real_escape_string($_POST["date"]);
		$type_repas = mysql_real_escape_string($_POST["type_repas"]);

		if (isset($_POST["designation_nouvel_item_menu_petit_dejeuner"]))
		{
			$designation_nouvel_item_menu = $_POST["designation_nouvel_item_menu_petit_dejeuner"];
		};

		if (isset($_POST["designation_nouvel_item_menu_dejeuner"]))
		{
			$designation_nouvel_item_menu = $_POST["designation_nouvel_item_menu_dejeuner"];
		};

		if (isset($_POST["designation_nouvel_item_menu_gouter"]))
		{
			$designation_nouvel_item_menu = $_POST["designation_nouvel_item_menu_gouter"];
		};

		if (isset($_POST["designation_nouvel_item_menu_diner"]))
		{
			$designation_nouvel_item_menu = $_POST["designation_nouvel_item_menu_diner"];
		};

		if (isset($_POST["designation_nouvel_item_menu_encas"]))
		{
			$designation_nouvel_item_menu = $_POST["designation_nouvel_item_menu_encas"];
		};

	$sql = "SELECT ID, ID_type_repas FROM mds_items_menu LEFT JOIN mds_items_menu_types_repas ON ID = ID_item_menu WHERE designation = '".$designation_nouvel_item_menu."' ORDER BY ID_type_repas";
	
	$result = mysql_query($sql,$this->lien_mysql);

	$match = 0;
	for ( $i = 0; $i < mysql_num_rows($result); $i++)
	{
	$row = mysql_fetch_array($result);
	$nouvel_item_menu = $row["ID"];
	$ID_type_repas = $row["ID_type_repas"];
	If (($match == 0)AND($ID_type_repas >= $type_repas))
		{
			$type_repas = $ID_type_repas;
			$match = 1;
		};
	};
		
//CrÃ©ation de la requÃªte SQL
	$sql = "INSERT INTO mds_repas_prevus VALUES ( NULL, '".$date."', ".$type_repas.", ".$nouvel_item_menu.")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
		
	}
	
	function modifier_rayon()
	{
		//RÃ©cupÃ©rer les informations associÃ©es Ã  l'ID_article
		$ID_rayon = $_POST["ID_rayon"];
		$ID_rayon = mysql_real_escape_string($ID_rayon);
		$sql ="SELECT ldc_rayons.designation FROM ldc_rayons WHERE ldc_rayons.ID = ".$ID_rayon;
		
		$result = mysql_query($sql,$this->lien_mysql);
		$row = mysql_fetch_array($result);
		$designation =  $row["designation"];
		
		$nouvelle_designation = $_POST["nouvelle_designation"];

		if ($designation == $nouvelle_designation) 
		{
			echo "Aucune modification apportÃ©e au rayon.";
		}
		else
		{

		//Mettre Ã  jour la dÃ©signation, l'unitÃ© et le rayon
			$sql = "UPDATE ldc_rayons SET designation = '".$nouvelle_designation."' WHERE ID = ".$ID_rayon;

			$result = mysql_query($sql,$this->lien_mysql);

		}
	}

	function mettre_a_jour_liste()
	{
if(isset($_POST['supprimer_articles_barres']))
	{
		$sql = "DELETE FROM ldc_liste WHERE checked = 1";

//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);		
	};
	
if(isset($_POST['ID_article_checked']))
{

	$sql = "SELECT checked FROM ldc_liste WHERE ID_article = ".$_POST['ID_article_checked'];

//Execution de la requÃªte SQL
		$result = mysql_query($sql,$lien_mysql);
		
	if(mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$checked = $row["checked"];
		};

	if($checked == 1)
	{
		echo "Quelqu'un a d&eacute;j&agrave; pris cet article !";
	}
	else
	{
		$sql = "UPDATE ldc_liste SET checked = 1 WHERE ID_article = ".$_POST['ID_article_checked'];
		
//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);
	};
};

if(isset($_POST['ID_article_not_checked']))
{
	$sql = "SELECT checked FROM ldc_liste WHERE ID_article = ".$_POST['ID_article_not_checked'];

//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);
		
	if(mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$checked = $row["checked"];
		};

	if($checked == 0)
	{
		echo "Quelqu'un a d&eacute;j&agrave; d&eacute;coch&eacute; cet article !";
	}
	else
	{
		$sql = "UPDATE ldc_liste SET checked = 0 WHERE ID_article = ".$_POST['ID_article_not_checked'];
		
//Execution de la requÃªte SQL
		$result = mysql_query($sql,$this->lien_mysql);
	};
	}	

	
if(isset($_POST['quantite_modifiee']))
{

//Suppression des articles avec une quantitÃ© de 0

	$sql = "";
	$premiere_entree = TRUE;
    foreach($_POST['quantite_modifiee'] as $ID_article => $quantite)
    {
		if (($quantite == 0) OR ($quantite == ""))
		{
			if ($premiere_entree == TRUE)
			{
				$sql = "DELETE  FROM ldc_liste WHERE (ID_article = ";
			}
			else
			{
				$sql .= " OR (ID_article = ";
			};
			$sql .= $ID_article.")";
			$premiere_entree = FALSE;
		};
    };

//Execution de la requÃªte SQL
	If ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
	};

//Modifier les quantitÃ©s des articles
    foreach($_POST['quantite_modifiee'] as $ID_article => $quantite)
    {
		if (($quantite <> "") OR ($quantite <> 0))
		{
			$sql = "UPDATE  ldc_liste SET quantite = ".$quantite." WHERE ID_article = ".$ID_article;
//Execution de la requÃªte SQL
			$result = mysql_query($sql,$this->lien_mysql);
		};
    };

};


// Ajouter les articles pour lesquels la quantitÃ© a Ã©tÃ© renseignÃ©e
if(isset($_POST['quantite_ajoutee']))
{
//VÃ©rifier qu'aucun article n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "";
	$premiere_entree = TRUE;
    foreach($_POST['quantite_ajoutee'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "SELECT * FROM ldc_liste WHERE (ID_article = ";
		}
		else
		{
			$sql .= " OR (ID_article = ";
		};
		$sql .= $ID_article.")";
		$premiere_entree = FALSE;
		};
    };

	If ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
		if(mysql_num_rows($result)>0) {
			return "Article d&eacute;ja saisi !";
		}
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "";
	$premiere_entree = TRUE;
	foreach($_POST['quantite_ajoutee'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "INSERT  INTO ldc_liste VALUES ";
		}
		else
		{
			$sql .= ", ";
		};
		$sql .= "(NULL, '".$quantite."', '".$ID_article."', 0)";
		$premiere_entree = FALSE;
		};
    };

//Execution de la requÃªte SQL
	if ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
	};
};

//Ajouter un article Ã  la base de donnÃ©es et Ã  la liste en mÃªme temps
	if (isset($_POST['nouvel_article']) AND isset($_POST['quantite_nouvel_article']) AND isset($_POST['unite_nouvel_article']))
	{
//VÃ©rifier qu'aucun article n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "SELECT ID FROM ldc_articles WHERE designation='".mysql_real_escape_string($_POST['nouvel_article'])."'";
	$result = mysql_query($sql,$this->lien_mysql);
	
	if(mysql_num_rows($result)>0)
	{
			return "Article d&eacute;ja saisi !";
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO ldc_articles VALUES ( NULL, '".$_POST['nouvel_article']."', '".$_POST['unite_nouvel_article']."', ".$_POST['ID_rayon'].")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);

//RÃ©cupÃ©ration de l'ID du nouvel article
	$sql = "SELECT ID FROM ldc_articles WHERE designation = '".$_POST['nouvel_article']."'";
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);

	$ID_article =  $row["ID"];
	
//Ajouter l'article Ã  la liste de oourse
//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO ldc_liste VALUES ( NULL, ".$_POST['quantite_nouvel_article'].", ".$ID_article.", 0)";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);


	};
	
	
}

	function mettre_a_jour_recette()
	{
if(isset($_REQUEST['Nouvelle_designation']) AND isset($_REQUEST['ID_item_menu']))
{
		$sql = "UPDATE mds_items_menu SET designation = '".$_REQUEST['Nouvelle_designation']."' WHERE ID = ".$_REQUEST['ID_item_menu'];
		
		$result = mysql_query($sql,$this->lien_mysql);

};

if(isset($_POST['type_repas_ajoute']) AND isset($_GET['ID_item_menu']))
{
	$ID_type_repas =  $_POST['type_repas_ajoute'];
	
//VÃ©rifier que l'association n'existe pas dÃ©jÃ 

	$sql = "SELECT COUNT(*) FROM mds_items_menu_types_repas WHERE ID_type_repas = ".$ID_type_repas." AND ID_item_menu = ".$_GET["ID_item_menu"];
	
	$result = mysql_query($sql,$this->lien_mysql);
	
	$row = mysql_fetch_array($result);

	$compte_lien =  $row["COUNT(*)"];
	
	if ($compte_lien == 0)
	{
//CrÃ©ation de la requÃªte SQL
	$sql = "INSERT  INTO mds_items_menu_types_repas VALUES (".$_GET["ID_item_menu"].", ".$ID_type_repas.")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	};
};



// Ajouter les articles pour lesquels la quantitÃ© a Ã©tÃ© renseignÃ©e
if(isset($_POST['quantite_ajoutee']))
{
//VÃ©rifier qu'aucun article n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "";
	$premiere_entree = TRUE;
    foreach($_POST['quantite_ajoutee'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "SELECT * FROM mds_recettes WHERE (ID_article = ";
		}
		else
		{
			$sql .= " OR (ID_article = ";
		};
		$sql .= $ID_article.") AND ID_item_menu = ".$_GET["ID_item_menu"];
		$premiere_entree = FALSE;
		};
    };

	If ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
		if(mysql_num_rows($result)>0) {
			return "Article d&eacute;ja saisi !";
		}
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "";
	$premiere_entree = TRUE;
	foreach($_POST['quantite_ajoutee'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "INSERT  INTO mds_recettes VALUES ";
		}
		else
		{
			$sql .= ", ";
		};
		$sql .= "('".$_GET["ID_item_menu"]."', '".$quantite."', '".$ID_article."')";
		$premiere_entree = FALSE;
		};
    };

//Execution de la requÃªte SQL
	if ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
	};
};

// Ajouter les articles pour lesquels la quantitÃ© a Ã©tÃ© renseignÃ©e
if(isset($_POST['quantite_materiel_ajoute']))
{
//VÃ©rifier qu'aucun article n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "";
	$premiere_entree = TRUE;
    foreach($_POST['quantite_materiel_ajoute'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "SELECT * FROM mds_materiel WHERE (ID_article = ";
		}
		else
		{
			$sql .= " OR (ID_article = ";
		};
		$sql .= $ID_article.") AND ID_item_menu = ".$_GET["ID_item_menu"];
		$premiere_entree = FALSE;
		};
    };

	If ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
		if(mysql_num_rows($result)>0) {
			return "Article d&eacute;ja saisi !";
		}
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "";
	$premiere_entree = TRUE;
	foreach($_POST['quantite_materiel_ajoute'] as $ID_article => $quantite)
    {
		if (($quantite <> "") AND ($quantite <> 0))
		{
		if ($premiere_entree == TRUE)
		{
			$sql = "INSERT  INTO mds_materiel VALUES ";
		}
		else
		{
			$sql .= ", ";
		};
		$sql .= "('".$_GET["ID_item_menu"]."', '".$quantite."', '".$ID_article."')";
		$premiere_entree = FALSE;
		};
    };

//Execution de la requÃªte SQL
	if ($sql <> "")
	{
		$result = mysql_query($sql,$this->lien_mysql);
	};
};

//Ajouter un article Ã  la base de donnÃ©es et Ã  la recette en mÃªme temps
	if (isset($_POST['nouvel_article']) AND isset($_POST['quantite_nouvel_article']) AND isset($_POST['unite_nouvel_article']))
	{
//VÃ©rifier qu'aucun article n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "SELECT ID FROM ldc_articles WHERE designation='".mysql_real_escape_string($_POST['nouvel_article'])."'";
	$result = mysql_query($sql,$this->lien_mysql);
	
	if(mysql_num_rows($result)>0)
	{
			return "Article d&eacute;ja saisi !";
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO ldc_articles VALUES ( NULL, '".$_POST['nouvel_article']."', '".$_POST['unite_nouvel_article']."', ".$_POST['ID_rayon'].")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);

//RÃ©cupÃ©ration de l'ID du nouvel article
	$sql = "SELECT ID FROM ldc_articles WHERE designation = '".$_POST['nouvel_article']."'";
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);

	$ID_article =  $row["ID"];
	
//Ajouter l'article Ã  la liste de oourse
//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO mds_recettes VALUES ( ".$_GET["ID_item_menu"].", ".$_POST['quantite_nouvel_article'].", ".$ID_article.")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);

	};

//Ajouter un materiel Ã  la base de donnÃ©es et Ã  la recette en mÃªme temps
	if (isset($_POST['nouveau_materiel']) AND isset($_POST['quantite_nouveau_materiel']) AND isset($_POST['unite_nouveau_materiel']))
	{
//VÃ©rifier qu'aucun materiel n'est dÃ©jÃ  entrÃ© (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "SELECT ID FROM ldc_articles WHERE designation='".mysql_real_escape_string($_POST['nouveau_materiel'])."'";
	$result = mysql_query($sql,$this->lien_mysql);
	
	if(mysql_num_rows($result)>0)
	{
			return "MatÃ©riel d&eacute;ja saisi !";
	};	

//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO ldc_articles VALUES ( NULL, '".$_POST['nouveau_materiel']."', '".$_POST['unite_nouveau_materiel']."', ".$_POST['ID_rayon'].")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);

//RÃ©cupÃ©ration de l'ID du nouveau materiel
	$sql = "SELECT ID FROM ldc_articles WHERE designation = '".$_POST['nouveau_materiel']."'";
	$result = mysql_query($sql,$this->lien_mysql);
	$row = mysql_fetch_array($result);

	$ID_article =  $row["ID"];
	
//Ajouter le materiel Ã  la recette
//CrÃ©ation de la requÃªte SQL

	$sql = "INSERT INTO mds_materiel VALUES ( ".$_GET["ID_item_menu"].", ".$_POST['quantite_nouveau_materiel'].", ".$ID_article.")";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);


	};

}

	function mettre_a_jour_liste_recettes()
	{

if(isset($_POST['nouvelle_recette']))
{
//VÃ©rifier qu'aucune homonyme n'est dÃ©jÃ  entrÃ©e (cas oÃ¹ l'on ressoumettrait un formulaire)
	$sql = "SELECT * FROM mds_items_menu WHERE designation = '".$_POST['nouvelle_recette']."'";

	$result = mysql_query($sql,$this->lien_mysql);
		if(mysql_num_rows($result)>0) {
			return "Recette d&eacute;ja saisie !";
		}
};	

	if ($_POST['nouvelle_recette'] <> "")
	{
	//CrÃ©ation de la requÃªte SQL
	$sql = "INSERT  INTO mds_items_menu VALUES (NULL, '".$_POST['nouvelle_recette']."')";

	//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	};
}

	function composition_liste_articles_a_ajouter()
	{
	
//	var_dump($_POST['article_recherche']);
	
	$article_recherche = stripslashes($_POST['article_recherche']);
	
	$texte_liste = "<form method='post' action='page_perso.php?commande=afficher_liste_de_courses#ajout_article_a_la_liste'>
					<p class='champs_centres'>
					<input  class='champ' name='article_recherche' list='designations_articles' ";

//	if (!isset($article_recherche) OR ($article_recherche == ""))
//	{
		$texte_liste .= "placeholder='Entrer la d&eacute;signation'";
//	}
//	else
//	{
//		$texte_liste .= "placeholder=\"".$article_recherche."\"";
//	};
					
	$texte_liste .=	"> ";
	$texte_liste .= $this->composition_datalist_articles();
	$texte_liste .= "<input class='bouton' type='submit' value='Envoyer'>
					</p>
				</form>";



//CrÃ©ation de la requÃªte SQL
	if (isset($article_recherche) AND ($article_recherche <> ""))
	{
	$article_recherche =  mysql_real_escape_string($article_recherche);

	$sql ="SELECT ldc_articles.ID, ldc_articles.designation, ldc_liste.quantite, ldc_articles.unite FROM ldc_articles LEFT JOIN ldc_liste ON ldc_articles.ID = ldc_liste.ID_article WHERE ldc_articles.designation LIKE '".$article_recherche."' ORDER BY ldc_articles.designation";
	
//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	
//	echo mysql_error();
	
	if(mysql_num_rows($result)>0) 
	{
		$texte_liste .= "<form method='post' action='page_perso.php?commande=afficher_liste_de_courses'><ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			if ($row["quantite"] <> "")
			{
				$type_modification = "quantite_modifiee";
			}
			else
			{
				$type_modification = "quantite_ajoutee";
			};
			$texte_liste .= "<li>".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))." (".htmlentities($row["unite"], ENT_QUOTES, "UTF-8").") : <input class='champ_quantite' type='number'";
			if ($row["unite"] == "litre(s)")
			{
				$texte_liste .= " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				$texte_liste .= " step='0.01'";
			};
			$texte_liste .= " name='".$type_modification."[".$row["ID"]."]' value='".$row["quantite"]."'></li>";
		};
		$texte_liste .= "</ul>
				<p class='champs_centres'>
					<input class='bouton' type='submit' value='Modifier la liste'>
				</p>
			</form>";
	} else
//Si aucun article ne correspond dans la base de donnÃ©es, proposer d'en ajouter un
	{
		$texte_liste .= "<form method='post' action='page_perso.php?commande=afficher_liste_de_courses#ajout_article_a_la_liste'><p class='champs_centres'><input class='champ' type='text' name='nouvel_article' value=\"".stripslashes($article_recherche)."\"></input><input class='champ_quantite' type='number' name='quantite_nouvel_article' value=1></input><input class='champ' type='text' name='unite_nouvel_article' value='unit&eacute;(s)'></input>";
// crÃ©ation de la liste des rayons
		//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_rayons.ID, ldc_rayons.designation FROM ldc_rayons ORDER BY ldc_rayons.ordre";

		//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0) {
		$texte_liste .= $this->composition_select_rayons(25);
		};
		$texte_liste .= "<input class='bouton' type='submit' value='Modifier la liste'></p></form>";
	};
	};

	return $texte_liste;
}

	function composition_liste_ingredients_a_ajouter($ID_item_menu)
	{
	
//	var_dump($_POST['article_recherche']);
	
	$article_recherche = stripslashes($_POST['article_recherche']);
	
	$texte_liste = "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$ID_item_menu."#ajout_ingredient_a_la_recette'>
					<p class='champs_centres'>
					<input  class='champ' name='article_recherche' list='designations_articles'";

	$texte_liste .= "placeholder='Entrer la d&eacute;signation'";
					
	$texte_liste .=	">";
	$texte_liste .= $this->composition_datalist_articles();
	$texte_liste .= "<input class='bouton' type='submit' value='Envoyer'>
					</p>
				</form>";



//CrÃ©ation de la requÃªte SQL
	if (isset($article_recherche) AND ($article_recherche <> ""))
	{
	$article_recherche =  mysql_real_escape_string($article_recherche);

//	$sql ="SELECT ldc_articles.ID, ldc_articles.designation, mds_recettes.quantite, ldc_articles.unite FROM ldc_articles LEFT JOIN mds_recettes ON ldc_articles.ID = mds_recettes.ID_article WHERE ldc_articles.designation LIKE '".$article_recherche."' AND mds_recettes.ID_item_menu = '".$ID_item_menu."' ORDER BY ldc_articles.designation";
	$sql ="SELECT ldc_articles.ID, ldc_articles.designation, ldc_articles.unite FROM ldc_articles WHERE ldc_articles.designation LIKE '".$article_recherche."' ORDER BY ldc_articles.designation";
	
//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	
//	echo mysql_error();
	
//	echo mysql_num_rows($result);
	
	if(mysql_num_rows($result)>0) 
	{
		$texte_liste .= "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$ID_item_menu."'><ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<li>".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))." (".htmlentities($row["unite"], ENT_QUOTES, "UTF-8").") : <input class='champ_quantite' type='number'";
			if ($row["unite"] == "litre(s)")
			{
				$texte_liste .= " step='0.005'";
			};
			if ($row["unite"] == "unitÃ©(s)")
			{
				$texte_liste .= " step='0.01'";
			};
			$texte_liste .= " name='quantite_ajoutee[".$row["ID"]."]' value=''></li>";
		};
		$texte_liste .= "</ul>
				<p class='champs_centres'>
					<input class='bouton' type='submit' value='Modifier la liste des ingrÃ©dients'>
				</p>
			</form>";
	} else
//Si aucun article ne correspond dans la base de donnÃ©es, proposer d'en ajouter un
	{
		$texte_liste .= "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$_GET["ID_item_menu"]."#ajout_article_a_la_liste'><p class='champs_centres'><input class='champ' type='text' name='nouvel_article' value=\"".stripslashes($article_recherche)."\"></input><input class='champ_quantite' type='number' name='quantite_nouvel_article' value=1></input><input class='champ' type='text' name='unite_nouvel_article' value='unit&eacute;(s)'></input>";
// crÃ©ation de la liste des rayons
		//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_rayons.ID, ldc_rayons.designation FROM ldc_rayons ORDER BY ldc_rayons.ordre";

		//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0) {
		$texte_liste .= $this->composition_select_rayons(25);
		};
		$texte_liste .= "<input class='bouton' type='submit' value='Modifier la liste des ingrÃ©dient'></p></form>";
	};
	};

	return $texte_liste;
}

	function composition_liste_materiel_a_ajouter($ID_item_menu)
	{
	
//	var_dump($_POST['article_recherche']);
	
	$materiel_recherche = stripslashes($_POST['materiel_recherche']);
	
	$texte_liste = "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$ID_item_menu."#ajout_ingredient_a_la_recette'>
					<p class='champs_centres'>
					<input  class='champ' name='materiel_recherche' list='designations_articles'";

//	if (!isset($article_recherche) OR ($article_recherche == ""))
//	{
		$texte_liste .= "placeholder='Entrer la d&eacute;signation'";
//	}
//	else
//	{
//		$texte_liste .= "placeholder=\"".$article_recherche."\"";
//	};
					
	$texte_liste .=	">";
	$texte_liste .= $this->composition_datalist_articles();
	$texte_liste .= "<input class='bouton' type='submit' value='Envoyer'>
					</p>
				</form>";



//CrÃ©ation de la requÃªte SQL
	if (isset($materiel_recherche) AND ($materiel_recherche <> ""))
	{
	$materiel_recherche =  mysql_real_escape_string($materiel_recherche);

//	$sql ="SELECT ldc_articles.ID, ldc_articles.designation, mds_recettes.quantite, ldc_articles.unite FROM ldc_articles LEFT JOIN mds_recettes ON ldc_articles.ID = mds_recettes.ID_article WHERE ldc_articles.designation LIKE '".$article_recherche."' AND mds_recettes.ID_item_menu = '".$ID_item_menu."' ORDER BY ldc_articles.designation";
	$sql ="SELECT ldc_articles.ID, ldc_articles.designation, ldc_articles.unite FROM ldc_articles WHERE ldc_articles.designation LIKE '".$materiel_recherche."' ORDER BY ldc_articles.designation";
	
//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	
//	echo mysql_error();
	
//	echo mysql_num_rows($result);
	
	if(mysql_num_rows($result)>0) 
	{
		$texte_liste .= "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$ID_item_menu."'><ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			$texte_liste .= "<li>".stripslashes(htmlentities($row["designation"], ENT_QUOTES, "UTF-8"))." (".htmlentities($row["unite"], ENT_QUOTES, "UTF-8").") : <input class='champ_quantite' type='number' name='quantite_materiel_ajoute[".$row["ID"]."]' value=''></li>";
		};
		$texte_liste .= "</ul>
				<p class='champs_centres'>
					<input class='bouton' type='submit' value='Modifier la liste du materiel'>
				</p>
			</form>";
	} else
//Si aucun article ne correspond dans la base de donnÃ©es, proposer d'en ajouter un
	{
//		$texte_liste .= "<form method='post' action='page_perso.php?commande=afficher_liste_de_courses#ajout_materiel_a_la_liste'><p class='champs_centres'><input class='champ' type='text' name='nouveau_materiel' value=\"".stripslashes($materiel_recherche)."\"></input><input class='champ_quantite' type='number' name='quantite_nouveau_materiel' value=1></input><input class='champ' type='text' name='unite_nouveau_materiel' value='unit&eacute;(s)'></input>";
		$texte_liste .= "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$_GET["ID_item_menu"]."#ajout_materiel_a_la_liste'><p class='champs_centres'><input class='champ' type='text' name='nouveau_materiel' value=\"".stripslashes($materiel_recherche)."\"></input><input class='champ_quantite' type='number' name='quantite_nouveau_materiel' value=1></input><input class='champ' type='text' name='unite_nouveau_materiel' value='unit&eacute;(s)'></input>";

// crÃ©ation de la liste des rayons
		//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_rayons.ID, ldc_rayons.designation FROM ldc_rayons ORDER BY ldc_rayons.ordre";

		//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	if(mysql_num_rows($result)>0) {
		$texte_liste .= $this->composition_select_rayons(25);
		};
		$texte_liste .= "<input class='bouton' type='submit' value='Modifier la liste de materiel'></p></form>";
	};
	};

	return $texte_liste;
}

	function composition_liste_type_repas_a_ajouter($ID_item_menu)
	{
	
//	$type_repas_ajoute = stripslashes($_POST['type_repas_ajoute']);
	
	$texte_liste = "<form method='post' action='page_perso.php?commande=editer_item_menu&ID_item_menu=".$ID_item_menu."'>
					<p class='champs_centres'>";

	$texte_liste .= $this->composition_select_types_repas();
	$texte_liste .= "<input class='bouton' type='submit' value='Envoyer'>
					</p>
				</form>";

	return $texte_liste;
}



	function imprimer_liste_de_courses()
	{

//CrÃ©ation de la requÃªte SQL
	$sql ="SELECT ldc_articles.designation, ldc_liste.quantite, ldc_liste.checked, ldc_articles.unite, ldc_rayons.designation as rayon, ldc_rayons.ID as ID_rayon, ldc_liste.ID_article as ID_article FROM `ldc_liste` LEFT JOIN ldc_articles ON ldc_liste.ID_article = ldc_articles.ID LEFT JOIN ldc_rayons ON ldc_articles.ID_rayon = ldc_rayons.ID ORDER BY ldc_rayons.ordre, ldc_articles.designation";

//Execution de la requÃªte SQL
	$result = mysql_query($sql,$this->lien_mysql);
	$ID_rayon = 0;
	if(mysql_num_rows($result)>0) {
		$titre_mail = "Liste de courses (".mysql_num_rows($result)." articles)";
//		$texte_liste = "<html><style type='text/css'>h1 {font: 12px 'Arial'; line-height: 14px; margin: 0px 0px 0px 0px;} h2 {font: 10px 'Arial'; line-height: 12px; margin: 0px 0px 0px 0px;} li {font: 8px 'Arial'; line-height: 10px; margin: 0px 0px 0px 0px;}</style><h1>Liste dans l'ordre des rayons (".mysql_num_rows($result)." entr&eacute;e(s))</h1><ul>";
		$texte_liste = "<html><style type='text/css'>h1 {font: 16px 'Arial'; line-height: 18px; margin: 5px 0px 0px 0px;} h2 {font: 12px 'Arial'; line-height: 14px; margin: 5px 0px 0px 0px;} li {font: 10px 'Arial'; line-height: 12px; margin: 5px 0px 0px 0px;}</style><ul>";
		for ( $i = 0; $i < mysql_num_rows($result); $i++)
		{
			$row = mysql_fetch_array($result);
			if ($ID_rayon <> $row["ID_rayon"])
			{
				$texte_liste .= "<h2>".$row["rayon"]."</h2>";
				$ID_rayon = $row["ID_rayon"];
			};
			$texte_liste .= "<li>";
			if ($row["checked"] == 1)
			{
				$texte_liste .= "<del>";
			};
			$texte_liste .= $row["designation"];
			$texte_liste .= " : ".$row["quantite"]." ".$row["unite"];
			if ($row["checked"] == 1)
			{
				$texte_liste .= "</del> ";
			}
			$texte_liste .= "</li>";
		};
		$texte_liste .= "</ul></htlm>";
//		return $texte_liste;
	} else {
		$texte_liste = "Aucun article<br/>";
	}

//Â PourÂ envoyerÂ unÂ mailÂ HTML,Â l'en-tÃªteÂ Content-typeÂ doitÂ ÃªtreÂ dÃ©fini
$headers = "MIME-Version: 1.0"."\r\n";
$headers .= "Content-type: text/html; charset=utf-8"."\r\n";



//Â EnvoiÂ duÂ mail
mail("qwerty123@print.epsonconnect.com", $titre_mail, $texte_liste, $headers); // Enter here your printer's email address
	}
};

class message
{
	var $ID;
	var $type;
	var $intitule;

	//Constructeur
	function message($ID, $type, $intitule)
	{
		$this->ID = $ID;
		$this->type = $type; //(info, debug, erreur)
		$this->intitule = $intitule;
	}

};

class messages
{
	var $liste;
	var $nombre;

	//Constructeur
	function messages()
	{
		$this->liste = array();
		$this->nombre = 0;
	}

	function ajouter($admin_on, $message)
	{
		if ($message->type == 'info' OR $message->type == 'erreur' OR ($message->type == 'dbug' AND $admin_on == 'O'))
		{
			$this->liste[$this->nombre] = $message;
			$this->nombre++;
		};
	}
};
?>
