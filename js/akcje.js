$(document).ready(function() {

	$("#dodawanieKlienta").hide();
	$("#dodawanieObiektu").hide();
	$("#dodawanieDokumentu").hide();

	$("#btnDodajKlienta").click(function(){

		$("#dodawanieKlienta").toggle( "slow", function() {});

	})


	$("#btnDodajObiekt").click(function(){

		$("#dodawanieObiektu").toggle( "slow", function() {});

	})


	$("#btnDodajDokument").click(function(){

		$("#dodawanieDokumentu").toggle( "slow", function() {});

	})


	$("#wyczysc").click(function(){


		$("#nazwa").val("");
		$("#rodzaj").val("");
		$("#tresc").val("");

	})
})