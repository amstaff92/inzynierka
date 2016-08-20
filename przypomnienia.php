<script type="text/javascript">
	$(function() {
		$("table").tablesorter({
			sortList: [[3,1]],

		});
	});
</script>

      <div id="content">

      	<?php if(!isset($_SESSION['dane'])){
	      		echo "Zaloguj się!";
	      		exit();
      		}
      	?>
        
        <h1>Przypomnienia</h1>


        <?php
        			@require_once "mysql.php";

					if(isset($_GET['co']) && $_GET['co'] == "dodaj") {

					$ktr = $_GET['ktr'];

					$zap = "SELECT * FROM obiekty 
							JOIN uzytkownicy ON ob_uzy_id = uzy_id
							WHERE ob_id = $ktr";

					$wykonaj = @mysql_query($zap);

					$row = mysql_fetch_assoc($wykonaj);

					?>

						<form method="POST" action="?id=przypomnienia&co=dodaj2">

									<input type="hidden" name="ktory" value="<?php echo $ktr; ?>">

									  <div class="form-group">
										<label for="nazwa">Właściciel</label>
										<input type="text" class="form-control" value="<?php echo $row['uzy_imie_nazw']; ?>" id="nazwa" name="nazwa" required>
									  </div>
									  
									  <div class="form-group">
										<label for="mail">E-mail</label>
										<input type="mail" class="form-control" value="<?php echo $row['uzy_mail']; ?>" id="rodzaj" name="mail" required>
									  </div>

									  <div class="form-group">
										<label for="tresc">Treść wiadomości</label>
										<textarea class="form-control" rows="6" id="tresc" name="tresc" required></textarea>
									  </div>

									  <button type="submit" name="dodaj2" id="btnWyslijPrzypomnienieSubmit" class="btn btn-success">WYŚLIJ przypomnienie</button>
										<input type="button" id="wyczysc" class="btn btn-default" value="Wyczyść">
									</form>
									<br>

					<?php } 

						if(isset($_GET['co']) && $_GET['co'] == "dodaj2") {

							$nazwa = Utils::getValue("nazwa");
							$mail = Utils::getValue("mail");
							$tresc = Utils::getValue("tresc");
							$ktr = Utils::getValue("ktory");

							$naglowki  = "X-PHP-Script: nono\r\n";
							$naglowki .= "MIME-Version: 1.0\r\n";
							$naglowki .= "Content-type: text/html; charset=utf-8\r\n";
							$naglowki .= "From: BUD-POZ <mateuszsobczak1@wp.pl>\r\n";

							$tytul = "Przypomnienie BUD-POZ";

							@mail("$nazwa <$mail>", $tytul, $tresc, $naglowki);

							$zap = "INSERT INTO przypomnienia(przyp_ob_id, przyp_data_wys) 
													   VALUES($ktr, CURRENT_DATE)";

							$rejestruj = @mysql_query($zap);
							
							if(@mysql_affected_rows() > 0){
								echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">WYSŁANO!</p>";
							} else {
								echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy wysyłaniu!</p>";
							}


						}

						//potwierdzanie
						if(isset($_GET['potwierdz'])) {

							$ktr = Utils::getValue("potwierdz");

							$zap = "UPDATE przypomnienia SET 
									przyp_data_odczyt = CURRENT_DATE
									WHERE przyp_id = $ktr";

							mysql_query($zap);

							if(@mysql_affected_rows() > 0){
								echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">POTWIERDZONO!</p>";
							} else {
								echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy potwierdzaniu!</p>";
							}

						}

					?>

		<table id="rowspan" cellspacing="0" class="tablesorter">
		<thead>
			<tr>
				<th>Właściciel</th>
				<th>Obiekt</th>
				<th>E-mail</th>
				<th>Data wysłania</th>
				<th>Data potw.</th>
			</tr>
		</thead>
		<tbody>
		<?php

			require_once "mysql.php";

			$ajdik = $_SESSION['dane']['uzy_id'];

			$zap = "SELECT * FROM przypomnienia
					JOIN obiekty ON przyp_ob_id = ob_id
					JOIN uzytkownicy ON ob_uzy_id = uzy_id";

			if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 0) {	
				$zap .= " WHERE ob_uzy_id = $ajdik";
			}

			@mysql_query("SET NAMES 'utf8'");

			$wyk = mysql_query($zap);

			while($row = mysql_fetch_assoc($wyk)){
				echo "<tr>";

				echo "<td>";
				echo $row['uzy_imie_nazw'];
				echo "</td>";

				echo "<td>";
				echo $row['ob_nazwa'];
				echo "</td>";

				echo "<td>";
				echo $row['uzy_mail'];
				echo "</td>";


				$datetime1 = new DateTime($row['przyp_data_wys']);
				$datetime2 = new DateTime(date("Y-m-d"));
				$interval = $datetime1->diff($datetime2);
				$ile = $interval->format('%a');

				echo "<td>";
				if($ile >= 7 && strlen($row['przyp_data_odczyt']) <= 0){
					echo "<font color='red'>";
					echo $row['przyp_data_wys'];
					echo "</font>";
				} else {
					echo $row['przyp_data_wys'];
				}
				
				echo "</td>";

				echo "<td>";
				if(strlen($row['przyp_data_odczyt']) > 0){
					echo $row['przyp_data_odczyt'];
				} else {
					echo "";
					echo " <button onclick=\"javascript:location.href='?id=przypomnienia&potwierdz={$row['przyp_id']}'\" type=\"button\" class=\"btn btn-xs btn-info\">Potwierdź</button>";
				}
				echo "</td>";

				echo "</tr>";
			}

		?>
	</tbody>
</table>

		

</div>
