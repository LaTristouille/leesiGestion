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
	   <link href='../css/cssConges.css' rel='stylesheet' />
    <link href='../css/core/main.css' rel='stylesheet' />
    <link href='../css/daygrid/main.css' rel='stylesheet' />

    <script src='../identification/core/main.js'></script>
    <script src='../identification/daygrid/main.js'></script>
	<script src='../identification/inte.js'></script>
	  <script src='../identification/interaction/main.esm.js'></script>
	  	  <script src='../identification/interaction/main.min.js'></script>
	  	  <script src='../identification/interaction/main.js'></script>
	  <script src='../identification/interaction/inte.js'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
 
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: '../evenements/loadAbsences.php' ,
		
 selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Nom de l'absent : ");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"../evenements/insertAbsences.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Absence ajoutée");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"../evenements/updateAbsences.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Absence modifiée');
      }
     })
    },
	   
    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"../evenements/updateAbsences.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Absence déplacée");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Voulez-vous vraiment supprimer l'absence ?"))
     {
      var id = event.id;
      $.ajax({
       url:"../evenements/deleteAbs.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Absence supprimée");
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
	 <input type="button" id="retour"  onclick=window.location.href='../identification/congesAbs2.php'; value="Retour"  >
	
	<input type="button" id="deco"  onclick=window.location.href='../identification/admin'; value="Déconnexion"  > 
	  
	  <p id="t"><?php echo ("Calendrier des absences")
	?> 
	     </p>

    <div id='calendar'></div>
	  
  </body>
</html>