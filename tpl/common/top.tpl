  <body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="/">FacedeBouc</a>
          <ul class="nav">
            <li ><a href="/">Accueil</a></li>
            <li ><a href="https://www.facebook.com/find-friends">Find friends</a></li>
          </ul>
          <!-- BEGIN hiUser -->
          <form class="pull-right" method="post" action="/logout">
	        <label>Salut <a href="/mur-{userid}">{username}</a> !</label>
          	<input type="submit" value="Se déconnecter"/>
          </form>
          <!-- END hiUser -->
          <!-- BEGIN logInForm -->
           <form class="pull-right" method="get" action="/enregistrement">
             <input type="submit" value="Créer un compte"/>
          </form>
          <form class="pull-right" method="post" action="/login" autocomplete="off">
          	<input size=8 type="text" name="username" placeholder="e-mail"/>
          	<input style="input-small" type="password" name="password" placeholder="mot de passe"/>
          	<input type="submit" value="Se connecter"/>
          </form>
          <!-- END logInForm -->
        </div>
        </div>
      </div>
    </div>
    
    <!-- BEGIN error -->
    <div class="alert-message"><p class="">{error.message}</p></div>
    <!-- END error -->
