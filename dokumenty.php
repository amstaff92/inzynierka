<script type="text/javascript">
	$(function() {
		$("table").tablesorter({
			sortList: [[6,1]],
			headers: { 
	            7: { 
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
        
        <h1>Dokumenty</h1>

        <?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) { ?>
        <button type="button" id="btnDodajDokument" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Dodaj dokument</button>
		<?php } ?>

		<br>
        <?php

			@require_once 'mysql.php';
						
			@mysql_query("SET names 'utf8'");
        	
        		// DODAWANIE
				if(isset($_POST['rejestracja'])) {
				
					$fobi = Utils::getValue("obi");
					$frodz = Utils::getValue("rodzaj");
					$fdatau = Utils::getValue("datau");
					$fdataa = Utils::getValue("dataa");
					$wplik = isset($_FILES['plik']['name']) ? $_FILES['plik']['name'] : "";
				
					$wplik = str_replace(" ", "_", $wplik);

					if(strlen($wplik)>0){
						$wplik2 = substr(md5(time()), 0, -28)."-".substr(md5($fobi), 0, 4)."-".strip_tags($wplik);
					} else {
						$wplik2 = "";
					}
					
					@move_uploaded_file($_FILES['plik']['tmp_name'], "upload/$wplik2");

							$zap = "INSERT INTO dokumenty(dok_ob_id, dok_data_utw, dok_data_akt, dok_rodzaj_id, dok_plik) 
													   VALUES($fobi, '$fdatau', '$fdataa', $frodz, '$wplik2')";

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

					$zap = "SELECT * FROM dokumenty 
							JOIN obiekty ON dok_ob_id = ob_id
							WHERE dok_id = $ktr";

					$wykonaj = @mysql_query($zap);

					$row = mysql_fetch_assoc($wykonaj);

					?>

						<form method="POST" action="?id=dokumenty&co=edytuj2">

									<input type="hidden" name="ktory" value="<?php echo $ktr; ?>">
									<br>
									    <?php /*<div class="form-group">
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
									  */ ?>

									  <div class="form-group">
										<label for="kto">Nazwa obiektu</label>
										<select id="kto" name="obi" class="form-control">
											<?php
												$wyk = mysql_query("SELECT * FROM obiekty");
												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['ob_id'];
													echo "'";
													if($row['dok_ob_id'] == $row2['ob_id']) echo "selected";
													echo ">";
													echo $row2['ob_nazwa'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <div class="form-group">
										<label for="kto">Rodzaj dokumentu</label>
										<select id="kto" name="rodz" class="form-control">
											<?php
												$wyk = mysql_query("SELECT * FROM rodzaje_dok");
												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['rodz_id'];
													echo "'";
													if($row['dok_rodzaj_id'] == $row2['rodz_id']) echo " selected";
													echo ">";
													echo $row2['rodz_nazwa'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <div class="form-group">
										<label for="nazwa">Data utw.</label>
										<input type="date" class="form-control" value="<?php echo $row['dok_data_utw']; ?>" id="nazwa" name="datau" required>
									  </div>
									  
									  <div class="form-group">
										<label for="rodzaj">Data akt.</label>
										<input type="date" class="form-control" value="<?php echo $row['dok_data_akt']; ?>" id="rodzaj" name="dataa">
									  </div>

									  <button type="submit" name="edytuj" id="btnEdytujDokumentSubmit" class="btn btn-warning">EDYTUJ</button>
									
									</form>

				<?php
				}

				if(isset($_GET['co']) && $_GET['co'] == "edytuj2") {

					//$fkto = Utils::getValue("kto");
					$fobi = Utils::getValue("obi");
					$frodz = Utils::getValue("rodz");
					$fdatau = Utils::getValue("datau");
					$fdataa = Utils::getValue("dataa");

					$ktr = Utils::getValue("ktory");

					$zap = "UPDATE dokumenty SET 
							dok_ob_id = $fobi,
							dok_data_utw = '$fdatau',
							dok_data_akt = '$fdataa',
							dok_rodzaj_id = $frodz
							WHERE dok_id = $ktr";

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

					$zap = "DELETE FROM dokumenty WHERE dok_id = $ktr";

					$wykonaj = @mysql_query($zap);
							
					if(@mysql_affected_rows() > 0){
						echo "<p class=\"alert alert-success\" role=\"alert\" style=\"padding: 10px;\">USUNIĘTO!</p>";
					} else {
						echo "<p class=\"alert alert-danger\" role=\"alert\" style=\"padding: 10px;\">BŁĄD przy usuwaniu!</p>";
					}

				}

			?>
	        
	        <div id="dodawanieDokumentu"><br>
	 
									<form method="POST" action="?id=dokumenty" enctype="multipart/form-data">
									  <?php /*<div class="form-group">
										<label for="kto">Właściciel</label>
										<select id="kto" name="kto" class="form-control">
											<?php
												$wyk = mysql_query("SELECT uzy_id, uzy_imie_nazw FROM uzytkownicy");

												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['uzy_id'];
													echo "'";
													echo ">";
													echo $row2['uzy_imie_nazw'];
													echo "</option>";
												}
											?>
										</select>
									  </div>
									  */ ?>

									  <div class="form-group">
										<label for="kto">Nazwa obiektu</label>
										<select id="kto" name="obi" class="form-control">
											<?php
												$wyk = mysql_query("SELECT * FROM obiekty");
												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['ob_id'];
													echo "'";
													echo ">";
													echo $row2['ob_nazwa'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <div class="form-group">
										<label for="kto">Rodzaj dokumentu</label>
										<select id="kto" name="rodzaj" class="form-control">
											<?php
												$wyk = mysql_query("SELECT * FROM rodzaje_dok");
												while($row2 = mysql_fetch_assoc($wyk)){
													echo "<option value='";
													echo $row2['rodz_id'];
													echo "'";
													echo ">";
													echo $row2['rodz_nazwa'];
													echo "</option>";
												}
											?>
										</select>
									  </div>

									  <div class="form-group">
										<label for="nazwa">Data utw.</label>
										<input type="date" class="form-control" value="<?php echo $row['dok_data_utw']; ?>" id="nazwa" name="datau" required>
									  </div>
									  
									  <div class="form-group">
										<label for="rodzaj">Data akt.</label>
										<input type="date" class="form-control" value="<?php echo $row['dok_data_akt']; ?>" id="rodzaj" name="dataa">
									  </div>

									   <div class="form-group">
										<label for="Plik">Załącz dokument</label>
										<input type="file" name="plik" id="Plik">
									  </div>

									  <input type="hidden" name="MAX_FILE_SIZE" value="850000000" />

									  <button type="submit" name="rejestracja" id="btnDodajDokumentSubmit" class="btn btn-success">DODAJ</button>
									
									</form>
									<br>
		      </div>


		      <br>
		      		 <form method="get" action="?id=dokumenty">
		      		 	<input type="hidden" name="id" value="dokumenty">
		      		 	<input type="text" name="wartosc"> 
		      			<select name="typ">
		      				<option value="1">Rodzaj</option>
		      				<option value="2">Nazwa</option>
		      				<?php if($_SESSION['dane']['uzy_typ'] == 1){ ?>
		      				<option value="3">Adres</option>
		      				<option value="4">Właściciel</option>
		      				<option value="5">E-mail</option>
		      				<?php } ?>
		      			</select>

		      			<input type="submit" class="btn btn-info btn-xs" value="Filtruj">
		      			<button type="button" onclick="javascript:location.href='?id=dokumenty'" class="btn btn-default btn-xs">Wyczyść</button>
		      		</form>

		<table id="rowspan" cellspacing="0" class="tablesorter">
	<thead>
		<tr>
			<th>Rodzaj</th>
			<th>Nazwa obiektu</th>
			<?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) { ?>
			<th>Adres obiektu</th>
			<th>Właściciel</th>
			<th>E-mail</th>
			<?php } ?>
			<th>Data utw.</th>
			<th>Data akt.</th>
			<?php if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) { ?>
			<th>Akcje</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php

			require_once "mysql.php";
			
			$ajdik = $_SESSION['dane']['uzy_id'];

			$zap = "SELECT * FROM dokumenty
					JOIN obiekty ON ob_id = dok_ob_id
					JOIN uzytkownicy ON uzy_id = ob_uzy_id
					JOIN rodzaje_dok ON dok_rodzaj_id = rodz_id
					";

			$co = isset($_GET['typ']) ? $_GET['typ'] : "-1";
			$wartosc = isset($_GET['wartosc']) ? $_GET['wartosc'] : "-1";
			
			if($co == 1) $zap .= "WHERE rodz_nazwa LIKE '%$wartosc%'";	
			if($co == 2) $zap .= "WHERE ob_nazwa LIKE '%$wartosc%'";	
			if($co == 3) $zap .= "WHERE ob_adres LIKE '%$wartosc%'";
			if($co == 4) $zap .= "WHERE uzy_imie_nazw LIKE '%$wartosc%'";
			if($co == 5) $zap .= "WHERE uzy_mail LIKE '%$wartosc%'";		

			if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 0) {	
				if($co != -1){
					$zap .= " AND ob_uzy_id = $ajdik";
				} else {
					$zap .= " WHERE ob_uzy_id = $ajdik";
				}
			}

			@mysql_query("SET NAMES 'utf8'");
			
			$wyk = mysql_query($zap);

			while($row = mysql_fetch_assoc($wyk)){
				echo "<tr>";

				echo "<td style='width: 60px;'>";
				echo "<a href='upload/";
				echo $row['dok_plik'];
				echo "'>";
				echo "<b>";
				echo $row['rodz_nazwa'];
				echo "</b></a>";
				echo "</td>";

				echo "<td>";
				echo $row['ob_nazwa'];
				echo "</td>";

				if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) {
					echo "<td>";
					echo $row['ob_adres'];
					echo "</td>";

					echo "<td>";
					echo $row['uzy_imie_nazw'];
					echo "</td>";

					echo "<td>";
					echo $row['uzy_mail'];
					echo "</td>";
				}

				echo "<td style='width: 75px;'>";
				echo $row['dok_data_utw'];
				echo "</td>";

				echo "<td style='width: 75px;'>";
				if($row['dok_data_akt'] == '0000-00-00'){
					echo "-";
				} else {
					echo $row['dok_data_akt'];
				}
				echo "</td>";

				if(isset($_SESSION['dane']) && $_SESSION['dane']['uzy_typ'] == 1) {
					echo "<td style='width: 150px' class='text-center'>";
					echo "<button type=\"button\" onclick=\"javascript:location.href='?id=dokumenty&co=edytuj&ktr={$row['dok_id']}'\" class=\"btn btn-xs btn-warning\"><span class=\"glyphicon glyphicon-edit\"></span> Edytuj</button>";
					echo " <button type=\"button\" onclick=\"javascript:location.href='?id=dokumenty&co=usun&ktr={$row['dok_id']}'\" class=\"btn btn-xs btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span> Usuń</button>";
					
					if($row['dok_rodzaj_id'] == 1) echo "<button type=\"button\" onclick=\"javascript:location.href='?id=przypomnienia&co=dodaj&ktr={$row['dok_ob_id']}'\" class=\"btn btn-default btn-xs\"><span class=\"glyphicon glyphicon-plus\"></span> Wyślij przypomnienie</button>";
					echo "</td>";
				}

				echo "</tr>";
			}

		?>
	</tbody>
</table>

		

</div>
