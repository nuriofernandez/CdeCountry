<main class="container">
   <div>
      <h1>Nombre Elecciones</h1>
      <p class="text-justify">
        Descripción de las elecciones y más información.
      </p>
      <div class="container-fluid">
         <div class="row">
            <div class="col-12 col-xl-4 mt-4">
               <div class="card party">
                  <div class="card-header">
                     <div class="container-fluid">
                        <div class="row">
                           <div class="col-4">
                              <img id="party-0-logo" class="card-img-top" src="https://new.cdecountry.es/assets/img/logo.png">
                           </div>
                           <div class="col">
                              <h5 id="party-0-name" class="align-middle">Nombre del partido<br> &nbsp;</h5>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <blockquote id="party-0-description" class="description text-white-50">
                                 Descripción del partido.
                              </blockquote>
                           </div>
                        </div>
                        <div class="row small text-dark options font-weight-bold">
                           <div class="col-4">
                              <a id="party-0-twitter-link" href="https://twitter.com/PCCDCC" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                           </div>
                           <div class="col">
                              <a id="party-0-more-info" href="http://pccdcc.ml/wp-content/uploads/2018/08/Programa_Politico-4.pdf" target="_blank"><i class="fas fa-file"></i> Programa electoral</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body candidates">
                     <div class="row">
                        <div class="col">
                           <h6 id="party-0-deputies-amount">21 Candidatos</h6>
                        </div>
                        <div class="col">
                           <button onclick="checkAll(this)" class="btn btn-primary btn-sm vote-party-btn">Votar a todo el partido</button>
                        </div>
                     </div>
                     <hr class="mt-1">
                     <div>
                        <div class="number">
                            <a href="https://twitter.com/xxnurioxx" target="_blank"><i alt="ver twitter"><i class="fab fa-twitter"></i></a>
                            <a href="https://new.cdecountry.es/profile/1" target="_blank"><i alt="ver twitter"><i class="fas fa-user-circle"></i></a>
                           <label for="party-0-diputy-0">Nombre Apellido</label>
                           <input class="float-right" type="checkbox" id="party-0-diputy-0">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="row">
      <div class="col">
         <hr class="mt-6">
         <button onclick="Confirma()" class="btn btn-primary btn-sm vote-party-btn">Enviar voto</button>
      </div>
   </div>
</main>