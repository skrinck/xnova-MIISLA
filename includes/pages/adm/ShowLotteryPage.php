<?php

/**
 *  2Moons 
 *   by Rayco García 2020
 */
 
 if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowLottery()
{
	global $LNG, $resource, $reslist;

	$template	= new template();	
	$config			= Config::get();
	$db 			= Database::get();

	$action	= HTTP::_GP('action', '');

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
	$reglo_mo=$config['regalo_mo'];

	$descr=$config['descr'];
	$cant_gan=$config['cant_ganadores'];
	$percent=$config['percent_descuento'];
	$max_tick=$config['max_ticket'];
	$cant_horas=$config['cant_horas'];

	$ter=($config['winner']=='0')?false:true;

	if ($action == 'send') {
		$loteria	= HTTP::_GP('loteria', 'start');

		if($loteria=='start')
		{
			$ticket_price_metal	= HTTP::_GP('precio_metal', 0);
			$ticket_price_crystal	= HTTP::_GP('precio_crystal', 0);
			$ticket_price_deuterium	= HTTP::_GP('precio_deut', 0);
			$ticket_price_mo	= HTTP::_GP('precio_mo', 0);
			$gan_metal = HTTP::_GP('gan_metal', 0);
			$gan_crystal = HTTP::_GP('gan_crystal', 0);
			$gan_deu = HTTP::_GP('gan_deut', 0);
			$gan_mato = HTTP::_GP('gan_mo', 0);
			$reglo_mo = HTTP::_GP('regalo_mo', 0);
			$descr = HTTP::_GP('descr', '');
			$cant_gan = HTTP::_GP('cant_ganad', 0);
			$cant_horas = HTTP::_GP('cant_horas', 0);
			$percent = HTTP::_GP('percent_desc', 0);
			$max_tick = HTTP::_GP('max_tickets', 0);

			$tm=TIMESTAMP+$cant_horas*60*60;
			$config['time'] = $tm;

			$sql = "UPDATE %%CONFLOTTERY%% SET winner = :winner , max_ticket = :max, time = :tm, cant_horas = :horas,
			price_metal = :prm, price_crystal = :prc, price_deuterium = :prd, price_mo = :prmo, prem_mo = :premmo,
			prem_crystal = :premcry, prem_metal = :premmet, prem_deuterium = :premdeu, descr = :descr, active = 1,
			regalo_mo = :regalo, cant_ganadores = :gan, percent_descuento = :percent
			WHERE id = 1";
			$db->update($sql, array(
					':winner'	=> '0',
					':max'		=>$max_tick,
					':tm'		=>$tm,
					':horas'	=>$cant_horas,
					':prm'		=>$ticket_price_metal,
					':prc'		=>$ticket_price_crystal,
					':prd'		=>$ticket_price_deuterium,
					':prmo'		=>$ticket_price_mo,
					':premmo'	=>$gan_mato,
					':premmet'	=>$gan_metal,
					':premcry'	=>$gan_crystal,
					':premdeu'	=>$gan_deu,
					':descr'	=>$descr,
					':regalo'	=>$reglo_mo,
					':gan'		=>$cant_gan,
					':percent'	=>$percent					
			));
			$sql = "DELETE FROM %%LOTTERY%%";
			$db->delete($sql);

			$premiosT="";
			if($gan_mato!=0)
				$premiosT.=$LNG['tech'][921].": ".$gan_mato.", ";
			if($gan_metal!=0)
				$premiosT.=$LNG['tech'][901].": ".$gan_metal.", ";
			if($gan_crystal!=0)
				$premiosT.=$LNG['tech'][902].": ".$gan_crystal.", ";
			if($gan_deu!=0)
				$premiosT.=$LNG['tech'][903].": ".$gan_deu;

			$preciosT="";
			if($ticket_price_mo!=0)
				$precios.=$LNG['tech'][921].": ".$ticket_price_mo.", ";
			if($ticket_price_metal!=0)
				$precios.=$LNG['tech'][901].": ".$ticket_price_metal.", ";
			if($ticket_price_crystal!=0)
				$precios.=$LNG['tech'][902].": ".$ticket_price_crystal.", ";
			if($ticket_price_deuterium!=0)
				$precios.=$LNG['tech'][903].": ".$ticket_price_deuterium;
			if($ticket_price_deuterium!=0 || $ticket_price_mo!=0 || $ticket_price_metal!=0 || $ticket_price_crystal!=0)
			$preciosT.="<br>Los precios son los siguientes: ".$precios;

			$tick.="<br>Cantidad de Boletos:" .$max_tick;
			$ganadores.="<br>Cantidad de Ganadores:" .$cant_gan;

			$Message="Estimado {USERNAME}, le anunciamos que acaba de comenzar una Rifa donde podrás inscribirte durante las proximas ".$cant_horas;
			$Message.=' horas.';
			$Message.="".$tick;
			$Message.="".$ganadores;
			$Message.="".$preciosT;
			$Message.="<br> Los premios son los siguientes: ".$premiosT;
			$Message.="<br>Para el que compre su boleto tendrá un Regalo: ".$reglo_mo;
			$Message.=' MO';
			$From    	= '<span style="color:#666600">System</span>';
			$pmSubject 	= '<span style="color:#666600">Rifa</span>';
			$pmMessage 	= '<span style="color:#666600">'.$Message.'</span>';
			$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."';");
			while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
			{
				$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
				PlayerUtil::sendMessage($UserData['id'], 0, $From, 200, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
			}


			HTTP::redirectTo('admin.php?page=lottery');
		}
		else if($loteria=='finish')
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

				$Message='La RIFA ha terminado';
				$Message.="<br> Los ganadores son:<br>".$winT;
				$Message.="Felicidades a los ganadores";
				$From    	= '<span class="system">System</span>';
				$pmSubject 	= '<span class="system">RIFA</span>';
				$pmMessage 	= '<span class="system">'.$Message.'</span>';
				$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."';");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
				{
					$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
					PlayerUtil::sendMessage($UserData['id'], 0, $From, 50, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
				}

			}
			else
			{
				$sql = "UPDATE %%CONFLOTTERY%% SET winner = :winner WHERE id = 1";
				$db->update($sql, array(
						':winner'	=> 'closed'
				));
			}	

			HTTP::redirectTo('admin.php?page=lottery');
		}


	}	
	
	
	$sql = 'select count(id) as cant,user from %%LOTTERY%%  GROUP BY id';
	$inscritos	= $db->select($sql);
	$ganador=($config['winner']=='0')?'No se ha terminado el evento':'<span style="font-size:2em"><i class="fas fa-medal fa-2x align-middle text-danger"></i> '.$config['winner'].'</span>';
	$secs = (!$ter)?$config['time'] - TIMESTAMP:0;

	if(!$ter)
		$template->loadscript('jquery.countdown.js');
		
		$sql='SELECT id, username FROM %%USERS%%';
		$users	=	$db->select($sql);
		
		$UserList	= "";
		foreach($users as $item)
		$UserList	.=	'<option value="'.$item['id'].'">'.$item['username'].'</option>';
		
		
	$template		= new template();
	$template->loadscript('filterlist.js');
		$template->loadscript('styles/assets/js/core/app.js');	
		$template->loadscript('styles/assets/js/plugins/tables/datatables/datatables.min.js');	
		$template->loadscript('styles/assets/js/plugins/forms/selects/select2.min.js');	
		$template->loadscript('styles/assets/js/pages/datatables_advanced.js');
	$template->assign_vars(array(	
		'resources'=>$resource,
		'ticket_price_metal'=>$ticket_price_metal,
		'ticket_price_crystal'=>$ticket_price_crystal,
		'ticket_price_deuterium'=>$ticket_price_deuterium,
		'ticket_price_mo'=>$ticket_price_mo,
		'gan_mato'=>$gan_mato,
		'gan_metal'=>$gan_metal,
		'gan_crystal'=>$gan_crystal,
		'gan_deu'=>$gan_deu,
		'regalo'=>$reglo_mo,
		'secs'=>$secs,
		'inscritos'=>$inscritos,
		'terminado'=>$ter,
		'ganador'=>$ganador,
		'descr'=>$descr,
		'horas'=>$cant_horas,
		'ganadores'=>$cant_gan,
		'maximo'=>$max_tick,
		'percent'=>$percent,
		'UserList'=>$UserList
	));
	$template->show("lottery.tpl");
}

