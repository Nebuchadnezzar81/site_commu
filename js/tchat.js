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
					$("#messages").append(
						'<div class="message">'+
							'<div>'+json[i].username+' ( '+ json[i].datetime_post + ' ) </div>' + 
							'<div>' + json[i].message + '</div>' +
							'<button class="btn_delete" data-id="'+json[i].id+'">Supprimer</button>' +
						'</div>'
					);
				}

				
				console.log(json);
			},

			error: function(a,b,c){
				console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
			}//fin error


		}); //fin ajax
	}//fin fonction
	
	//clic sur le bouton
	$('#msg-form').submit(function(e){

		e.preventDefault();
		//var user_id = $('#user_id').html();
		//console.log(user_id);
		var message = $('#message').val();

		
		console.log(message);

		//ajout du message dans la bdd
		$.ajax({
			url:'./php/add_message.php',
			method:'POST',
			data: {
				//user_id : user_id,
				message : message,
			},
			success: function(retour){

				console.log(retour);
			},

			error: function(a,b,c){
				console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
			}//fin error
			
		});//fin ajax
		var username =$('#username').html();
		//supprime le loader
		$("#loading").replaceWith("<div class='message'></div>");

		//ajoute le message
		//$(".message").append("<span><strong>"+ username +"</strong> : " + message + "</span><input type='reset' name='reset' value='Supprimer' class='button btn_delete'/><br>");
		//vide le textarea
		$("#message").replaceWith("<textarea name='message' id='message' required></textarea>");

		//affichage du message
		getMessages();
		

	});//fin fonction du bouton envoyer

	var interval = setInterval(getMessages, 2000);



	//bouton delete
	// $('.btn_delete').click(function(e){

	// 	$(this).attr('data-id').remove();





	// })


	//suppression du bouton au bout de 5 min
	// function supBtn() {


	// }

	//var intSupBtn = setInterval(supBtn, 300000);

	// $('#msg-form').reset(function(e){

	// 	e.preventDefault();
	// 	//var user_id = $('#user_id').html();
	// 	//console.log(user_id);
	// 	var message = $('#message').val();
		
	// 	console.log(message);


	// 	$.ajax({
	// 		url:'./php/del_message.php',
	// 		method:'POST',
	// 		data: {
	// 			//user_id : user_id,
	// 			message : message,
	// 		},
	// 		success: function(retour){

	// 			console.log(retour);
	// 		},

	// 		error: function(a,b,c){
	// 			console.log('erreur ajout msg : ' + a + ' / ' + b + ' / ' + c);
	// 		}//fin error
			
	// 	});//fin ajax
	// 	var username =$('#username').html();
	// 	//supprime le loader
	// 	$("#loading").replaceWith("<div class='message'></div>");

	// 	//ajoute le message
	// 	$(".message").append("<span class='removable'><strong>"+ username +"</strong> : " + message + "</span><input type='reset' name='reset' value='Supprimer' class='button btn_delete'/><br>");
	// 	//vide le textarea
	// 	$("#message").replaceWith("<textarea name='message' id='message' required></textarea>");


});//FIN