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
        
        <h1>Obiekty</h1>

        <button type="button" id="btnDodajObiekt" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Dodaj obiekt</button>
		
		<br>
        <?php

			@require_once 'mysql.php';
						
			@mysql_query("SET names 'utf8'");
        	
        		// DODAWANIE
				if(isset($_POST['rejestracja'])) {
				
					$fnazwa = Utils::getValue("nazwa");
					$fadres = Utils::getValue("adres");
					$frodzaj = Utils::getValue("rodzaj");
					$fuzyid = Utils::getValue("kto");
					

							$zap = "INSERT INTO obiekty(ob_uzy_id, ob_nazwa, ob_adres, ob_rodzaj) 
													   VALUES($fuzyid, '$fnazwa', '$fadres', '$frodzaj')";

							$rejestruj = @mysql_query($zap);
							
							if(@mysql_affected_rows() > 0){
								echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">DODANO!</p>";
							} else {
								echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy dodawaniu!</p>";
							}
				
				}

				//EDYTOWANIE
				if(isset($_GET['co']) && $_GET['co'] == "edytuj") {

					$ktr = $_GET['ktr'];

					$zap = "SELECT * FROM obiekty WHERE ob_id = $ktr";

					$wykonaj = @mysql_query($zap);

					$row = mysql_fetch_assoc($wykonaj);

					?>

						<form method="POST" action="?id=obiekty&co=edytuj2">

									<input type="hidden" name="ktory" value="<?php echo $ktr; ?>">

									  <div class="form-group">
										<label for="nazwa">Nazwa</label>
										<input type="text" class="form-control" value="<?php echo $row['ob_nazwa']; ?>" id="nazwa" name="nazwa" required>
									  </div>
									  
									  <div class="form-group">
										<label for="rodzaj">Rodzaj</label>
										<input type="text" class="form-control" value="<?php echo $row['ob_rodzaj']; ?>" id="rodzaj" name="rodzaj" required>
									  </div>

									  <div class="form-group">
										<label for="adres">Adres</label>
										<input type="text" class="form-control" value="<?php echo $row['ob_adres']; ?>" id="adres" name="adres" required>
									  </div>

									  <div class="form-group">
										<label for="kto">Właściciel</label>
										<select id="kto" name="kto" class="form-control">
											<?php
												$wyk = mysql_query("SELECT uzy_id, uzy_imie_nazw FROM uzytkownicy");
												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['uzy_id'];
													echo "'";
													if($row['ob_uzy_id'] == $row2['uzy_id']) echo "selected";
													echo ">";
													echo $row2['uzy_imie_nazw'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <button type="submit" name="edytuj" id="btnEdytujObiektSubmit" class="btn btn-warning">EDYTUJ</button>
									
									</form>

				<?php
				}

				if(isset($_GET['co']) && $_GET['co'] == "edytuj2") {

					$fnazwa = Utils::getValue("nazwa");
					$fadres = Utils::getValue("adres");
					$frodzaj = Utils::getValue("rodzaj");
					$fuzyid = Utils::getValue("kto");
					$ktr = Utils::getValue("ktory");

					$zap = "UPDATE obiekty SET 
							ob_nazwa = '$fnazwa',
							ob_adres = '$fadres',
							ob_rodzaj = '$frodzaj',
							ob_uzy_id = $fuzyid
							WHERE ob_id = $ktr";

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

					$zap = "DELETE FROM obiekty WHERE ob_id = $ktr";

					$wykonaj = @mysql_query($zap);
							
					if(@mysql_affected_rows() > 0){
						echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">USUNIĘTO!</p>";
					} else {
						echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy usuwaniu!</p>";
					}

				}

			?>
	        
	        <div id="dodawanieObiektu"><br>
	 
									<form method="POST" action="?id=obiekty">
									  <div class="form-group">
										<label for="nazwa">Nazwa</label>
										<input type="text" class="form-control" id="nazwa" name="nazwa" required>
									  </div>
									  
									  <div class="form-group">
										<label for="rodzaj">Rodzaj</label>
										<input type="text" class="form-control" id="rodzaj" name="rodzaj" required>
									  </div>

									  <div class="form-group">
										<label for="adres">Adres</label>
										<input type="text" class="form-control" id="adres" name="adres" required>
									  </div>

									  <div class="form-group">
										<label for="kto">Właściciel</label>
										<select id="kto" name="kto" class="form-control">
											<?php
												$wyk = mysql_query("SELECT uzy_id, uzy_imie_nazw FROM uzytkownicy");
												while($row = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row['uzy_id'];
													echo "'>";
													echo $row['uzy_imie_nazw'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <button type="submit" name="rejestracja" id="btnDodajKlientaSubmit" class="btn btn-success">DODAJ</button>
									
									</form>
									<br>
		      </div>


		<table id="rowspan" cellspacing="0" class="tablesorter">
	<thead>
		<tr>
			<th>Nazwa</th>
			<th>Adres</th>
			<th>Rodzaj</th>
			<th>Właściciel</th>
			<th>Akcje</th>
		</tr>
	</thead>
	<tbody>
		<?php

			require_once "mysql.php";

			$zap = "SELECT * FROM obiekty
					JOIN uzytkownicy ON uzy_id = ob_uzy_id";

			@mysql_query("SET NAMES 'utf8'");

			$wyk = mysql_query($zap);

			while($row = mysql_fetch_assoc($wyk)){
				echo "<tr>";

				echo "<td>";
				echo $row['ob_nazwa'];
				echo "</td>";

				echo "<td>";
				echo $row['ob_adres'];
				echo "</td>";

				echo "<td>";
				echo $row['ob_rodzaj'];
				echo "</td>";

				echo "<td>";
				echo $row['uzy_imie_nazw'];
				echo "</td>";

				echo "<td style='width: 150px' class='text-center'>";
				echo "<button type=\"button\" onclick=\"javascript:location.href='?id=obiekty&co=edytuj&ktr={$row['ob_id']}'\" class=\"btn btn-xs btn-warning\"><span class=\"glyphicon glyphicon-edit\"></span> Edytuj</button>";
				echo " <button type=\"button\" onclick=\"javascript:location.href='?id=obiekty&co=usun&ktr={$row['ob_id']}'\" class=\"btn btn-xs btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span> Usuń</button>";
				echo "</td>";

				echo "</tr>";
			}

		?>
	</tbody>
</table>

		

</div>
