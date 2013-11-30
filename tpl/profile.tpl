      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h1>Mon Profil</h1>
           <!-- J'ai mis une photo mais je sais que ce n'est pas demande -->
          <!-- <p><img src={url} height="160" width="160" border="10px solid black"></p>-->
          <!-- Les deux seuls elements à afficher -->
          <p>{prenom} {nom}</p>
        </div>
        
        <div class="hero-unit">
          <h1>Wall</h1>

          <!-- <p>Nombre de messages : {nbre}</p>-->
        <!-- BEGIN profileline -->
            <TABLE BORDER="1">
              <tr><td><b>{date}</b></td></tr>
              <tr><td>{message}</td></tr>
            </TABLE>
        <!-- END profileline -->
        </div>

      </div>
