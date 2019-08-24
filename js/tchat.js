"use strict";

//page chargée 
$(document).ready(function(){

	function getMessages() {
		$.ajax({
			url: './php/view_message.php',
			methode : 'GET',
			dataType : 'json',
			success: function(json){

				$("#messages").html('');

				for(var i=0; i<json.length; i++) {

					var msg = $('<div></div>').addClass('message');

					msg.append(
						'<div>'+ json[i].username +' ( '+ json[i].datetime_post + ' ) </div>' + 
						'<div>' + json[i].message + '</div>'
					);
					//faire un if + 
					var id_session = $("#user_id").text().trim();
					console.log(json[i].user_id);
					console.log(id_session);
					if (id_session == json[i].user_id){
						var btn_delete = $('<button></button>').addClass('btn_delete').attr('data-id', json[i].id).text('Supprimer');
						
						msg.append(btn_delete);

						var datetime_post = new Date(json[i].datetime_post);
						var datetime_exp = new Date(datetime_post.getTime() + 5*60000);
						var datetime_now = new Date();

						if(datetime_now > datetime_exp || json[i].message === "Message supprimé"){
							btn_delete.attr('disabled', true);
						}			
					}

					$("#messages").append(msg);



				}//fin du for
			},//fin success

			error: function(a,b,c){
				console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
			}//fin error


		}); //fin ajax
	}//fin fonction
	
	///////////////////////////////clic sur le bouton
	$('#msg-form').submit(function(e){

		e.preventDefault();
		//var user_id = $('#user_id').html();
		//console.log(user_id);
		var message = $('#message').val();
		//console.log(message);

		//ajout du message dans la bdd
		$.ajax({
			url:'./php/add_message.php',
			method:'POST',
			data: {
				
				message : message,
			},
			success: function(retour){

				// console.log(retour);
			},

			error: function(a,b,c){
				console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
			}//fin error
			
		});//fin ajax
		
		//supprime le loader
		$("#loading").replaceWith("<div class='message'></div>");
		
		//affichage du message
		getMessages();

		//vide le textarea
		$("#message").replaceWith("<textarea name='message' id='message' required></textarea>");

	});//fin fonction du bouton envoyer

	var interval = setInterval(getMessages, 2000);

	//bouton delete
	$("#screen").on("click", ".btn_delete", function(e) {
 		$(alert("Pouet"));
 		console.log(this);
 		var id_msg = $(this).attr('data-id');


 		//remplacement du message dans la bdd
		$.ajax({
			url:'./php/del_message.php',
			method:'POST',
			data: {	id : id_msg },

			success: function(retour){
				console.log(retour);
			},

			error: function(a,b,c){
				console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
			}//fin error
			
		});//fin ajax
 		
	});

});//FIN