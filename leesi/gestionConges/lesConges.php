<?php require_once('../db/connexion.php');
session_start(); ?>

<html lang='fr'>

<head>
  <meta charset='utf-8' />

  <link href='../css/cssConges.css' rel='stylesheet' />
  <link href='../identification/core/main.css' rel='stylesheet' />
  <link href='../identification/daygrid/main.css' rel='stylesheet' />

  <script src='../identification/core/main.js'></script>
  <script src='../identification/daygrid/main.js'></script>

  <script src='../identification/interaction/main.esm.js'></script>
  <script src='../identification/interaction/main.min.js'></script>
  <script src='../identification/interaction/main.js'></script>
  <link rel="stylesheet" href="../css/fullcalendar.css" />
  <link rel="stylesheet" href="../css/bootstrap.css" />
  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/moment.js"></script>
  <script src="../js/fullcalendar.js"></script>

  <style> 
	.adminColor{

		background-color : green;

	} 
	
	.congeColor{

		color : white !important;
	}

	</style>


  <script>
    function getDateReal(startCalendar, endCalendar) {

      var start = $.fullCalendar.formatDate(startCalendar, "Y-MM-DD");
      var end = $.fullCalendar.formatDate(endCalendar, "Y-MM-DD");

      var jsEndDate = new Date(end);
      var realEndDateTime = jsEndDate.getTime() - (24 * 60 * 60 * 1000);
      var realEndDate = new Date(realEndDateTime);
      //***********************************
      var day = new String(realEndDate.getDate()).padStart(2, 0);
      var month = new String(realEndDate.getMonth() + 1).padStart(2, 0);;
      var year = realEndDate.getFullYear();

      var endReal = year + '-' + month + '-' + day;

      return {
        start: start,
        end: end,
        endReal: endReal,
      }
    }

    $(document).ready(function() {
      var calendar = $('#calendar').fullCalendar({
        editable: true,
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },

        eventRender: function(event, element, view) {

          if (event.alert==1 ) {
						
						element.addClass("adminColor")
					}

					element.addClass("congeColor");


          $.ajax({
            url: "../evenement/credit.php",
            type: "GET",
            success: function(data) {
              //recup de
              $("#count").text(data)
              console.log(arguments)
            }
          })
        },
        // on affiche les événements   
        events: '../evenement/load.php',

        // on ajoute un évenement   
        selectable: true,
        selectHelper: true,

        select: function(start, end)

        {

          var title = prompt("Nom de l'employé en congé :");

          if (title) {
            var result = getDateReal(start, end);

            $.ajax({
              url: "../evenement/insert.php",
              type: "POST",
              data: {
                title: title,
                start: result.start,
                end: result.end,
                endReal: result.endReal,
                alert : 1,
           //*****************************
              },
              success: function() {
                calendar.fullCalendar('refetchEvents');
                alert("Congé bien ajouté");
              },
              error: function(err) {
                console.log('Error:', data);
              }
            })
          }
        },
        // on modifie les évenements 
        editable: true,
        /* eventResize:function(event)
    {
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
								id: id,
								
							},
    })}, */
        eventDrop: function(event) {
          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
          var title = event.title;
          var id = event.id;
          var result = getDateReal(event.start, event.end);
          $.ajax({
            url: "../evenement/update.php",
            type: "POST",
            data: {
              title: title,
              start: result.start,
              end: result.end,
              endReal: result.endReal,
              alert : 1,
              id: id,

            },
            success: function() {
              calendar.fullCalendar('refetchEvents');
              alert("Congé modifié");
            }
          })
        },

        // on supprime les évenements
        eventClick: function(event) {
          if (confirm("Voulez-vous vraiment supprimer le congé?")) {
            var id = event.id;
            $.ajax({
              url: "../evenement/delete.php",
              type: "POST",
              data: {
                id: id
              },
              success: function() {
                calendar.fullCalendar('refetchEvents');
                alert("Event Removed");
              }
            })
          }
        },

      });
    });
  </script>
</head>

<body>
  <br />

  <br />
  <div class="container">
  </div>
</body>

</html>
</script>
</head>

<body>

  <input type="button" id="retour" onclick=window.location.href='../identification/congesAbs2.php' ; value="Retour">

  <input type="button" id="deco" onclick=window.location.href='../identification/admin.php' ; value="Déconnexion">

  <p id="t"><?php echo ("Gestion des congés")
            ?>
  </p> </br>

  <div id='calendar'></div>

</body>

</html>