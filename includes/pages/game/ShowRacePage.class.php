<?php

/**
 *  2Moons
 *   by Yamil Readigos Hurtado 2019-2020
 *   by Rayco Garcia Fernandez 2020
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons Moon Dark
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @author Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @author Rayco Garcia Fernandez <rayco.garcia13@nauta.cu>
 * @copyright 2020 YamilRH
 * @copyright 2020 Yamil Readigos Hurtado <ireadigos@gmail.com>
 * @licence MIT
 * @version 2.6
 * @link https://www.miisla.nat.cu
 */

class ShowRacePage extends AbstractGamePage
{
    public static $requireModule = MODULE_PLAYERCARD;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		$resrsgh = HTTP::_GP('race', 0);
		$racec 	= $resrsgh;
		
		switch($resrsgh){
			case( 1 ):
			$resrsgh = 'forscher';
						$loeschen = 'krieger = 0, miner = 0, haendler = 0'; 
			break;
						case(2 ):
						$resrsgh = 'miner';
						$loeschen = 'krieger = 0, haendler = 0, forscher = 0'; 
			break;
						case( 3 ):
						$resrsgh = 'krieger';
						$loeschen = 'haendler = 0, miner = 0, forscher = 0'; 
			break;
						case( 4 ):
						$resrsgh = 'haendler';
						$loeschen = 'krieger = 0, miner = 0, forscher = 0'; 
			break;
		}
		global $USER, $LNG;
	$seite= '';		
	if($racec !== 0){
		if(($USER['race_date']) < time() ){
$db = Database::get();

							$db->query("UPDATE uni1_users SET race_date=". (time() + 7889400) .", ". $loeschen .", ". $resrsgh ." = 1 , race = ". $racec ." WHERE id = ".$USER['id'].";");
	

		$seite .= "<div style=\"height: 100vh; text-align:center;\";>Puedes cambiar la facción la siguiente fecha " . date( 'd.m.Y , H:i:s' ,($USER['race_date'])) . "<br>
		Tu facción es:<br> <img style=\"border:1px solid #066; border-radius:10px;\" src=\"styles/theme/gow/img/race/". $racec .".png\"> <br>" . $LNG['tech']['80'.$racec];
		}else{
			
			$seite .=  "<div style=\"height: 100vh; ";  if(($USER['race_date']) > time()){ $seite .=  "color:red;";  } $seite .=  " text-align:center;\";>Puedes cambiar la facción la siguiente fecha " . date( 'd.m.Y , H:i:s' ,($USER['race_date'])) . "<br>
		Tu facción es:<br> <img style=\"border:1px solid #066; border-radius:10px;\" src=\"styles/theme/gow/img/race/". $USER['race'] .".png\"> <br>" . $LNG['tech']['80'.$USER['race']];
		}
	}else{
		$seite .=  "<div style=\"height: 100vh; text-align:center;\";><h6>Elija con cuidado, la clase solo se puede cambiar cada 3 meses.</h6><br>";  if(($USER['race_date']) > time()){ $seite .=  "Puedes cambiar la facción la siguiente fecha " . date( 'd.m.Y , H:i:s' ,($USER['race_date'])) . "<br>";  } $seite .=  "
		Tu facción es:<br> <img src=\"styles/theme/gow/img/race/". $USER['race'] .".png\"> <br>" . $LNG['tech']['80'.$USER['race']];
		}
		$seite .=  '
		<style>
		.grow {font-size:9px; transition: all .1s ease-in-out; border:1px groove #666; border-radius:10px; background:#111; color:#aaa; padding: 0px;
overflow: hidden;  vertical-align: baseline; cursor:pointer;}';
if(($USER['race_date']) < time()){
$seite .=  '.grow:hover { transform: scale(1.5); }
.grow:active { transform: scale(1.5); }';
}

$seite .=  '
.raceul{
	list-style: outside none none;
padding: 0px;}

.race'; 

if($racec != 0 && ($USER['race_date']) < time()){
	
	
	$seite .=  $racec;
	}else{
		
		$seite .=  $USER['race'];
		
		} 
		$seite .=  '{
	border:1px groove #066; border-radius:10px; background:#000;
	
}
.pos{
	color:green;
}
.neg{color:red;}
		</style>
		
		<table style="margin-left:auto; margin-right:auto; width:0%;"><tr>
		<td class="grow race1"  onclick="location.href=\'game.php?page=race&race=1\';"><img src="styles/theme/gow/img/race/1.png"><br>Pirata
		<br><ul class="raceul">
		<li class="pos"> +20% Ataque</li>		
		<li class="pos"> +15% Blindaje</li>		
		<li class="pos"> +10% Escudo</li>		
		<li class="pos"> -10% Tiempo de construcción de Naves</li>
		<li class="pos"> -20% Tiempo de vuelo</li>
		<li class="pos"> +3	 Ranuras de la flota</li>
		<li class="neg"> -8% Producción de Minas</li>
		<li class="neg"> -15% Almacenamiento de naves</li>


		</ul>
		</td>
		<td class="grow race2" onclick="location.href=\'game.php?page=race&race=2\';"><img src="styles/theme/gow/img/race/2.png"><br>Minero
		<br><ul class="raceul">
		<li class="pos"> +25% Producción de Minas</li>
		<li class="pos"> +10% Producción de Energía</li>
		<li class="pos"> +25% Capacidad de Almacenamiento</li>
		<li class="neg"> +5% Tiempo de Vuelo</li>

		</ul>
		</td>
		<td class="grow race3" onclick="location.href=\'game.php?page=race&race=3\';"><img src="styles/theme/gow/img/race/3.png"><br>Descubridor
		<br><ul class="raceul">
		<li class="pos"> +5% Ataque</li>		
		<li class="pos"> +5% Blindaje</li>		
		<li class="pos"> -10% Tiempo de Investigación</li>
		<li class="pos"> +11% Producción de Energía</li>		
