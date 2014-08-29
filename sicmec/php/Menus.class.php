<?php
class Menus
{

	private $TipoUser;

	function __construct($cveGrupo){
		if(!empty($cveGrupo))
			$this->TipoUser = trim($cveGrupo);
	}
	function Mostrar(){
		switch($this->TipoUser){
			case '1':	$this->Usuario();
								break;
			case '2': $this->Administrador();
								break;
			case '3': $this->SuperUser();
								break;
			default: $this->Usuario();
								break;
		}
	}
	private function Usuario(){
 	  echo "<!--Navegacion nivel 2 (Drop-down menus) -->
  			<div class='nav2'>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='intro.php'>Inicio<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                	<li><a href='CambiarPass.php' class='last'>Cambiar Password</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Datos de Plaza<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaAdscripcion.php'>Generales</a></li>
                  <li><a href='ListaAdscripUtilidades.php' class='last'>T&eacute;cnicos</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

					<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Estatus Equipo<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaHistorial.php' class='last'>Estado Actual</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>
        </div>";
	}
	private function Administrador(){
 	  echo "<!--Navegacion nivel 2 (Drop-down menus) -->
  			<div class='nav2'>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='intro.php'>Inicio<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                	<li><a href='CambiarPass.php'>Cambiar Password</a></li>
                  <li><a href='AgregaVarios.php' class='last'>Agregar Varios</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Datos de Plaza<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaAdscripcion.php'>Generales</a></li>
                  <li><a href='ListaAdscripUtilidades.php'>T&eacute;cnicos</a></li>
                  <li><a href='ActualizaAdscrip.php'>Actualizar</a></li>
                  <li><a href='InsertaAdscrip.php'>Agregar</a></li>
                  <li><a href='Responsable.php' class='last'>Responsable</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Datos de Equipo<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                	<li><a href='ListaActivo.php'>Generales</a></li>
                  <li><a href='ActualizaActivo.php'>Actualizar</a></li>
                  <li><a href='InsertaActivo.php'>Agregar</a></li>
                  <li><a href='SustituirActivo.php' class='last'>Sustituir</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

								<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Estatus Equipo<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaHistorial.php'>Estado Actual</a></li>
                  <li><a href='ListaHistorialEquipo.php' class='last'>Historial</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

								<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Reporte de Falla<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='CapturaReporte.php'>Reportar</a></li>
                  <li><a href='ListaReporte.php' class='last'>Fallas Reportadas</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

								<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Servicio a Plazas<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ServicioPlaza.php'>Registrar Servicio</a></li>
                  <li><a href='ListaServicioPlaza.php' class='last'>Visualizar Servicio</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>
          			<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Personal<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ActualizaPersonal.php'>Actualizar</a></li>
                  <li><a href='InsertaPersonal.php'>Agregar</a></li>
                  <li><a href='EliminaPersonal.php' class='last'>Eliminar</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>
	 			<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Mantto<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='CapturaMantenimiento.php'>Capturar Preventivo</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>
        </div>";
	}
	private function SuperUser(){
echo "<!--Navegacion nivel 2 (Drop-down menus) -->
  			<div class='nav2'>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='intro.php'>Inicio<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                	<li><a href='CambiarPass.php' class='last'>Cambiar Password</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Datos de Plaza<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaAdscripcion.php'>Generales</a></li>
                  <li><a href='ListaAdscripUtilidades.php'>T&eacute;cnicos</a></li>
                  <li><a href='Responsable.php' class='last'>Responsable</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

          <!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Datos de Equipo<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                	<li><a href='ListaActivo.php' class='last'>Generales</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

								<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Estatus Equipo<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='ListaHistorial.php'>Estado Actual</a></li>
                  <li><a href='ListaHistorialEquipo.php' class='last'>Historial</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>

								<!-- Navegacion Boton -->
          <ul>
            <li><a href='#'>Reporte de Falla<!--[if IE 7]><!--></a><!--<![endif]-->
              <!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul>
                  <li><a href='CapturaReporte.php'>Reportar</a></li>
                  <li><a href='ListaReporte.php' class='last'>Fallas Reportadas</a></li>
                </ul>
              <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
          </ul>
        </div>";
	}
}
?>