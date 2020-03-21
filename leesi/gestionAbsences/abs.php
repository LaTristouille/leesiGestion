<?php require_once('../db/connexion.php');
session_start();
?>
<html lang='en'>

<head>
  <meta charset='utf-8' />

  <link href='../css/cssConges.css' rel='stylesheet' />
  <link href='../identification/core/main.css' rel='stylesheet' />
  <link href='../identification/daygrid/main.css' rel='stylesheet' />
  <link href='../css/custom.css' rel='stylesheet' />

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

  <script>
    $(document).ready(function() {
      var calendar = $('#calendar').fullCalendar({
        header: {
         left: 'prev,next today',
          center: 'title',
          right: '',
        },
        events: '../evenement/loadAbsences.php',
      })
    });
    
  </script>
</head>

<body>

  <br />
  <input type="button" id="retour" onclick=window.location.href='../identification/congesAbsences.php' ; value="Retour">

  <input type="button" id="deco" onclick=window.location.href='../identification/employe' ; value="Déconnexion">

  <p id="t"><?php echo ("Calendrier des absences")
            ?>
  </p>


  <div id='calendar'></div>

</body>

</html>