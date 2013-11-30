      <div class="content">
        <!-- Main hero unit for a primary marketing message or call to action -->
        <div class="hero-unit">
          <h1>Liste des utilisateurs</h1>
        </div>

        <p>Nombre d'utilisateurs : {nbre}</p>
            <table class="zebra-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Prénom</th>
                  <th>Nom</th>
                </tr>
              </thead>
              <tbody>
                <!-- BEGIN userlistline -->
                	{userList}           
                <!-- END userlistline -->
              </tbody>
            </table>
            <p>{pagesLabel}</p>
            <!-- <p><a href="#"><< Précédent</a></p><p><a href="#">Suivant >></a></p>-->
      </div>
