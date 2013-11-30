      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h2>{prenom} {nom}</h2>
        </div>
        
        <!-- BEGIN hiMsg -->
	         <form action="/posterdutexte" method="post" >
	          <fieldset>
				<div class="clearfix">
	            	<h4>Poster quelque chose</h4>
				</div>
				
				<label for="textarea">Texte</label>
				<div class="input">
					<textarea id="textarea" class="xxlarge" maxlength="140" rows="3" name="contentPost"></textarea>
					<span class="help-block"> Les messages sont limités à 140 caractères. </span>
				</div>
					<div class="input">
						<button class="btn">Envoyer</button>
						<button class="btn">Annuler</button>
					</div>
			 </fieldset>
			</form>
			
	        <form action="/posteruneimage" method="post" enctype="multipart/form-data">
			 <fieldset>
	
				<div class="clearfix">
					<label for="fileInput">Upload an Image</label>
					<div class="input">
						<input class="input-file" id="postImage" name="postImage" type="file"><br>
					</div>
				</div>
	
				<div class="clearfix">
					<label for="nolabel"></label>
					<div class="input">
						<button class="btn">Envoyer</button>
						<button class="btn">Annuler</button>
					</div>
				</div>
	
	          </fieldset>
	        </form>
        <!-- END hiMsg -->
        
        <div class="hero-unit">
          <h1>Wall</h1>
          <!-- <p>Nombre de messages : {nbre}</p>-->
        <!-- BEGIN wallline -->
            <table>
              <tr><td><b>{date}</b></td></tr>
              <tr><td>{message}</td></tr>
            </table>
        <!-- END wallline -->
        <h7>{pagesLabel}</h7>
        </div>

      </div>
