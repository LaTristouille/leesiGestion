<?php
require_once( '../db/connexion.php' );
require_once( '../db/connexionPDO.php' );
session_start();

$connect = $PDO;

$User = $_POST[ 'user' ];

$query = "SELECT * FROM events WHERE title='$User'";

$statement = $connect->prepare( $query );

$statement->execute();

$result = $statement->fetchAll();

$count = 0;
/*

/*---------------------------------------------------------------*/
/*
    Titre : Calcul le nombre de jours ouvrés entre 2 dates                                                               
                                                                                                                          
    URL   : https://phpsources.net/code_s.php?id=666
    Auteur           : yem                                                                                                
    Date édition     : 04 Oct 2012                                                                                        
    Date mise à jour : 29 Aout 2019                                                                                      
    Rapport de la maj:                                                                                                    
    - fonctionnement du code vérifié                                                                                    
    - amélioration du code                                                                                               
*/
/*---------------------------------------------------------------*/
// calcul des années bissextiles
function leap_year( $year ) {
	return date( "L", mktime( 0, 0, 0, 1, 1, $year ) );
}

function nb_jours( $date1, $date2 ) {
	error_log( "Date 1:".$date1." Date 2:".$date2 );

	$timestamp1 = strtotime( $date1 );
	$timestamp2 = strtotime( $date2 );

	$tot = 0; // total de jours entre les 2 dates

	// dates en jours de l'année ( depuis le 1er jan )
	$date1 = date( "z", $timestamp1 ); // date de depart
	$date2 = date( "z", $timestamp2 ); //date d'arrivée

	$day_stamp = 86400; //(3600 * 24 ); // un journée en timestamp

	// années des deux dates
	$year1 = date( "Y", $timestamp1 );
	$year2 = date( "Y", $timestamp2 );

	$num = 0; // nombre de jours feries a compter sur la duree totale
	$counter = 0; // la durée entre deux date par année

	$year = $year1; // l'année en cours ( defaut : $year1 )


	// on calcule le nombre de jours de différence entre les deux dates, en tenant
	// compte des années
	while ( $year <= $year2 ) {
		$date3 = date( "d-n-Y", mktime( 0, 0, 0, 1, 1, $year ) );
		$timestamp3 = strtotime( $date3 );
		// date de référence pour l'année en cours
		$counter = 0; // compteur de jours pour chaque année

		//on récupère la date de pâques   
		$easterDate = easter_date( $year );
		$easterDay = date( 'j', $easterDate );
		$easterMonth = date( 'n', $easterDate );
		$easterYear = date( 'Y', $easterDate );

		// le tableau sort les jours fériés de l'année depuis le premier janvier
		$closed = array(
			// dates fixes
			date( "z", mktime( 0, 0, 0, 1, 1, $year ) ), // 1er janvier
			date( "z", mktime( 0, 0, 0, 5, 1, $year ) ), // Fête du travail
			date( "z", mktime( 0, 0, 0, 5, 8, $year ) ), // Victoire des alliés
			date( "z", mktime( 0, 0, 0, 7, 14, $year ) ), // Fête nationale
			date( "z", mktime( 0, 0, 0, 8, 15, $year ) ), // Assomption
			date( "z", mktime( 0, 0, 0, 11, 1, $year ) ), // Toussaint
			date( "z", mktime( 0, 0, 0, 11, 11, $year ) ), // Armistice
			date( "z", mktime( 0, 0, 0, 12, 25, $year ) ), // Noel

			// Dates basées sur Paques
			date( "z", mktime( 0, 0, 0, $easterMonth, $easterDay + 1, $easterYear ) ), // Lundi de Paques
			date( "z", mktime( 0, 0, 0, $easterMonth, $easterDay + 39, $easterYear ) ), // Ascension
			date( "z", mktime( 0, 0, 0, $easterMonth, $easterDay + 50, $easterYear ) ) // Lundi de Pentecote

		);

		// si c'est la première année -> on commence par la date de depart; 
		// le compteur compte les jours jusqu'au 31dec
		if ( $year == $year1 && $year < $year2 ) {
			$i = $date1;
			$counter += ( 364 + leap_year( $year ) );
		}

		// si c'est ni la première ni la dernière année -> on commence au premier
		// janvier; 
		//le compteur compte tous les jours de l'année
		if ( $year > $year1 && $year < $year2 ) {
			$i = date( "z", mktime( 0, 0, 0, 1, 1, $year ) );
			$counter += 364 + leap_year( $year );
		}

		// si c'est la dernière année -> on commence au premier janvier; 
		// le compteur va jusqu'a la date d'arrivée
		if ( $year == $year2 && $year > $year1 ) {
			$i = date( "z", mktime( 0, 0, 0, 1, 1, $year ) );
			$counter += $date2;
		}

		// si les deux dates sont dans la même année
		if ( $year == $year1 && $year == $year2 ) {
			$i = $date1;
			$counter += $date2;
		}

		// on boucle les jours sur la période donnée
		while ( $i <= $counter ) {
			$tot = $tot + 1; // on ajoute 1 pour chaque jour passé en revue

			if ( in_array( $i, $closed ) ) {
				$num++; // on ajoute 1 pour chaque jour férié rencontré
			}

			// on compte chaque samedi et chaque dimanche
			if ( ( ( date( "w", $timestamp3 + $i * $day_stamp ) == 6 )or( date( "w", $timestamp3 + $i * $day_stamp ) == 0 ) )and!in_array( $i, $closed ) ) {
				$num++;
			}
			$i++;
		}
		// on incremente l'année
		$year++;
	}

	$res = $tot - $num;
	error_log( "tot:".$tot." num:".$num );
	//Nombre de jours entre les 2 dates fournies - nombre de jours non ouvrés
	return $res;
}
$congePris = 0;
// Requète sql pour le début et fin du congé
$demande3 = "SELECT start_event, end_event, endReal FROM events WHERE title='$User'";
// On récupère toutes les dates de début et de fin de congé
foreach ( $connect->query( $demande3 ) as $row ) {
	// On récupère les dates de début de congé
	$date1 = $row[ 'start_event' ]; //. "\t";
	// Convertissement en int
	intval( $date1 );
	// On les convertit dans une forme date
	$timestamp = strtotime( $date1 );
	// On les convertit en DD-MM-YYYY	
	$dmy1 = date( "d-m-Y", $timestamp );
	// On remplace les tiret par des espaces	V									 	
	$date1 = str_replace( "-", " ", $dmy1 );

	// On récupère le mois V
	$mois = substr( $date1, 2, -5 );
	// Et on le traduit litérallement
	$array = array( ' January', ' February', ' March', ' April', ' May', ' June', ' July', ' August', ' September', ' October', ' November', ' December' );
	$newMois1 = $array[ $mois - 1 ];

	$date1 = str_replace( $mois, $newMois1, $date1 );

	//echo $date1;

	// On récupère les dates de fin de congés
	$date2 = $row[ 'endReal' ];
	// Convertissement en int
	intval( $date2 );
	// On convertit en forme date
	$timestamp = strtotime( $date2 );
	// On convertit en DD-MM-YYYY
	$dmy2 = date( "d-m-Y", $timestamp );
	// On remplace les tirets par des espaces V
	$date2 = str_replace( "-", " ", $dmy2 );
	// On récupère le mois V
	$mois2 = substr( $date2, 2, -5 );
	// Et on le traduit litérallement 
	$array = array( ' January', ' February', ' March', ' April', ' May', ' June', ' July', ' August', ' September', ' October', ' November', ' December' );
	$newMois = $array[ $mois2 - 1 ];

	$date2 = str_replace( $mois2, $newMois, $date2 );

	$congePris = $congePris + nb_jours( $date1, $date2 );

	;
}

$_SESSION[ 'conge' ] = $congePris;

//on récupère les crédits dans bdd

$link = $cnleesi;

$result = "SELECT * FROM id WHERE User='$User'";

$res = $cnleesi->query( $result );

if ( $data = mysqli_fetch_array( $res ) ) {

	// on affiche les résultats

	"<tr><td>" . $data[ 'Mdp' ] . "</td><td>" . $data[ 'Credit' ] . "</td></tr>";

	//si on rentre les bons identifiants 

	$credit = $data[ 'Credit' ]; //qu'on  affecte à $credit
}

// on calcul le reste des credits

$resteCredit = $credit - $congePris;

$_SESSION[ 'reste' ] = $resteCredit;

echo $resteCredit;

?>