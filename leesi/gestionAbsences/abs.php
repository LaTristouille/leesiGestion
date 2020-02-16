<?php require_once('../db/connexion.php'); session_start();
?>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
<script>
	 import { Calendar } from 'core';
	import interactionPlugin from 'interaction'; // for selectable
import dayGridPlugin from 'daygrid'; 
	
	  </script>  
	   <link href='../identification/cssConges.css' rel='stylesheet' />
    <link href='../identification/core/main.css' rel='stylesheet' />
    <link href='../identification/daygrid/main.css' rel='stylesheet' />

    <script src='../identification/core/main.js'></script>
    <script src='../identification/daygrid/main.js'></script>
	<script src='../identification/inte.js'></script>
	  <script src='../identification/interaction/main.esm.js'></script>
	  	  <script src='../identification/interaction/main.min.js'></script>
	  	  <script src='../identification/interaction/main.js'></script>
	  <script src='../identification/interaction/inte.js'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/moment.js"></script>
  <script src="../js/fullcalendar.js"></script>
 
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: '../evenement/loadAbsences.php'})  });
		
    </script>
  </head>
  <body>
	  
	  	<br />
	 <input type="button" id="retour"  onclick=window.location.href='../identification/congesAbsences.php'; value="Retour"  >
	
	<input type="button" id="deco"  onclick=window.location.href='../identification/employe'; value="Déconnexion"  > 
	  
	  <p id="t"><?php echo ("Calendrier des absences")
	?> 
	     </p> 
	     

    <div id='calendar'></div>
	  
  </body>
</html>