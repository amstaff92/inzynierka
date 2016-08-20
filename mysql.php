<?php
//host, login, hasło
mysql_connect("localhost", "msobczak_sobczak", "sobczak") or die("Nie mogłem połączyć się z MySQL");
//nazwa bazy danych
mysql_select_db("msobczak_sobczak") or die("Błąd przy wybieraniu bazy danych");
?>