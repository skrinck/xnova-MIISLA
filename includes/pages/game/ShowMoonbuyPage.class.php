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


class ShowMoonBuyPage extends AbstractGamePage
{	
	public static $requireModule = 0;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $PLANET;
	
		/**
		* Coût pour la valeur d'obtention d'une nouvelle lune
		* Cost for the value of obtaining a new moon
		**/
		$cost = 35000;
		//$cost = 8750;

		$action = HTTP::_GP('action',0);

		if ($USER['urlaubs_modus'] == 0) {

			if($_POST){
				// Vérification si le joueur à assez de matière noir si le montant est insufisant
				//Check if the player with enough dark matter the amount is insufficient
				if($USER['darkmatter'] < $cost){

					// Envoie de la réponse au joueur
					// Sends response to player
				$this->printMessage("No tienes suficiente Materia Oscura, te cuesta ".$cost." MO.", true, array('game.php?page=moonbuy', 2));
					
				} else {
					// On vérifie si une lune n'est pas déjà créé sur cette planète
					// We check if a moon is not already created on this planet
					if($PLANET['planet_type'] == 1 && $PLANET['id_luna'] == 0){

						// Création de la lune au joueur sur la planète ou il a validé la demande
						// Creation of the moon to the player on the planet or it has validated the request
						$Diameter = mt_rand(8000, 8500);
						$moonId = PlayerUtil::createMoon(Universe::current(), $PLANET['galaxy'], $PLANET['system'],
						$PLANET['planet'], $PLANET['id_owner'], 20, $Diameter, 'Moon');

						/**
						* Aucune erreur Déduction du coût de la création au joueur
						* No mistake Deduction of the cost of creation to the player
						**/
						if($moonId !== false) {
							// Déduction du coût de la création au joueur
							// Deduction of the cost of creation to the player
							$USER['darkmatter'] -= $cost;

							// Envoie de la réponse au joueur
						// Sends response to player
						$this->printMessage("Una luna acaba de aparecer alrededor de tu planeta", true, array('game.php?page=moonBuy', 2));
						} else {
							$this->redirectTo('Ya se creo una Luna', true, array('game.php?page=overview', 2));
						}
					} else {
						// Envoie de la réponse au joueur
						// Sends response to player
						$this->printMessage("Ya tienes luna en este planeta", true, array('game.php?page=overview', 2));
					}
				}
			}

		} else {
			$this->printMessage("Error!!! estas en modo vacaciones");
		}

		$this->assign(array(
			'moonExist' => $PLANET['id_luna'],
			'cost' => pretty_number($cost),
		));

		$this->display('page.moonbuy.default.tpl');
	}
}
?>