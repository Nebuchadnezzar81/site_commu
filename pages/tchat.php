<!-- <?php
//include 'php/add_message.php';
?> -->

<h1>Mini-Tchat</h1>

         <!-- Statuts -->               
    <table class="status">
        <tr>
             <td>
                <span id="statusResponse"></span>
                <select name="status" id="status" style="width:200px;" onchange="setStatus(this)">
                    <option value="0">Absent</option>
                    <option value="1">Indisponible</option>
                    <option value="2" selected>En ligne</option>
                </select>
            </td>
        </tr>
    </table> 

    <table class="post_message">
        <tr>
            <td>
                <form id="msg-form" method="post" >
                    <fieldset>
                        <!-- ajout automatique de l'username + user_id (en display none)-->
                        <div id="user_id" style="display:none"><?php echo $_SESSION['id']; ?></div>
                        <div id="username">Pseudo : <?php echo $_SESSION['username']; ?>
                        <!-- <label for="username">Pseudo :</label>
                        <input type="text" name="username" id="username" required />
                        <div class="invalid-feedback">
                            Veuillez écrire un pseudo.
                        </div> -->
                         <!-- Pour ajouter le pseudo automatiquement avec BDD
                        <a name="post"></a>-->
                        <br><br> 
                       
                       <!--  Zone de texte -->
                        <label for="message">Message :</label>
                        <br>
                        <textarea name="message" id="message" required></textarea>
                        <div class="invalid-feedback">
                            Veuillez écrire un message.
                        </div>
                        
                        <br><br>
                        
                       <!--  Boutons -->
                        <div>
                            <input type="reset" name="reset" value="Annuler" id="annuler" class="button"/>
                            <input type="submit" name="submit" value="Envoyez votre message !" id="msg-form" class="button"/>
                        </div>
                        <br>
                        
                        <div class="form-check">
                            <p>
                                <strong>
                                    Cochez pour envoyer
                                </strong>
                            </p>
                            <input class="form-check-input" type="checkbox" id="blankCheckbox" value="return" aria-label="...">
                        </div>
                    </fieldset> 
                </form>
                <div id="responsePost" style="display:none"></div>
            </td>
        </tr>
    </table>
                
    <table class="chat">
        <tr>
            <td valign="top" id="text-td">
                <div id="screen">
                    <div id="messages"><!-- les messages du tchat -->                  
                        <div id="loading">
                            <span class="info" id="info">Chargement du tchat en cours veuillez patienter...<img src="images/ajax-loader.gif" alt="patientez..."></span><br />
                        </div>           
                    </div>
                    <div id="resultat">
                        <!--pour afficher le commentaire-->
                    </div>
                </div>
            </td>
            <!-- colonne avec les membres connectés au chat -->
            <td valign="top" id="users-td">
                <div id="users">
                    <ul>Membres connectés :
                        <li><?php echo $_SESSION['username']; ?><em> - Vous-même</em></li>
                        <li>Marion</li>
                        <li>Gaelle</li>
                        <li>Simon</li>
                        <li>Mathieu</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>       