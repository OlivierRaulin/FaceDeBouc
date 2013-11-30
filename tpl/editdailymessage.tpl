 <div class="content">
    <!-- Main hero unit for a primary marketing message or call to action -->
    <div class="hero-unit">
      <h1>Diffusez votre message quotidien</h1>

	 <!-- Add new DailyMessage -->
      <form action="/postDailyMessage" method="post" >
          <fieldset>
			<h4>Titre</h4>
			<input id="xlInput" class="xlarge" type="text" size="30" name="dailyMessageTitle">
            <h4>Ecrivez quelque chose ...</h4> 
              <!-- Limiter le texte a 200 caractères -->
                <textarea class="xxlarge" id="textarea" maxlength="200" name="dailyMessageText" rows="3"></textarea>
                <span class="help-block">
                  Les messages sont limités à 200 caractères. <!-- Théoriquement -->
                </span>
				<button class="btn">Post</button>
          </fieldset>
        </form>
	</div>
		
	<!-- List all DailyMessage -->
	<p>Nombre de messages : {nbre}</p>
         <table class="condensed-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Titre</th>
              <th>Message</th>
            </tr>
          </thead>
          <tbody>
            <!-- BEGIN dailymessagelist -->
            <tr>
              <td>{Date}</td>
              <td>{Titre}</td>
              <td>{Message}</td>
            </tr>
            <!-- END dailymessagelist -->
          </tbody>
        </table>

        <!--<p><a href="#"><< Précédent</a><a href="#">Suivant >></a></p>-->
    
</div>
