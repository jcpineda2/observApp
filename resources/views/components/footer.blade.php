<footer class="bg-dark text-inverse">
    <div class="container py-8 py-md-10">
        <div class="row gy-6 gy-lg-0">
            <div class="col-lg-4">
                <div class="widget">
                    <img class="mb-4" src="{{ asset('img/logo-light.png') }}"
                        srcset="{{ asset('img/logo-light@2x.png 2x') }}" alt="Logo" />
                    <p class="mb-4">©
                        <span id="curdate"></span> SENATUR. Todos los derechos reservados.
                    </p>
                    <nav class="nav social social-white">
                      <a href="{{ env('TW_SENATUR') }}" target="_blank">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                              width="20px" height="20px" viewBox="0 0 24 24" style="vertical-align: middle;">
                              <path fill="white"
                                  d="M14.095479,10.316482L22.286354,1h-1.940718l-7.115352,8.087682L7.551414,1H1l8.589488,12.231093L1,23h1.940717  l7.509372-8.542861L16.448587,23H23L14.095479,10.316482z M11.436522,13.338465l-0.871624-1.218704l-6.924311-9.68815h2.981339  l5.58978,7.82155l0.867949,1.218704l7.26506,10.166271h-2.981339L11.436522,13.338465z" />
                          </svg>
                      </a>
                      <a href="{{ env('FB_SENATUR') }}" target="_blank"><i class="uil uil-facebook-f"></i></a>
                      <a href="{{ env('IG_SENATUR') }}" target="_blank"><i class="uil uil-instagram"></i></a>
                      <a href="{{ env('TikTok_SENATUR') }}" target="_blank"><i class="uil uil-tiktok"></i></a>
                      <a href="{{ env('YT_SENATUR') }}" target="_blank"><i class="uil uil-youtube"></i></a>
                  </nav>

                </div>
            </div>
            <!-- /column -->
            <div class="col-md-2 col-lg-3 offset-lg-1">
                <div class="widget">
                    <h4 class="widget-title mb-3 text-white">Información</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ route('terminos') }}">Términos y Condiciones</a></li>
                        <li><a href="https://senatur.gov.py/atencion-ciudadana/">Reclamos</a></li>
                        <li><a href="{{ route('ayuda') }}">Ayuda</a></li>
                        <li><a href="{{ route('filament.portal.auth.login') }}" target="_blank">Acceso al Portal
                                Administrador</a></li>
                    </ul>
                </div>
            </div>
            <!-- /column -->
            <div class="col-md-3 col-lg-4">
                <div class="widget">
                    <h4 class="widget-title mb-3 text-white">Contactos</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a href="https://www.google.com/maps/place/SENATUR/@-25.2813018,-57.6359808,15z/data=!4m6!3m5!1s0x945da7f3a879e107:0xf20820215a4c105a!8m2!3d-25.2813018!4d-57.6359808!16s%252Fg%252F12qg85kz4" target="blank" rel="noopener noreferrer"><b>Dirección:</b> Palma 468 e/ Alberdi y 14 de Mayo</a></li>
                        <li><a href="tel:+59521494110"><b>Teléfono:</b> +595 21 494 110</a></li>
                        <li><a href="mailto:registur@senatur.gov.py" rel="noopener noreferrer"><b>E-mail:</b> </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
