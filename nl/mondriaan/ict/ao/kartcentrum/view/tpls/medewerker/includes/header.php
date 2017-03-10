<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Kartcentrum</title>
        <link rel="STYLESHEET" href="css/kartcentrum.css" type="text/css">
        <link rel="STYLESHEET" href="css/medewerker.css" type="text/css">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
      <script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
      <script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.css"></script>
      <script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-sliderAccess.js"></script>
        
        
        
        <script>
  $( function() {
    $( ".js-datepicker" ).datepicker({
        dateFormat:'dd-mm-yy'
        
    });
    
    $('.js-timepicker').timepicker();
  } );
  </script>
    </head>
    <body>
        <header>
            <figure>
                <img src="img/logo.png" alt="kartcentrum" />
            </figure>
            <div>
                <p><h1>Kartcentrum <span>MAX</span></h1></p>
                <p>Beleef het avontuur dat karten heet! Ingelogd als <?=$gebruiker->getNaam();?> </p>   
                <?=isset($boodschap)?"<p id = 'boodschap'><em>$boodschap</em></p>":""?>               
            </div>
        </header>
        <section>

    
