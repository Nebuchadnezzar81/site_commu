"use strict";

//$(document).ready(function(){
	//afficheConversation();
      
   //bouton envoyer
  //  	$('#envoi').click(function(e) {
   	
  //  		e.preventDefault();
  //       var nom = $('#pseudo').val();//récupére valeur pseudo
  //       var message = $('#message').val(); //recupére valeur message

  //       //supprime le loading
		// $("#loading").replaceWith("<div class='message'></div>");
        
 
  //       //ajoute une div avec les messages
  //       $(".message").append("<span class='removable'>" + '<strong>' + nom +'</strong>' + ' : ' + " " + message + "</span><input type='reset' name='reset' value='Supprimer' class='button btn_delete'/><br>");

 	// 	//scroll *-*-*-*-*-* ne fonctionne plus
 	// 	//récupère la hauteur de la div messages
	 // 	var height = $('#messages').height();
	 // 	//scroll à partir de la hauteur de l'élément
	 // 	$('#screen').scrollTop(height);
    
  //   });

    //bouton annuler vide les champs et remplace par un message "votre message est bien supprimé"
	    //$(".btn_delete").click(function(e){
	    	//$('.message').closest('.removable').replaceWith("<span class='modified'>Votre message est bien supprimé</span>");
	    	//$(this).closest('.removable').remove();
	    	//$(".removable").replaceWith("<span class='modified'>Votre message est bien supprimé</span>");
	   		//var reset = $(".message").val("");
	   		//$("#messages").html('');
	  	//});

	 //Son
	//  var audio = new Audio('clochette.mp3');

	// 	//chekbox
 //         var msg = $('#message');
         
 //         msg.keypress(function(e){
	// 		console.log(e.keyCode);
	// 		//condition si touche check appuyé
	// 		if (e.keycode === 10) {
	// 			e.preventDefault();
	// 			msg.append('\n\r');

	// 		};

	// 		//condition si check non appuyé
	// 		 if(e.keycode === 13) {
	// 		 	if($('#form-check-input').prop("checked")){
	// 		 		e.preventDefault();
	// 		 	}

	// 		 };


 //         });
 // });

//page chargée 
$(document).ready(function(){
	
	//clic sur le bouton
	$('#msg-form').submit(function(e){

		e.preventDefault();
		//var user_id = $('#user_id').html();
		//console.log(user_id);
		var message = $('#message').val();
		
		console.log(message);


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
		$(".message").append("<span><strong>"+ username +"</strong> : " + message + "</span><input type='reset' name='reset' value='Supprimer' class='button btn_delete'/><br>");
		//vide le textarea
		$("#message").replaceWith("<textarea name='message' id='message' required></textarea>");

	});//fin fonction du bouton envoyer

	// $('#msg-form').reset(function(e){

	// 	e.preventDefault();
	// 	//var user_id = $('#user_id').html();
	// 	//console.log(user_id);
	// 	var message = $('#message').val();
		
	// 	console.log(message);


	// 	$.ajax({
	// 		url:'./php/add_message.php',
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