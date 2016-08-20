<div id="content">

	<h1>Kontakt z BUD-POŻ</h1>

	Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. <br>
      	Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki.<br>
      	 Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. <br>
      	 Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, 
      	 a ostatnio z zawierającym różne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druków na komputerach osobistych, 
      	 jak Aldus PageMaker.<br><br>

	<?php

		if(isset($_POST['kontakt'])){

			$odKogo = $_POST['Email1'];
			$imie = $_POST['ImieNazw'];
			$tresc = $_POST['Tresc'];

			$naglowki  = "X-PHP-Script: nono\r\n";
			$naglowki .= "MIME-Version: 1.0\r\n";
			$naglowki .= "Content-type: text/html; charset=utf-8\r\n";
			$naglowki .= "From: $imie <$odKogo>\r\n";

			$tytul = "Kontakt BUD-POZ";

			@mail("BUD-POZ <mateuszsobczak1@wp.pl>", $tytul, $tresc, $naglowki);

			echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">WYSŁANO!</p>";

		} else {

	?>

	<form action="?id=kontakt" method="POST">
			
			<div class="form-group">
				<label for="Email1">E-mail</label>
				<input type="email" class="form-control" id="Email1" value="<?php echo isset($_SESSION['dane']['uzy_mail']) ? $_SESSION['dane']['uzy_mail'] : ""; ?>" name="Email1" placeholder="E-mail" required <?php if(isset($_SESSION['dane']['uzy_mail'])) { echo "readonly"; } ?>>
			</div>
							  
			<div class="form-group">
				<label for="ImieNazw">Imię i nazwisko</label>
				<input type="text" class="form-control" id="ImieNazw" value="<?php echo isset($_SESSION['dane']['uzy_imie_nazw']) ? $_SESSION['dane']['uzy_imie_nazw'] : ""; ?>" name="ImieNazw" placeholder="Imię i nazwisko" required <?php if(isset($_SESSION['dane']['uzy_mail'])) { echo "readonly"; } ?>>
			</div>

			<div class="form-group">
				<label for="Tresc">Treść wiadomości</label>
				<textarea class="form-control" id="Tresc" name="Tresc" placeholder="Treść" required></textarea>
			</div>

			<button type="submit" name="kontakt" id="kontakt" class="btn btn-info">Wyślij</button>
	</form>

	<?php
		}
	?>

</div>