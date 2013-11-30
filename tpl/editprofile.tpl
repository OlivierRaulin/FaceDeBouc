      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h1>Editer mon profil</h1>

          <form id='register' action='/modifierUtilisateur' method='post' accept-charset='UTF-8'>
            <fieldset >
              <!--<input type='hidden' name='submitted' id='submitted' value='1'/>-->
              <div class="clearfix">
	              <label for='name' >Nom* :  </label>
	              <div class="input">
	              	<input type='text' name='lastName' id='lastName' maxlength="50" class="xlarge" size="30" value="{nom}" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='name' >Prenom* :  </label>
	              <div class="input">
	              	<input type='text' name='firstName' id='firstName' maxlength="50" class="xlarge" size="30" value="{prenom}" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='email' >Adresse E-mail* :  </label>
	              <div class="input">
	              	<input type='text' name='email' id='email' maxlength="50" class="xlarge" size="30" value="{email}" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='password' >Mot de passe actuel* :  </label>
	              <div class="input">
	              	<input type='password' name='oldpassword' id='oldpassword' maxlength="50" class="xlarge" size="30" value="" /><br/>
	              </div>
              </div>
              
	          <h6>Veuillez laisser les champs vides si vous désirez ne pas modifier votre mot de passe !</h6><br/>
              
              <div class="clearfix">
	              <label for='password' >Nouveau mot de passe :  </label>
	              <div class="input">
	              	<input type='password' name='password' id='password' maxlength="50" class="xlarge" size="30" value="" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='confirmPassword' >Retapez le mot de passe :  </label>
	              <div class="input">
	              	<input type='password' name='confirmPassword' id='confirmPassword' maxlength="50" class="xlarge" size="30" value="" /><br/>
	              </div>
              </div>
             <div class="clearfix">
		Flag : {dtc}
		</div>
              <div class="actions">
              	<input type='submit' class="btn primary" name='Submit' value='Sauvegarder' />
              </div>
              
            </fieldset>
          </form>
        </div>
      </div>
