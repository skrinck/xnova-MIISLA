<?php

define('MODE', 'INGAME');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
set_include_path(ROOT_PATH);

require_once 'includes/common.php';

//verificacion de si eres super admin
$resp = [];
// //obtener id
if($_POST)
{

	$id        = HTTP::_GP('id', 0); //comment id

	if($id==0)
	{
		$resp = array(
			'status'=>'failed',
			'msg'	=>'Comentario Incorrecto'
		);	
	}
	else
	{
		// // elimianr post
		$sql = "DELETE FROM %%COMMENTSHOF%% WHERE id = :postid;";
		Database::get()->delete($sql, array(
			':postid'	=> $id
		));

		$resp = array(
			'status'=>'success',
			'msg'	=>'Eliminado correctamente'
		);	

	}
}
else
{
	$resp = array(
			'status'=>'failed',
			'msg'	=>'Error en esta ruta'
		);	
}


//mostrar respuesta
echo json_encode($resp);
?>