<li class="pos"> -10% Tiempo de Construcción</li>		
		</ul>
		</td>
		<td class="grow race4"  onclick="location.href=\'game.php?page=race&race=4\';"><img src="styles/theme/gow/img/race/4.png"><br>Investigador
		<br><ul class="raceul">
		<li class="pos"> +30% Escudo</li>		
		<li class="pos"> -20% Tiempo de investigación </li>
		<li class="pos"> +20% Generación de energía</li>

		</ul>
		</td>
		</table></div>
		';
		
		//fix page class by hirako
	$m1='
	<script>
	
	window.onload = function all(){
		var x = document.getElementsByTagName("a");
		var i;
		for (i = 0; i < x.length; i++) {
			x[i].style.pointerEvents = "none";
		} 
		var y = document.getElementById("logout");
		y.style.pointerEvents = "all";
	}
function elegir_fac( fac ){
	var x = document.getElementsByTagName("a");
		var i;
		for (i = 0; i < x.length; i++) {
			x[i].style.pointerEvents = "all";
		} 
	if($(fac).hasClass("race4")){
		window.location.href = "game.php?page=race&race=4";
	}else if($(fac).hasClass("race3")){
		window.location.href = "game.php?page=race&race=3";
	}else if($(fac).hasClass("race2")){
		window.location.href = "game.php?page=race&race=2";
	}else if($(fac).hasClass("race1")){
		window.location.href = "game.php?page=race&race=1";
	}

    
}
</script>';
$db = Database::get();
	$sql1 = "SELECT race FROM %%USERS%% where id = :user_id;";
            $race = $db->selectSingle($sql1, array(
                ':user_id'     =>$USER['id'],
            ));
	if($race['race']==0){
	$this->printMessage(sprintf("%s%s",$seite,$m1));
	}else $this->printMessage($seite);
		
	

//end fix
	}
}
