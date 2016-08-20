<script type="text/javascript">
	$(function() {
		$("table").tablesorter({
			sortList: [[0,0]],
			headers: { 
	            4: { 
	                sorter: false 
	            }
        	} 
		});
	});
</script>

      <div id="content">

      	<?php if(!isset($_SESSION['dane'])){
	      		echo "Zaloguj się!";
	      		exit();
      		}
      	?>

      	<?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] != 1){
	      		echo "Brak uprawnień!";
	      		exit();
      		}
      	?>
        
        <h1>Klienci</h1>

        <button type="button" id="btnDodajKlienta" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Dodaj klienta</button>
		<br>
        <?php

			@require_once 'mysql.php';
						
			@mysql_query("SET names 'utf8'");
        	
        		// DODAWANIE
				if(isset($_POST['rejestracja'])) {
				
					$fmail = Utils::getValue("email");
					$fimie = Utils::getValue("imie");
					$fpass1 = Utils::getValue("pass1");
					$fpass2 = Utils::getValue("pass2");
					$adres = Utils::getValue("adres");
					$tel = Utils::getValue("tel");
					
					if(Utils::getLength($fmail) > 5 && Utils::getLength($fmail) < 70 &&
						Utils::getLength($fimie) > 2 && Utils::getLength($fimie) < 50 &&
						Utils::getLength($fpass1) > 4 && Utils::getLength($fpass1) < 32 &&
						$fpass1 == $fpass2){
						
							$fpass3 = md5($fpass1);

							$zap = "INSERT INTO uzytkownicy(uzy_mail, uzy_haslo, uzy_imie_nazw, uzy_typ, uzy_adres, uzy_tel) 
													   VALUES('$fmail', '$fpass3', '$fimie', 0, '$adres', '$tel')";

							$rejestruj = @mysql_query($zap);
							
							if(@mysql_affected_rows() > 0){
								echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">DODANO!</p>";
							} else {
								echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy rejestracji!</p>";
							}
							
						} else {
							echo "<p class=\"alert alert-warning\" role=\"alert\" style=\"padding: 10px;\">Niepoprawna długość wprowadzonych danych!</p>";
						}
				
				}

				//EDYTOWANIE
				if(isset($_GET['co']) && $_GET['co'] == "edytuj") {

					$ktr = $_GET['ktr'];

					$zap = "SELECT * FROM uzytkownicy WHERE uzy_id = $ktr";

					$wykonaj = @mysql_query($zap);

					$row = mysql_fetch_assoc($wykonaj);

					?>

						<form method="POST" action="?id=klienci&co=edytuj2">

									<input type="hidden" name="ktory" value="<?php echo $ktr; ?>">

									  <div class="form-group">
										<label for="Email1">E-mail</label>
										<input type="email" class="form-control" value="<?php echo $row['uzy_mail']; ?>" id="Email1" placeholder="E-mail" name="email" required>
									  </div>
									  
									  <div class="form-group">
										<label for="Imie1">Imię i nazwisko</label>
										<input type="text" class="form-control" value="<?php echo $row['uzy_imie_nazw']; ?>" id="Imie1" placeholder="Imię i nazwisko" name="imie" required>
									  </div>

									  <div class="form-group">
										<label for="Adres1">Adres zam.</label>
										<input type="text" class="form-control" value="<?php echo $row['uzy_adres']; ?>" id="Adres1" placeholder="Adres" name="adres" required>
									  </div>

									  <div class="form-group">
										<label for="Tel1">Telefon</label>
										<input type="number" class="form-control" value="<?php echo $row['uzy_tel']; ?>" id="Tel1" placeholder="Telefon" name="tel" required>
									  </div>

									  <button type="submit" name="edytuj" id="btnEdytujKlientaSubmit" class="btn btn-warning">EDYTUJ</button>
									
									</form>

				<?php
				}

				if(isset($_GET['co']) && $_GET['co'] == "edytuj2") {

					$fmail = Utils::getValue("email");
					$fimie = Utils::getValue("imie");
					$adres = Utils::getValue("adres");
					$tel = Utils::getValue("tel");
					$ktr = Utils::getValue("ktory");

					$zap = "UPDATE uzytkownicy SET 
							uzy_mail = '$fmail',
							uzy_imie_nazw = '$fimie',
							uzy_tel = '$tel',
							uzy_adres = '$adres'
							WHERE uzy_id = $ktr";

					mysql_query($zap);

					if(@mysql_affected_rows() > 0){
						echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">EDYTOWANO!</p>";
					} else {
						echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy edytowaniu!</p>";
					}

				}

				//USUWANIE
				if(isset($_GET['co']) && $_GET['co'] == "usun") {

					$ktr = $_GET['ktr'];

					$zap = "DELETE FROM uzytkownicy WHERE uzy_id = $ktr";

					$wykonaj = @mysql_query($zap);
							
					if(@mysql_affected_rows() > 0){
						echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">USUNIĘTO!</p>";
					} else {
						echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy usuwaniu!</p>";
					}

				}

			?>
	        
	        <div id="dodawanieKlienta"><br>
	 
									<form method="POST" action="?id=klienci">
									  <div class="form-group">
										<label for="Email1">E-mail</label>
										<input type="email" class="form-control" id="Email1" placeholder="E-mail" name="email" required>
									  </div>
									  
									  <div class="form-group">
										<label for="Imie1">Imię i nazwisko</label>
										<input type="text" class="form-control" id="Imie1" placeholder="Imię i nazwisko" name="imie" required>
									  </div>

									  <div class="form-group">
										<label for="Adres1">Adres zam.</label>
										<input type="text" class="form-control" id="Adres1" placeholder="Adres" name="adres" required>
									  </div>

									  <div class="form-group">
										<label for="Tel1">Telefon</label>
										<input type="number" class="form-control" id="Tel1" placeholder="Telefon" name="tel" required>
									  </div>
									  
									  <div class="form-group">
										<label for="Password1">Hasło</label>
										<input type="password" class="form-control" id="Password1" placeholder="Hasło" name="pass1" required>
									  </div>
									  
									  <div class="form-group">
										<label for="Password2">Powtórz hasło</label>
										<input type="password" class="form-control" id="Password2" placeholder="Powtórz hasło" name="pass2" required>
									  </div>

									  <button type="submit" name="rejestracja" id="btnDodajKlientaSubmit" class="btn btn-success">DODAJ</button>
									
									</form>
									<br>
		      </div>


		<table id="rowspan" cellspacing="0" class="tablesorter">
	<thead>
		<tr>
			<th>Imię i nazwisko</th>
			<th>E-mail</th>
			<th>Telefon</th>
			<th>Adres zamieszkania</th>
			<th>Akcje</th>
		</tr>
	</thead>
	<tbody>
		<?php

			require_once "mysql.php";

			$zap = "SELECT * FROM uzytkownicy WHERE uzy_typ = 0";

			@mysql_query("SET NAMES 'utf8'");

			$wyk = mysql_query($zap);

			while($row = mysql_fetch_assoc($wyk)){
				echo "<tr>";

				echo "<td>";
				echo $row['uzy_imie_nazw'];
				echo "</td>";

				echo "<td>";
				echo $row['uzy_mail'];
				echo "</td>";

				echo "<td>";
				echo $row['uzy_tel'];
				echo "</td>";

				echo "<td>";
				echo $row['uzy_adres'];
				echo "</td>";

				echo "<td style='width: 150px' class='text-center'>";
				echo "<button type=\"button\" onclick=\"javascript:location.href='?id=klienci&co=edytuj&ktr={$row['uzy_id']}'\" class=\"btn btn-xs btn-warning\"><span class=\"glyphicon glyphicon-edit\"></span> Edytuj</button>";
				echo " <button type=\"button\" onclick=\"javascript:location.href='?id=klienci&co=usun&ktr={$row['uzy_id']}'\" class=\"btn btn-xs btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span> Usuń</button>";
				echo "</td>";

				echo "</tr>";
			}

		?>
	</tbody>
</table>

		

</div>
