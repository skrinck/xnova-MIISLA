<?php 
require_once 'includes/classes/Database.class.php';

$res="";
$db= DATABASE::get();
$BOTS	= $db->select("SELECT b.id, b.last_time, u.username , p.name, p.galaxy, p.system, p.planet from uni1_bots as b join %%USERS%% as u on b.player = u.id join %%PLANETS%% as p on b.player = p.id_owner");


foreach ($BOTS as $bot) {
		$res.="<tr>
	      <th scope='row'>".$bot["id"]."</th>
	      <th scope='row'>".$bot["username"]."</th>
	      <th scope='row'>".$bot["name"].$bot["galaxy"].$bot["system"].$bot["planet"]."</th>
	      <th scope='row'>".date("Y-m-d H:i:s", substr($bot["last_time"], 0, 10))."</th>
	  </tr>";
}
echo $res;
?>