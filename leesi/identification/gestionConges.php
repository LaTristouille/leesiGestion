<?php require_once('C:\wamp64\www\leesi\connexion.php');  session_start();?>

<html lang='fr'>
<head>
	<meta charset='utf-8'/>
	<script>
		import {
			Calendar
		} from 'core';
		import interactionPlugin from 'interaction'; // for selectable
		import dayGridPlugin from 'daygrid';
		import frLocale from '@fullcalendar/core/locales/fr';
	</script>
	<link href='cssConges.css' rel='stylesheet'/>
	<link href='core/main.css' rel='stylesheet'/>
	<link href='cssErreur.css' rel='stylesheet'/>
	<link href='daygrid/main.css' rel='stylesheet'/>
	<script src='core/main.js'></script>
	<script src='daygrid/main.js'></script>
	<script src='inte.js'></script>

	<?php  $long = strlen($_SESSION['iden']) ?>
	<?php $rest = substr($_SESSION['iden'], -$long); ?>

	<script>
	</script>
	<script src='interaction/main.esm.js'></script>
	<script src='interaction/main.min.js'></script>
	<script src='interaction/main.js'></script>
	<script src='interaction/inte.js'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	<script src='moment.js'></script>
	<script src='locales-all.js'></script>
	<script src='fr.js'></script>


	<script>
		$( document ).ready( function () {
			//on récupère le reste des jours de congés 
			<?php  $longe = strlen($_SESSION['Credit']) ?>
			<?php $reste = substr($_SESSION['Credit'], -$long); ?>

			var credit = <?php echo json_encode($reste); ?>;
			var maVar = <?php echo json_encode($rest); ?>;
			var user = maVar;

			$.ajax( {
				url: "credit.php",
				type: "POST",
				data: {
					credit: credit,
					user: user
				},
				success: function ( data ) {
					$( "#count" ).text( data )
					console.log( arguments )
				}
			} )

			var calendar = $( '#calendar' ).fullCalendar( {
				defaultAllDayEventDuration: {
					days: 1
				},
				weekends: true,
				editable: true,
				locale: 'fr',
				eventColor: '#378006',
				allDayDefault: false,

				//récupérer le nombre de jours de congés pris avec event render
				eventRender: function ( event, element, view ) {
					// calendrier Ok
					var duration = moment.duration( event.end - event.start ).days();
					element.find( '.fc-title' ).append( duration );
					console.log( duration );



					credit = credit - duration;

					console.log( credit );



					$.ajax( {
						url: "credit.php",
						type: "POST",
						data: {
							credit: credit,
							user: user
						},
						success: function ( data ) {
							$( "#count" ).text( data )
							console.log( arguments )
						}
					} )
				},

				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay',
				},

				// on affiche les événements   
				events: 'load.php',

				// on ajoute un évenement   
				selectable: true,
				selectHelper: true,
				select: function ( startCalendar, endCalendar ) { // fin selection utilisateur : on envoie 

					var title = maVar;
					var start = $.fullCalendar.formatDate( startCalendar, "Y-MM-DD" );
					var end = $.fullCalendar.formatDate( endCalendar, "Y-MM-DD" );

					var jsEndDate = new Date( end );
					var realEndDateTime=jsEndDate.getTime()-(24*60*60*1000);
					var realEndDate = new Date(realEndDateTime);
					//***********************************
					var day = new String( realEndDate.getDate() ).padStart( 2, 0 );
					var month = new String( realEndDate.getMonth() + 1 ).padStart( 2, 0 );;
					var year = realEndDate.getFullYear();

					var endReal = year + '-' + month + '-' + day;
					//******************************************************
					$.ajax( {
						url: "insert.php",
						type: "POST",
						data: {
							title: title,
							start: start,
							end: end,
							endReal: endReal  //*****************************
						},
						success: function () {
							calendar.fullCalendar( 'refetchEvents' );
							alert( 'Congé bien ajouté' );
						},
						error: function ( err ) {
							console.log( 'Error:', data );
						}
					} )
				},
				// on modifie les évenements 
				editable: true,
				eventResize: function ( event ) {
					if ( event.title == maVar ) {

						var start = $.fullCalendar.formatDate( event.start, "Y-MM-DD HH:mm:ss" );
						var end = $.fullCalendar.formatDate( event.end, "Y-MM-DD HH:mm:ss" );
						var title = event.title;
						var id = event.id;
						$.ajax( {
							url: "update.php",
							type: "POST",
							data: {
								title: title,
								start: start,
								end: end,
								id: id
							},
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
								alert( 'Congé bien modifié' );
							}
						} )
					} else {
						alert( "Attention le congé n'a pas été modifié, veuillez séléctionnez votre propre congé" )
					}
				},
				eventDrop: function ( event ) {

					if ( event.title == maVar ) {

						var start = $.fullCalendar.formatDate( event.start, "Y-MM-DD HH:mm:ss" );
						var end = $.fullCalendar.formatDate( event.end, "Y-MM-DD HH:mm:ss" );
						var title = event.title;
						var id = event.id;
						$.ajax( {
							url: "update.php",
							type: "POST",
							data: {
								title: title,
								start: start,
								end: end,
								id: id
							},
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
								alert( "Congé bien modifié" );
							}
						} );
					} else {
						alert( "Le congé n'a pas été modifié, veuillez séléctionnez votre propre congé" )
					}
				},

				// on supprime les évenements
				eventClick: function ( event ) {
					if ( confirm( "Voulez vous vraiment supprimer ce congé ?" ) && ( event.title == maVar ) ) {
						var id = event.id;
						$.ajax( {
							url: "delete.php",
							type: "POST",
							data: {
								id: id
							},
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
								$.ajax( {
				url: "credit.php",
				type: "POST",
				data: {
					credit: credit,
					user: user
				},
				success: function ( data ) {
					$( "#count" ).text( data )
					console.log( arguments )
				}
			} )

								alert( "Congé supprimé" );
							}
						} )
					} else {
						alert( "Le congé n'a pas été supprimé, veuillez séléctionnez votre propre congé" )
					}
				},
			} );
		} );
	</script>
</head>

<body>
	<br/>
	<br/>
	<div class="container">
	</div>
</body>
</html>

</script>
</head>
<body>

	<?php  
	  
$name = $_SESSION["iden"];

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}  
	  ?>

	<input type="button" id="retour" onclick=window.location.href='http://localhost/leesi/iden/congesAbsences.php' ; value="Retour">

	<input type="button" id="deco" onclick=window.location.href='http://localhost/leesi/iden/identification' ; session_destroy() ; value="Déconnexion">
	<p id="t">
		<?php echo $_SESSION['iden'], ' il vous reste' ?> <span id="count"> </span> jour(s) de congés à prendre </p>

	<p id="erreur">
		<?php   /*/si $_SESSION['conge'] créé par credit.php est superieur à 20 alors /*/
	
		if ( $_SESSION['conge'] >20) { 
	
	?>
		<script>
			alert( "Attention vous avez pris des congés en trop, veuiller en supprimer" )
		</script>
		<?php 
	
	echo "Attention vous avez pris ", $_SESSION['conge'] - 20," jour(s) de congés en trop, veuillez en supprimer" ; }  ?>

	</p>

	<div id='calendar'></div>

</body>
</html>