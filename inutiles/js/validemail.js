function displayWrongFormatMsg()
{
	$("#msg").toggleClass("alert alert-danger");
	$("#msg").html('<p><span class="glyphicon glyphicon-exclamation-sign"></span>" Oups... Il semblerait que l\'adresse mail saisie n\'ait pas le bon format!</p>');
};

function displaySucess()
{
	$("#msg").toggleClass("alert alert-success");
	$("#msg").html('<p><span class="glyphicon glyphicon-ok-circle"></span>" Merci! Votre adresse email a bien été enregistrée!</p>');
};