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

class ShowLotteryPage extends AbstractGamePage
{	
//	public static $requireModule = 0;
 public static $requireModule = MODULE_LOTTERY;


	function __construct() {
		parent::__construct();
	}
	
	function show()
	{
		global  $USER, $LNG, $resource, $PLANET;

		if ($USER['urlaubs_modus'] != 0) {
			    $this->printMessage("Error!!! estas en modo vacaciones");
			}
		
		$db 			= Database::get();
		$sql = 'select * from %%CONFLOTTERY%%  LIMIT 1';
		
		$config	= $db->selectSingle($sql);

		$ticket_price_metal = $config['price_metal'];
		$ticket_price_crystal = $config['price_crystal'];
		$ticket_price_deuterium = $config['price_deuterium'];
		$ticket_price_mo = $config['price_mo'];

		$gan_metal=$config['prem_metal'];
		$gan_crystal=$config['prem_crystal'];
		$gan_deu=$config['prem_deuterium'];
		$gan_mato=$config['prem_mo'];
		$cant_gan=$config['cant_ganadores'];
		$percent=$config['percent_descuento'];
		
		$descr=$config['descr'];

		if(!$config['active'])
		{
			$this->printMessage('No existe ninguna lotería activa o terminada', array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php'
			)));
		}

		/*
		* Usuarios registrados en la rifa contador
		*/
		$User = $db->select("SELECT * FROM %%LOTTERY%% ;");
		$Userlottery = $db->rowCount($User);

		$ter=($config['winner']=='0')?false:true;

		if(!$ter && $config['time'] <= TIMESTAMP)
		{
			$sql = 'select id,user,count(id) as cant from %%LOTTERY%%  GROUP BY id';
			$todos	= $db->select($sql);
			$cant = count($todos);
			
			if($cant>=1)
			{

				$winers = [];
				for($i=0;$i<$cant;$i++)
					$winers[]=$i;
				shuffle($winers);
				$winers=array_slice($winers,0,$cant_gan);
				
				$wintext='';
				for($i=0;$i<count($winers);$i++)
				{
					$desc=$percent*$i;
					$win=$todos[$winers[$i]];

					$sql = 'select id_planet,universe from %%USERS%%  WHERE id=:id';
					$userWin	= $db->selectSingle($sql,[
						':id'=>$win['id']
					]);
		
					$sql = "UPDATE %%PLANETS%% SET metal = metal+".($gan_metal-($desc*$gan_metal/100)).", crystal = crystal + ".($gan_crystal-($desc*$gan_crystal/100)).",deuterium = deuterium +".($gan_deu-($desc*$gan_deu/100))."
									WHERE id = :id AND universe = :universe";
					$db->update($sql, array(
							':id'	=> $userWin['id_planet'],
							':universe'=> $userWin['universe']
					));
		
					$sql = "UPDATE %%USERS%% SET darkmatter = darkmatter+".($gan_mato-($desc*$gan_mato/100))." WHERE id = :id";
					$db->update($sql, array(
							':id'	=> $win['id']
					));
					$wintext.=($i+1).':'.$win['user'].'|';
				}
				$wintext = substr($wintext, 0, -1);

				$sql = "UPDATE %%CONFLOTTERY%% SET winner = :winner WHERE id = 1";
				$db->update($sql, array(
						':winner'	=> $wintext
				));

				$l=explode('|',$wintext);
				$winT='';
				for($i=0;$i<count($l);$i++)
				{
					$g=explode(':',$l[$i]);
					$winT.=$g[0].' - '.$g[1]."<br>";
				}

				$db 			= Database::get();
				$Message='La RIFA ha terminado';
				$Message.="<br> Los ganadores son:<br> ".$winT;
				$Message.="<br> Felicidades a los ganadores";
				$From    	= '<span style="color:#666600">System</span>';
				$pmSubject 	= '<span style="color:#666600">RIFA</span>';
				$pmMessage 	= '<span style="color:#666600">'.$Message.'</span>';
				//$USERS		= $db->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."';");
				$sql = 'select id,universe,username from %%USERS%% WHERE universe=:universe';
				$UserData = $db->select($sql, array(
            			':universe'     => Universe::current(),
        			));
				//while($UserData = $db->fetch_array($USERS))
				foreach($UserData as $item)
				{
					$sendMessage = str_replace('{USERNAME}', $item['username'], $pmMessage);
					PlayerUtil::sendMessage($item['id'], 0, $From, 200, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
				}

			}
			else
			{
				$sql = "UPDATE %%CONFLOTTERY%% SET winner = :winner WHERE id = 1";
				$db->update($sql, array(
						':winner'	=> 'closed'
				));
			}	

			HTTP::redirectTo('game.php?page=lottery');
		}
		$ter=($config['winner']=='0')?false:true;

		if(isset($_REQUEST['inscribirse']))
		{
			$id = $USER['id'];
			$user = $USER['username'];
			if($ter)
			{
				$this->printMessage('Evento Terminado', array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=lottery'
				)));
			}
			if($PLANET['metal']>=$ticket_price_metal && $PLANET['crystal']>=$ticket_price_crystal && $PLANET['deuterium']>=$ticket_price_deuterium && $USER['darkmatter']>=$ticket_price_mo)
			{
				$sql = 'select count(id) as cant from %%LOTTERY%% WHERE id=:id';
				$inscritos	= $db->selectSingle($sql,array(
					':id'=>$id
				));
				if($inscritos['cant'] < $config['max_ticket'])
				{
					$PLANET['metal'] -= $ticket_price_metal;
					$PLANET['crystal']	-= $ticket_price_crystal;
					$PLANET['deuterium']	-= $ticket_price_deuterium;
					$USER['darkmatter']	-= $ticket_price_mo;
					$sql	= "UPDATE %%PLANETS%% SET `metal` = :metal, `crystal` = :crystal,`deuterium` = :deut 
							   WHERE id = :id AND universe = :universe";
					$db->update($sql, array(
							':metal'	=> $PLANET[$resource[901]],
							':crystal'	=> $PLANET[$resource[902]],
							':deut'	=> $PLANET[$resource[903]],
							':id'	=> $PLANET['id'],
							':universe'=> $PLANET['universe']
					));
					$sql	= "UPDATE %%USERS%% SET `darkmatter` = :dark WHERE id = :id";
					$db->update($sql, array(
							':dark'=> $ticket_price_mo,
							':id'	=> $USER['id'],
					));
					$sql="INSERT INTO %%LOTTERY%% SET 
					`ID`=:id, 
					`user`=:user, 
					`tickets`=:ticket;
					";
					$db->insert($sql,array(
						':id'=>$id,
						':user'=>$user,
						':ticket'=>time()
					));
				}
				else{
					$this->printMessage('Ya no puede comprar más boletos para esta lotería', array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=lottery'
					)));
				}
			}
			else{
				$this->printMessage($LNG['lm_no_recursos'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=lottery'
				)));
			}
		}


		$sql = 'select count(id) as cant,user from %%LOTTERY%%  GROUP BY id';
		$inscritos	= $db->select($sql);
		$ganador=($config['winner']=='0')?'No se ha terminado el evento':$config['winner'];
		$secs = (!$ter)?$config['time'] - TIMESTAMP:0;

		if(!$ter)
			$this->tplObj->loadscript('jquery.countdown.js');

		$mios=0;

		foreach($inscritos as $item)
		{
			if($item['user']==$USER['username'])
			{
				$mios=$item['cant'];
				break;
			}
		}

		
		if($ganador!='No se ha terminado el evento')
		{
			$l=explode('|',$ganador);
			$ganadores=[];
			for($i=0;$i<count($l);$i++)
			{
				$ganadores[]=explode(':',$l[$i]);
			}
		}
		else
			$ganadores=$ganador;

		$this->assign(array(
			'resources'=>$resource,
			'ticket_price_metal'=>$ticket_price_metal,
			'ticket_price_crystal'=>$ticket_price_crystal,
			'ticket_price_deuterium'=>$ticket_price_deuterium,
			'ticket_price_mo'=>$ticket_price_mo,
			'gan_mato'=>$gan_mato,
			'gan_metal'=>$gan_metal,
			'gan_crystal'=>$gan_crystal,
			'gan_deu'=>$gan_deu,
			'secs'=>$secs,
			'inscritos'=>$inscritos,
			'terminado'=>$ter,
			'ganador'=>$ganadores,
			'descripcion'=>$descr,
			'mios'	=>$mios,
			'max'=>$config['max_ticket'],
			'userinscritos'=>$Userlottery
		));

		$this->display('page.lottery.default.tpl',);
	}
}
?>
