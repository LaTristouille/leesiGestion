<?php require_once('C:\wamp64\www\leesi\connexion.php'); session_start();
?>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
<script>
	 import { Calendar } from 'core';
	import interactionPlugin from 'interaction'; // for selectable
import dayGridPlugin from 'daygrid'; 
	
	  </script>  
	   <link href='cssConges.css' rel='stylesheet' />
    <link href='core/main.css' rel='stylesheet' />
    <link href='daygrid/main.css' rel='stylesheet' />

    <script src='core/main.js'></script>
    <script src='daygrid/main.js'></script>
	<script src='inte.js'></script>
	  <script src='interaction/main.esm.js'></script>
	  	  <script src='interaction/main.min.js'></script>
	  	  <script src='interaction/main.js'></script>
	  <script src='interaction/inte.js'></script>
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
    events: 'loadAbsences.php' ,
		
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
       url:"insertAbsences.php",
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
      url:"updateAbsences.php",
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
      url:"updateAbsences.php",
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
       url:"deleteAbs.php",
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
	 <input type="button" id="retour"  onclick=window.location.href='http://localhost/leesi/iden/congesAbs2.php'; value="Retour"  >
	
	<input type="button" id="deco"  onclick=window.location.href='http://localhost/leesi/iden/identification2'; value="Déconnexion"  > 
	  
	  <p id="t"><?php echo ("Calendrier des absences")
	?> 
	     </p>

    <div id='calendar'></div>
	  
  </body>
</html>