 <?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class ShowRaportPage extends AbstractGamePage
{
	public static $requireModule = 0;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function BCWrapperPreRev2321($combatReport)
	{
		if(isset($combatReport['moon']['desfail']))
		{
			$combatReport['moon']	= array(
				'moonName'				=> $combatReport['moon']['name'],
				'moonChance'			=> $combatReport['moon']['chance'],
				'moonDestroySuccess'	=> !$combatReport['moon']['desfail'],
				'fleetDestroyChance'	=> $combatReport['moon']['chance2'],
				'fleetDestroySuccess'	=> !$combatReport['moon']['fleetfail']
			);			
		}
		elseif(isset($combatReport['moon'][0]))
		{
			$combatReport['moon']	= array(
				'moonName'				=> $combatReport['moon'][1],
				'moonChance'			=> $combatReport['moon'][0],
				'moonDestroySuccess'	=> !$combatReport['moon'][2],
				'fleetDestroyChance'	=> $combatReport['moon'][3],
				'fleetDestroySuccess'	=> !$combatReport['moon'][4]
			);			
		}
		
		if(isset($combatReport['simu']))
		{
			$combatReport['additionalInfo'] = $combatReport['simu'];
		}
		
		if(isset($combatReport['debris'][0]))
		{
            $combatReport['debris'] = array(
                901	=> $combatReport['debris'][0],
                902	=> $combatReport['debris'][1]
            );
		}
		
		if (!empty($combatReport['steal']['metal']))
		{
			$combatReport['steal'] = array(
				901	=> $combatReport['steal']['metal'],
				902	=> $combatReport['steal']['crystal'],
				903	=> $combatReport['steal']['deuterium']
			);
		}
		
		return $combatReport;
	}

	function flagcomment() 
	{
		global $LNG, $USER;
		
		$db = Database::get();

		$commentId  			= HTTP::_GP('MsgID', 1);
		
		$sql = "SELECT * FROM %%COMMENTSHOF%% WHERE id = :postid;";
		$Comment	= database::get()->selectSingle($sql, array(
			':postid'	=> $commentId
		));

		if(!empty($Comment)){
			$LikedQueue		= explode(';', $Comment['flagInfo']);
			$LikeArray		= array();
			$NewQueue		= array();
			$cusNickCom = empty($USER['username']) ? $USER['username'] : $USER['username'];
			if(!empty($Comment['flagInfo'])){
				foreach($LikedQueue as $Like)
				{
					$temp = explode(',', $Like);
					$LikeArray[] 		= array($temp[0], $temp[1]);
				}
	
				$isLiking		= 1;
				foreach($LikeArray as $Like)
				{
					
					if($Like[0] != $USER['id'])
						$NewQueue[]	= $Like[0].','.$Like[1];
					if($Like[0] == $USER['id']){
						$isLiking = 0;
						$NewQueue[]	= $Like[0].','.$Like[1];
					}
				}
				
				if($isLiking == 1)	
					$NewQueue[]	= $USER['id'].','.$cusNickCom;
				
			}else{
				$isLiking		= 1;
				$NewQueue[]	= $USER['id'].','.$cusNickCom;
			}
			
			$sql = "UPDATE %%COMMENTSHOF%% SET flagAmount = flagAmount + :flagAmount, flagInfo = :flagInfo WHERE id = :postid;";
			database::get()->update($sql, array(
				':postid'	=> $commentId,
				':flagAmount'=> $isLiking == 0 ? 0 : 1,
				':flagInfo'	=> !empty($NewQueue) ? implode(';', $NewQueue) : '',
				
			));  
		}
		
		$sql = "SELECT * FROM %%COMMENTSHOF%% WHERE id = :postid;";
		$Comment	= database::get()->selectSingle($sql, array(
			':postid'	=> $commentId
		));
		
		$return_arr = array("flagAmount"=>$Comment['flagAmount']);

		echo json_encode($return_arr);
	}
	
	function battlehall() 
	{
		global $LNG, $USER;
		
		$LNG->includeData(array('FLEET'));
		$this->setWindow('popup');

		$db = Database::get();
		$config			= Config::get();

		$RID		= HTTP::_GP('raport', '');
		$page  			= HTTP::_GP('site', 1);

		$sql = "SELECT 
			raport, time, simulate,
			(
				SELECT
				GROUP_CONCAT(username SEPARATOR ' & ') as attacker
				FROM %%USERS%%
				WHERE id IN (SELECT uid FROM %%TOPKB_USERS%% WHERE %%TOPKB_USERS%%.rid = %%RW%%.rid AND role = 1)
			) as attacker, attacker as idsAtack, defender as idsDef,
			(
				SELECT
				GROUP_CONCAT(username SEPARATOR ' & ') as defender
				FROM %%USERS%%
				WHERE id IN (SELECT uid FROM %%TOPKB_USERS%% WHERE %%TOPKB_USERS%%.rid = %%RW%%.rid AND role = 2)
			) as defender
			FROM %%RW%%
			WHERE rid = :reportID;";

		$reportData = $db->selectSingle($sql, array(
			':reportID'	=> $RID
		));
		//print_r($reportData);exit;

		$Info		= array($reportData["attacker"], $reportData["defender"]);
		
		if(!isset($reportData)) {
			$this->printMessage($LNG['sys_raport_not_found']);
		}
		
		$combatReport			= unserialize($reportData['raport']);
		$combatReport['time']	= _date($LNG['php_tdformat'], $combatReport['time'], $USER['timezone']);
		$combatReport['simulate']	= $reportData['simulate'];
		$combatReport			= $this->BCWrapperPreRev2321($combatReport);

		/**
		 * MIO añadir ranking global by yamilrh
		 *
		**/

		$atacker = explode(',',$reportData['idsAtack']);
		$defender = explode(',',$reportData['idsDef']);
		$ids=array_merge($atacker,$defender);
		$usersMios='';
		for($i=0;$i<count($ids);$i++)
		{
			$usersMios.=' id_owner = '.$ids[$i];
			if($i+1 < count($ids))
				$usersMios.=' OR ';
		}

		$sql2	= 'SELECT total_points,username
		FROM %%STATPOINTS%%,%%USERS%%
		WHERE stat_type = :statType AND %%USERS%%.id = id_owner OR (:users)';

		$statData	= Database::get()->select($sql2, array(
			':users'	=> $usersMios,
			':statType'	=> 1
		));


		$puntos=[];
		foreach($statData as $item)
		{
			$puntos[$item['username']] = $item['total_points'];
		}

		/**
		 * MIO añadir comment by yamilrh
		 *
		**/

		$cusNickCom = empty($USER['username']) ? $USER['username'] : $USER['username'];
		//RID-USERID-USERNAME
		$plainText = $RID.'-'.$USER['id'].'-'.$cusNickCom;
		$encrypted_txt = encrypt_decrypt('encrypt', $plainText);
		
		$sql = "SELECT COUNT(*) as state FROM %%COMMENTSHOF%% WHERE rid = :rid;";
        $MessageCount = $db->selectSingle($sql, array(
			':rid'	=> $RID,
         ), 'state');
		
		$maxPage	= max(1, ceil($MessageCount / 10));
        $page		= max(1, min($page, $maxPage));
		$MaxNew 	= 10;	
		$COMMENTDATA = array();
		$sql = "SELECT * FROM %%COMMENTSHOF%% WHERE rid = :rid ORDER BY date DESC LIMIT ".(($page - 1) * $MaxNew).",".$MaxNew.";";
		$COMMENTS	= database::get()->select($sql, array(
			':rid'	=> $RID
		));
		
		foreach($COMMENTS as $COMMENT){
			
			
			$LikedQueue		= explode(';', $COMMENT['likeinfo']);
			$LikeArray		= array();
			
			$FlagQueue		= explode(';', $COMMENT['flagInfo']);
			$FlagArray		= array();
			
			$alreadyLiked	= 0;
			$alreadyFlagged	= 0;
			if(!empty($COMMENT['likeinfo'])){
				foreach($LikedQueue as $Like)
				{
					$temp = explode(',', $Like);
					$LikeArray[] 		= array($temp[0], $temp[1]);
				}

				foreach($LikeArray as $Like)
				{

					if($Like[0] == $USER['id'])
						$alreadyLiked = 1;
				}
			}else{
				$alreadyLiked = 0;
			}
			
			
			if(!empty($COMMENT['flagInfo'])){
				foreach($FlagQueue as $Likes)
				{
					$temps = explode(',', $Likes);
					$FlagArray[] 		= array($temps[0], $temps[1]);
				}

				foreach($FlagArray as $Likes)
				{

					if($Likes[0] == $USER['id'])
						$alreadyFlagged = 1;
				}
			}else{
				$alreadyFlagged = 0;
			}
		
			$sql = "SELECT ally_id, foto FROM %%USERS%% WHERE id = :id;";
			$POSERINFO	= database::get()->selectSingle($sql, array(
				':id'	=> $COMMENT['Userid']
			));

			$AVATAR = $POSERINFO['foto'];

			
			$sql = "SELECT username FROM %%USERS%% WHERE id = :id;";
			$POSERUSER	= database::get()->selectSingle($sql, array(
				':id'	=> $COMMENT['Userid']
			));
			$UName = $POSERUSER['username'];
			
			$sql = "SELECT * FROM %%COMMENTSHOF%% WHERE rid = :rid AND replyToComment = :reply ORDER BY date DESC LIMIT :offset, :limit;";
			$COMMENTA	= database::get()->select($sql, array(
				':rid'	=> $RID,
				':reply'=> $COMMENT['id'],
				':offset'   => (($page - 1) * 10),
				':limit'    => 10
			));
			
			$AllyTag = "";
			
			$COMMENTDATAS = array();
			foreach($COMMENTA as $COMMENTAR){
				$COMMENTDATAS[] = array(
					'commendId'	 		=> $COMMENTAR['id'], 
					'name'	 			 => $COMMENTAR['name'], 
					'alliance'		 	=> $AllyTag, 
					'comment'			=> $COMMENTAR['comment'], 
					'likeCount'			=> $COMMENTAR['likeCount'], 
					'replyToComment'	=> $COMMENTAR['replyToComment'], 
					'commentDate'		=>  timeElapsedString($COMMENTAR['date']), 
				);
			}
			
			if($POSERINFO['ally_id'] != 0){
				$sql = "SELECT ally_tag FROM %%ALLIANCE%% WHERE id = :id;";
				$POSERINFO	= database::get()->selectSingle($sql, array(
					':id'	=> $POSERINFO['ally_id']
				));
				$AllyTag = $POSERINFO['ally_tag'];
			}
						
			$COMMENTDATA[] = array(
				'commendId'	 		=> $COMMENT['id'], 
				'name'	 			=> $COMMENT['name'],
				'avatar'	 		=> $AVATAR,
				'username' 			=> $UName,
				'alreadyLiked'	 	=> $alreadyLiked, 
				'alreadyFlagged'	 => $alreadyFlagged, 
				'alliance'		 	=> $AllyTag, 
				'comment'			=> $COMMENT['flagAmount'] >= 3 && $COMMENT['isApprouved'] == 0 ? "<span style='color:red;'>".$LNG['hofComment_5']."</span>" : $COMMENT['comment'], 
				'likeCount'			=> $COMMENT['likeCount'], 
				'replyToComment'	=> $COMMENT['replyToComment'], 
				'commentDate'		=> timeElapsedString($COMMENT['date']), 
				'COMMENTDATAS'		=> $COMMENTDATAS, 
			);
		}

$sql	= "SELECT isChat FROM %%USERS%% WHERE id = :userId;";
			$commentUserData = Database::get()->selectSingle($sql, array(
				':userId'	=> $USER['id']
			));


		$this->assign(array(
			'Raport'	=> $combatReport,
			'Info'		=> $Info,
			'pageTitle'	=> $LNG['lm_topkb'],
			'puntos'	=> $puntos,
			'MessageCount'	=> $MessageCount,
			'RID'	=> $RID,
			'page'			=> $page,
			'encrypted_txt'	=> $encrypted_txt,
			'maxPage'		=> $maxPage,
			'COMMENTDATA'		=> $COMMENTDATA,
			'Activo'		=> $commentUserData['isChat'],
			'comments'=>	$config->comments,
			'avatar'=>	$USER['foto'],
		));
		
		//print_r($query['foto']);exit;
		$this->display('shared.mission.raport.tpl');
	}
	
	function show() 
	{
		global $LNG, $USER;
		
		$LNG->includeData(array('FLEET'));		
		$this->setWindow('popup');

		$db = Database::get();
		$config			= Config::get();

		$RID		= HTTP::_GP('raport', '');
		$page  			= HTTP::_GP('site', 1);

		$sql = "SELECT simulate, raport,attacker,defender, attacker as idsAtack, defender as idsDef FROM %%RW%% WHERE rid = :reportID;";
		$reportData = $db->selectSingle($sql, array(
			':reportID'	=> $RID
		));

		if(empty($reportData)) {
			$this->printMessage($LNG['sys_raport_not_found']);
		}
		
		// empty is BC for pre r2484
		$isAttacker = empty($reportData['attacker']) || in_array($USER['id'], explode(",", $reportData['attacker']));
		$isDefender = empty($reportData['defender']) || in_array($USER['id'], explode(",", $reportData['defender']));
		
		if(empty($reportData) || (!$isAttacker && !$isDefender)) {
			$this->printMessage($LNG['sys_raport_not_found']);
		}

		$combatReport			= unserialize($reportData['raport']);
		if($isAttacker && !$isDefender && $combatReport['result'] == 'r' && count($combatReport['rounds']) <= 2) {
			$this->printMessage($LNG['sys_raport_lost_contact']);
		}
		
		$combatReport['time']	= _date($LNG['php_tdformat'], $combatReport['time'], $USER['timezone']);
		$combatReport['simulate']	= $reportData['simulate'];
		$combatReport			= $this->BCWrapperPreRev2321($combatReport);

		if($reportData['attacker']!='')
		{

			$atacker = explode(',',$reportData['attacker']);
			$defender = explode(',',$reportData['defender']);
				$ids=array_merge($atacker,$defender);
				$usersMios='';
				for($i=0;$i<count($ids);$i++)
				{
					$usersMios.=' id_owner = '.$ids[$i];
					if($i+1 < count($ids))
						$usersMios.=' OR ';
				}
		
				$sql2	= 'SELECT total_points,username
				FROM %%STATPOINTS%%,%%USERS%%
				WHERE stat_type = :statType AND %%USERS%%.id = id_owner OR (:users)';
		
				$statData	= Database::get()->select($sql2, array(
					':users'	=> $usersMios,
					':statType'	=> 1
				));
		
				$puntos=[];
				foreach($statData as $item)
				{
					$puntos[$item['username']] = $item['total_points'];
					$puntos['Aliens'] = 10000;
					$puntos['Piratas'] = 10000;
				}
		}
		else
		{
            foreach($combatReport['players'] as $key=>$item)
			{
				$puntos[$item['name']]=10000;
			}
		}

		/**
		 * MIO añadir comment by yamilrh
		 *
		**/

		$cusNickCom = empty($USER['username']) ? $USER['username'] : $USER['username'];
		//RID-USERID-USERNAME
		$plainText = $RID.'-'.$USER['id'].'-'.$cusNickCom;
		$encrypted_txt = encrypt_decrypt('encrypt', $plainText);
		
		$sql = "SELECT COUNT(*) as state FROM %%COMMENTSHOF%% WHERE rid = :rid;";
        $MessageCount = $db->selectSingle($sql, array(
			':rid'	=> $RID,
         ), 'state');
		 
		$maxPage	= max(1, ceil($MessageCount / 10));
        $page		= max(1, min($page, $maxPage));
		$MaxNew 	= 10;	
		
		$COMMENTDATA = array();
		$sql = "SELECT * FROM %%COMMENTSHOF%% WHERE rid = :rid AND replyToComment = :reply ORDER BY date DESC LIMIT ".(($page - 1) * $MaxNew).",".$MaxNew.";";
		$COMMENTS	= database::get()->select($sql, array(
			':rid'	=> $RID,
			':reply'=> 0
		));
		
		foreach($COMMENTS as $COMMENT){
			
			
			$LikedQueue		= explode(';', $COMMENT['likeinfo']);
			$LikeArray		= array();
			
			$FlagQueue		= explode(';', $COMMENT['flagInfo']);
			$FlagArray		= array();
			
			$alreadyLiked	= 0;
			$alreadyFlagged	= 0;
			
			if(!empty($COMMENT['likeinfo'])){
				foreach($LikedQueue as $Like)
				{
					$temp = explode(',', $Like);
					$LikeArray[] 		= array($temp[0], $temp[1]);
				}

				foreach($LikeArray as $Like)
				{

					if($Like[0] == $USER['id'])
						$alreadyLiked = 1;
				}
			}else{
				$alreadyLiked = 0;
			}
			
			if(!empty($COMMENT['flagInfo'])){
				foreach($FlagQueue as $Likes)
				{
					$temps = explode(',', $Likes);
					$FlagArray[] 		= array($temps[0], $temps[1]);
				}

				foreach($FlagArray as $Likes)
				{

					if($Likes[0] == $USER['id'])
						$alreadyFlagged = 1;
				}
			}else{
				$alreadyFlagged = 0;
			}
			
			$sql = "SELECT ally_id,foto FROM %%USERS%% WHERE id = :id;";
			$POSERINFO	= database::get()->selectSingle($sql, array(
				':id'	=> $COMMENT['Userid']
			));
			$AVATAR = $POSERINFO['foto'];

			$AllyTag = "";
			if($POSERINFO['ally_id'] != 0){
				$sql = "SELECT ally_tag FROM %%ALLIANCE%% WHERE id = :id;";
				$POSERINFO	= database::get()->selectSingle($sql, array(
					':id'	=> $POSERINFO['ally_id']
				));
				$AllyTag = $POSERINFO['ally_tag'];
			}
			
			$COMMENTDATA[] = array(
				'commendId'	 		=> $COMMENT['id'], 
				'name'	 			=> $COMMENT['name'],
				'avatar'	 		=> $AVATAR,
				'alreadyLiked'	 	=> $alreadyLiked, 				
				'alreadyFlagged'	=> $alreadyFlagged, 				
				'alliance'		 	=> $AllyTag,
				'comment'			=> $COMMENT['flagAmount'] >= 3 && $COMMENT['isApprouved'] == 0 ? "<span style='color:red;'>".$LNG['hofComment_5']."</span>" : $COMMENT['comment'], 
				'likeCount'			=> $COMMENT['likeCount'], 
				'replyToComment'	=> $COMMENT['replyToComment'], 
				'commentDate'		=>  timeElapsedString($COMMENT['date']), 
			);
		}

$sql	= "SELECT isChat FROM %%USERS%% WHERE id = :userId;";
			$commentUserData = Database::get()->selectSingle($sql, array(
				':userId'	=> $USER['id']
			));

			
		$this->assign(array(
			'Raport'	=> $combatReport,
			'pageTitle'	=> $LNG['sys_mess_attack_report'],
			'puntos' 	=> $puntos,
			'MessageCount'	=> $MessageCount,
			'RID'	=> $RID,
			'page'			=> $page,
			'encrypted_txt'	=> $encrypted_txt,
			'maxPage'		=> $maxPage,
			'COMMENTDATA'		=> $COMMENTDATA,
			'Activo'		=> $commentUserData['isChat'],
			'avatar'		=> $USER['foto'],
			'comments'=>$config->comments,
		));
		
		$this->display('shared.mission.raport.tpl');
	}
}
