      <div class="content">
        <div class="hero-unit">
          <h1>Register</h1>
          <form id='register' action='/enregistrementUtilisateur' method='post' accept-charset='UTF-8'>
            <fieldset >
	          <div class="clearfix">
	              <label for='name' >Nom* :  </label>
	              <div class="input">
	              	<input type='text' name='lastName' id='lastName' maxlength="50" class="xlarge" size="30" /><br/>
	              </div>
	          </div>
              
              <div class="clearfix">
	              <label for='name' >Prenom* :  </label>
	              <div class="input">
	              	<input type='text' name='firstName' id='firstName' maxlength="50" class="xlarge" size="30" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='email' >Adresse E-mail* :  </label>
	              <div class="input">
	              	<input type='text' name='email' id='email' maxlength="50" class="xlarge" size="30" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='password' >Mot de passe* :  </label>
	              <div class="input">
	              	<input type='password' name='password' id='password' maxlength="50" class="xlarge" size="30" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='password' >Confirmation du mot de passe* :  </label>
	              <div class="input">
	              	<input type='password' name='confirmPassword' id='confirmPassword' maxlength="50" class="xlarge" size="30" /><br/>
	              </div>
              </div>
              
              <div class="clearfix">
	              <label for='captcha' >Recopiez le captcha ci-dessous : </label>
	              
	              <div class="input">
	              <img src="{captchaRaw}" alt="captcha" /> <br/>
	              	<input type='text' name='captcha' id='captcha' class="xlarge" size="30" /><br/>
	              </div>
              </div>
              
              <div class="actions">
              	  <input type='submit' class="btn primary" name='Submit' value='Créer mon compte' />
              </div>
              
            </fieldset>
          </form>

        </div>
      </div>