function RegisterLottery()
{
	
	global $LNG, $resource, $reslist;

	$db 			= Database::get();

	$sql = 'select * from %%CONFLOTTERY%%  LIMIT 1';
	$config	= $db->selectSingle($sql);

	$id	= HTTP::_GP('user', '');
	$cantidad = HTTP::_GP('cantidad', '');
	$cantidad = (int)$cantidad;
	
	$sql = 'select count(id) as cant from %%LOTTERY%% WHERE id=:id';
	$inscritos	= $db->selectSingle($sql,array(
		':id'=>$id
	));

	if($inscritos['cant'] < $config['max_ticket'])
	{
		$cant=(int)$inscritos['cant']+$cantidad;
		if($config['max_ticket']<$cant)
		{
			$cant=$config['max_ticket']-$inscritos['cant'];
		}
		else
			$cant=$cantidad;
		$sql	= "SELECT username FROM %%USERS%% WHERE id = :id";
		$user=$db->selectSingle($sql, array(
				':id'	=> $id,
		));

		$sql	= "UPDATE %%USERS%% SET `darkmatter` = darkmatter + :dark WHERE id = :id";
		$db->update($sql, array(
				':dark'=> $config['regalo_mo']*$cant,
				':id'	=> $id,
		));
		for($i=0;$i<$cant;$i++)
		{
			$sql="INSERT INTO %%LOTTERY%% SET 
			`ID`=:id, 
			`user`=:user, 
			`tickets`=:ticket;
			";
			$db->insert($sql,array(
				':id'=>$id,
				':user'=>$user['username'],
				':ticket'=>time()
			));

		}
		$cant=($inscritos['cant']+$cantidad>$config['max_ticket'])?$config['max_ticket']:$inscritos['cant']+$cantidad;
		// echo json_encode(['status'=>'success','cant'=>$cant,'old'=>$inscritos['cant'],'user'=>$user['username']]);
	}
	else
	{
		// echo json_encode(['status'=>'failed','reason'=>'Excede Máximo de tickets']);
	}

	HTTP::redirectTo('admin.php?page=lottery');

}