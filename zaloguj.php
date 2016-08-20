<?php error_reporting(0);
ob_start();
@session_start();
 ?>

      <div id="content">
        
        <h1>Logowanie</h1>
		

		<?php

		$login = "";
		$pass = "";
		
		if(isset($_POST['Email1'])) $login = strip_tags($_POST['Email1']);	
		if(isset($_POST['Password1'])) $pass = strip_tags($_POST['Password1']);
		
		$pass2 = md5($pass);
		
		if(isset($_GET['akcja']) && $_GET['akcja'] == "zaloguj") {
			echo "<p class=\"alert alert-success\" style=\"padding: 10px;\">Zalogowano poprawnie!</p>";
		}
		
		if(isset($_GET['akcja']) && $_GET['akcja'] == "wyloguj2") {
			echo "<p class=\"alert alert-warning\" style=\"padding: 10px;\">Wylogowano poprawnie!</p>";
		}

		if(isset($_GET['akcja']) && $_GET['akcja'] == "wyloguj") {
		
			unset($_SESSION['dane']);
			unset($_SESSION['stan']);
			session_destroy();
			//echo "<p class=\"bg-warning\" style=\"padding: 5px;\">Wylogowano poprawnie!</p>";
			
			header("Location: ?id=zaloguj&akcja=wyloguj2");
				
		} else {
		
		
		if(isset($_POST['logowanie'])) {

			if (strlen($_POST['Email1'])<5 || strlen($_POST['Password1'])<3 || strlen($_POST['Email1'])>70 || strlen($_POST['Password1'])>32) {
			
				echo "<p class=\"alert alert-danger\" style=\"padding: 10px;\">Nieodpowiednia ilość znaków!</p>";
				
			} else {
			

			@require_once 'mysql.php';

			@mysql_query("SET names 'utf8'");

			$result = @mysql_query("SELECT * FROM  `uzytkownicy` WHERE  `uzy_mail` =  '$login' AND  `uzy_haslo` =  '$pass2'");

			if (@mysql_num_rows($result) > 0) {
				
				$_SESSION['dane'] = @mysql_fetch_assoc($result);
				$_SESSION['stan'] = 1;
				
				//echo "<p class=\"bg-success\" style=\"padding: 5px;\">Zalogowano poprawnie!</p>";
				
				header("Location: ?id=zaloguj&akcja=zaloguj");
			
			} else {
			
				echo "<p class=\"alert alert-danger\" style=\"padding: 10px;\">Dane niepoprawne!</p>";
			}
			
			
			}
		
		} else {
		
		}	
		
			if(isset($_SESSION['stan']) && $_SESSION['stan'] == 1) {
			
			?>
				
				<p class="alert alert-info" style="padding: 5px;">Zalogowany jako <b><?php echo $_SESSION['dane']['uzy_mail']; ?></b>
					<?php if($_SESSION['dane']['uzy_typ'] == 1){
							echo " (Administrator)";
						} else {
							echo "(Klient)";
						}
					?>
				<br><br>
				<?php echo $_SESSION['dane']['uzy_imie_nazw']; ?>
				<br><br>
				<a href="?id=zaloguj&akcja=wyloguj"><u>Wyloguj się</u></a>
				</p>
				
			<?php
			} else {
			?>
<!-- Ten tekst
zostanie zignorowany
przez przeglądarkę 
			Nie masz konta? <a href="?id=zarejestruj">Zarejestruj się!</a><br><br>
		
		<form action="?id=zaloguj" method="POST">
			<div class="form-group">
				<label for="Email1">E-mail</label>
				<input type="email" class="form-control" id="Email1" name="Email1" placeholder="E-mail" required>
			</div>
							  
			<div class="form-group">
				<label for="Password1">Hasło</label>
				<input type="password" class="form-control" id="Password1" name="Password1" placeholder="Hasło" required>
			</div>

			<button type="submit" name="logowanie" id="logowanie" class="btn btn-info">Zaloguj się</button>
		</form>
							-->
		<?php					
			} //jesli niezalogowany		
			
			} //akcja wyloguj
				
		?>
		

   </div>
<?php
ob_end_flush();
?>