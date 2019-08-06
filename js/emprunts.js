/* js/emprunts.js */

// page chargée?
$(document).ready(function(){
	//alert('yo');
	
	//clic sur le bouton?
	$('.rendu').on('click', function(){
		//récupération de l'ID de l'emprunt
		var heidi = this.id.substring(1);
		//alert(id);
		$.ajax({
			url: 'ajaxRendu.php',
			method: 'post',
			data: {id: heidi},
			error: function(a, b, c){
					alert('oups ' + c);				
				  },
			success: function(retour){
					alert(retour);
					//rafraichir la page (F5)
					window.location.reload();
				  }
		}); //fin ajax
	}); //fin clic bouton
}); //fin ready