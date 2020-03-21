<?php require_once('../db/connexion.php');  session_start();?>

<html lang='fr'>
<head>
	<meta charset='utf-8'/>

	<link href='../css/cssConges.css' rel='stylesheet'/>
	<link href='../identification/core/main.css' rel='stylesheet'/>
	<link href='../css/cssErreur.css' rel='stylesheet'/>
	<link href='../identification/daygrid/main.css' rel='stylesheet'/>
        
	<script src='../identification/core/main.js'></script>
	<script src='../identification/daygrid/main.js'></script>
	<script src='../identification/interaction/main.esm.js'></script>
	<script src='../identification/interaction/main.min.js'></script>
	<script src='../identification/interaction/main.js'></script>
	<link rel="stylesheet" href="../css/fullcalendar.css" />
	<link rel="stylesheet" href="../css/bootstrap.css"/> 
	<script src="../js/jquery-3.4.1.min.js"></script>
	 <script src='../js/moment.js'></script> 
	 <script src="../js/fullcalendar.js"></script>
	<link href='../css/custom.css' rel='stylesheet' />

	<script>

		function getDateReal (startCalendar,endCalendar) {
		
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

			return {start:start,
			end:end,
			endReal:endReal,
			}
		}

		$( document ).ready( function () {
                    
                        //on récupère l'identifiants via le $_SESSION qu'on affecte dans une variable php
                        <?php  $long = strlen($_SESSION['iden']) ?>
                        <?php $rest = substr($_SESSION['iden'], -$long); ?>


			 //on récupère le nombre des jours de congés via le $_SESSION qu'on affecte dans une variable php
			<?php  $longe = strlen($_SESSION['Credit']) ?>
			<?php $reste = substr($_SESSION['Credit'], -$long); ?>


                        //on traduit les objets Json en Js
			var credit = <?php echo json_encode($reste); ?>;
			var maVar = <?php echo json_encode($rest); ?>;
			var user = maVar;   

			var calendar = $('#calendar').fullCalendar( {
			
				editable:true,
				header:{
				left:'prev,next today',
				center:'title',
				right:''
				},

				//récupérer le nombre de jours de congés pris avec event render
				eventRender: function ( event, element, view ) {
					
					var duration = moment.duration( event.end - event.start ).days();
					/* element.find( '.fc-title' ).append(" " + duration ); */

					if (event.alert==1 ) {
						
						element.addClass("adminColor")
					}

					element.addClass("congeColor");

					console.log( duration );

					credit = credit - duration;

					console.log( credit );

					$.ajax( {
						url: "../evenement/credit.php",
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
				events: '../evenement/load.php',

				// on ajoute un évenement   
				selectable: true,
				selectHelper: true,

				select: function ( startCalendar, endCalendar ) { // fin selection utilisateur : on envoie 

					var result = getDateReal( startCalendar, endCalendar )
					
					$.ajax( {
						url: "../evenement/insert.php",
						type: "POST",
						data: {
							title: maVar,
							start: result.start,
							end: result.end,
							endReal: result.endReal,
							alert: 0, 
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
				
				eventDrop: function ( event ) {

					if ( event.title == maVar && event.alert == 0 ) {

						var start = $.fullCalendar.formatDate( event.start, "Y-MM-DD HH:mm:ss" );
						var end = $.fullCalendar.formatDate( event.end, "Y-MM-DD HH:mm:ss" );
						var title = event.title;
						var id = event.id;
						var result = getDateReal( event.start, event.end );
						$.ajax( {
							url: "../evenement/update.php",
							type: "POST",
							data: {
								title: title,
								start: result.start,
								end: result.end,
								endReal: result.endReal,
								alert: 0,
								id: id,
								
							},
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
								alert( "Congé bien modifié" );
							}
						} );
					} else {
								
						$.ajax( {
							url: "../evenement/load.php",
							type: "GET",
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
							}
						} )

						alert( "Le congé n'a pas été modifié, veuillez séléctionnez votre propre congé pas encore validé" )
					}
				},

				// on supprime les évenements
				eventClick: function ( event ) {
					if ( confirm( "Voulez vous vraiment supprimer ce congé ?" ) && ( event.title == maVar ) && (event.alert==0)) {
						var id = event.id;
						$.ajax( {
							url: "../evenement/delete.php",
							type: "POST",
							data: {
								id: id
							},
							success: function () {
								calendar.fullCalendar( 'refetchEvents' );
								alert( "Congé supprimé" );
							}
						} )
					} else {
						alert( "Le congé n'a pas été supprimé, veuillez séléctionnez votre propre congé pas encore validé" )
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
    

	<input type="button" id="retour" onclick=window.location.href='../identification/congesAbsences.php' ; value="Retour">

	<input type="button" id="deco" onclick=window.location.href='../identification/employe' ; session_destroy() ; value="Déconnexion">
	
        <br> <br> <input id="legende"  > Congé en attente de validation  <br>  
        
        <input id="legende2" > Congé validé  
      
        
        <p id="t">  
		<?php echo $_SESSION['iden'], ' il vous reste' ?> <span id="count"> </span> jour(s) de congés à prendre </p>

	<p id="erreur">
		<?php   /*/si $_SESSION['conge'] créé par credit.php est superieur à 20 alors /*/
	
                if ( isset($_SESSION['conge']) && $_SESSION['conge']>20 ) { 
	
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