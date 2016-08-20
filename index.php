<?php error_reporting(0);
ob_start();
session_start();
 ?>

<!DOCTYPE html>
<html>

<head>
  <title><?php 
	if (isset($_GET['id'])) { 
    $tytul = strtolower(strip_tags($_GET['id']));
		echo ucfirst($_GET['id']); 
	} else { 
		echo "Strona główna"; 
	} 
  include "utils.php";
?></title>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
  <link rel="stylesheet" href="style/blue/style.css" type="text/css" id="" media="print, projection, screen" />
  <link rel="stylesheet" type="text/css" href="style/bootstrap.css" />
  
  <script src="js/jquery-1.9.1.min.js"></script>
  <script src="js/jquery-latest.js"></script>
  <script src="js/jquery.tablesorter.js"></script>
  <script src="js/akcje.js"></script>

</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          
          <h1><a href="index.php">BUD-<span class="logo_colour">POŻ</span></a></h1>
          <h2>SYSTEM INTERNETOWY WSPOMAGAJĄCY DZIAŁAŁNOŚĆ FIRMY BUDPOŻ</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          
          <li class="<?php if($tytul == "home" || $tytul == "") echo "selected"; ?>"><a href="index.php">Home</a></li>
          <li class="<?php if($tytul == "oferta") echo "selected"; ?>"><a href="?id=oferta">Oferta</a></li>
          <li class="<?php if($tytul == "przepisy") echo "selected"; ?>"><a href="?id=przepisy">Przepisy</a></li>
          <li class="<?php if($tytul == "kontakt") echo "selected"; ?>"><a href="?id=kontakt">Kontakt</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
     
	  <div id="sidebar_container">

        <div class="sidebar">

          <?php if(!isset($_SESSION['dane'])) { ?>

            <form class="form-horizontal" action="?id=zaloguj" method="POST">
            <div class="form-group">
              <label class="control-label col-sm-3" for="Email1">Mail:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="Email1" name="Email1" placeholder="E-mail" required>
              </div>
            </div>
                      
            <div class="form-group">
              <label class="control-label col-sm-3" for="Password1">Hasło:</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="Password1" name="Password1" placeholder="Hasło" required>
              </div>
            </div>

            <p class="text-right">
              <button type="submit" name="logowanie" id="logowanie" class="btn btn-default">Zaloguj się</button>
            </p>
          </form>

          <?php } else { ?>

          <p class="alert alert-default text-right" style="padding: 10px;">
              Zalogowany jako <br><b><?php echo $_SESSION['dane']['uzy_imie_nazw']; ?></b>
              <?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) { ?>
                <br><span class="badge">ADMINISTRATOR</span>
              <?php } else { ?>
                <br><span class="badge">KLIENT</span>
              <?php } ?>
              <br>
              <?php echo $_SESSION['dane']['uzy_mail']; ?>
              <br>
              <a href="?id=zaloguj&akcja=wyloguj"><u>Wyloguj się</u></a>
          </p>

          <?php } ?>

        </div>

      </div>

      <?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) { ?>

        <button type="button" onclick="javascript:location.href='?id=dokumenty'" class="btn btn-<?php if($tytul == "dokumenty"){ echo "primary"; } else { echo "default"; } ?>">Dokumenty</button>
        <button type="button" onclick="javascript:location.href='?id=klienci'" class="btn btn-<?php if($tytul == "klienci"){ echo "primary"; } else { echo "default"; } ?>">Klienci</button>
        <button type="button" onclick="javascript:location.href='?id=obiekty'" class="btn btn-<?php if($tytul == "obiekty"){ echo "primary"; } else { echo "default"; } ?>">Obiekty</button>
        <button type="button" onclick="javascript:location.href='?id=przypomnienia'" class="btn btn-<?php if($tytul == "przypomnienia"){ echo "primary"; } else { echo "default"; } ?>">Przypomnienia</button>
        <br><br>

      <?php } else if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 0){ ?>

      <button type="button" onclick="javascript:location.href='?id=dokumenty'" class="btn btn-info">Dokumenty</button>
      <button type="button" onclick="javascript:location.href='?id=przypomnienia'" class="btn btn-info">Przypomnienia</button>
      <br><br>

      <?php } ?>

  		<?php
    		if (isset($_GET['id'])) {
    			$co = strip_tags($_GET['id']);
    			if(file_exists($co.".php")){
    				include $co.".php";
    			} else {
    				echo "Plik nie istnieje!";
    			}
    		} else {
      ?>

    <div id="content">
        
    <h1>Strona główna</h1>
		
		<p>
		
		Witaj na stronie głównej!
		<br><br><br>
		Konto z prawami <b>administratora:</b> admin@admin.pl, admin
		<br><br>
		Konto z prawami <b>klienta:</b> test@test.pl, test
		
		</p>
		
    </div>

    <?php
    }
    ?>
      
    </div>
    <div id="content_footer"></div>
    <div id="footer">
      <p>Wszystkie prawa zastrzezone © 2015</p>
    </div>
  </div>
  
 
<script language="JavaScript" type="text/javascript"> 
<!-- 
function s4upl() { return "&amp;r=er";} 
//--> 
</script> 
<script language="JavaScript" type="text/javascript"> 
<!-- 
s4uext=s4upl(); 
document.write('<img alt="stat4u" src="http://stat.4u.pl/cgi-bin/s.cgi?i=projsob'+s4uext+'" width="1" height="1">') 
//--> 
</script> 
<noscript><img alt="stat4u" src="http://stat.4u.pl/cgi-bin/s.cgi?i=projsob&amp;r=ns" width="1" height="1"></noscript> 

</body>
</html>
<?php
ob_end_flush();
?>