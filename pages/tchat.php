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
                        <div id="user_id" style="display:none">
                            <?php 
                                if(isset($_SESSION['id']))
                                {
                                echo $_SESSION['id'];
                                }
                                else echo 'Vous devez être connecté pour envoyer un message';   
                            ?>       
                        </div>
                        <div id="pseudo">Pseudo : 
                            <span id="username">
                            <?php 
                                if(isset($_SESSION['id']))
                                {
                                echo $_SESSION['username'];
                                }
                                else echo 'Vous devez être connecté pour envoyer un message'; 

                            ?>
                            </span>
                        
                        <br><br> 
                       
                       <!--  Zone de texte -->
                        <label for="message">Message :</label>
                        <br>
                            <?php 
                                if(!isset($_SESSION['id']))
                                {
                                echo '<textarea readonly>Vous devez être connecté pour envoyer un message</textarea>'; 
                                }
                                else echo'<textarea name="message" id="message" required></textarea>';

                            ?>
                        
                        <div class="invalid-feedback">
                            Veuillez écrire un message.
                        </div>
                        
                        <br><br>
                        
                       <!--  Boutons -->
                        <div>
                            <?php 
                                if(isset($_SESSION['id']))
                                {
                                echo '<input type="submit" name="submit" value="Envoyez votre message !" id="msg-form" class="button"/>'; 
                                }
                            ?>
                            <input type="reset" name="reset" value="Annuler" id="annuler" class="button"/>
                            <!-- <input type="submit" name="submit" value="Envoyez votre message !" id="msg-form" class="button"/> -->
                        </div>
                        <br>
                        
                        <!-- <div class="form-check">
                            <p>
                                <strong>
                                    Cochez pour envoyer
                                </strong>
                            </p>
                            <input class="form-check-input" type="checkbox" id="blankCheckbox" value="return" aria-label="...">
                        </div> -->
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
                    <ul>Membres connecté·e :
                        <li><em>
                            <?php 
                                if(isset($_SESSION['id']))
                                {
                                echo $_SESSION['username'];
                                }
                                else echo '?'; 
                            ?>
                        </em></li>
                        <li>Martin - <em>TeamLeader</li>
                        <li>Marion</li>
                        <li>Gaelle</li>
                        <li>Simon</li>
                        <li>Mathieu</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>       