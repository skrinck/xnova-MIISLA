{block name="title" prepend}{$LNG.lm_playercard}{/block}
{block name="content"}
<div class="content_page"  style="width: 98%">
	<table style="width: 100%" class="text-center">
		<div class="title">{$LNG.pl_overview}</div>

		<div class="left_part" style="width: 55%;">
	        <div class="ally_contents" style="padding: 5px 10px 10px 10px;">
				<img title="" class="images-yamil" src="{$useravatar1}" style="float:left;height:85px;width:85px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;margin-right: 20px;    margin-bottom: 6px;">
	        	<p style="margin-top: 10px;">{$LNG.op_username}: <font style="color:#5ca6aa">{$name}</font></p>                
	        	<p style="margin-top: 10px;">{$LNG.pl_range}: <font style="color:#5ca6aa">novato</font></p>                
	        	<p style="margin-top: 10px;">{$LNG.pl_homeplanet}: <font style="color:#5ca6aa"><a href="#" onclick="parent.location = 'game.php?page=galaxy&amp;galaxy={$galaxy}&amp;system={$system}';return false;">{$homeplanet} [{$galaxy}:{$system}:{$planet}]</a></font></p>                
	        </div>
	    </div>
	    <div class="right_part" style="width:45%;">
	        <div class="ally_contents" style="padding: 5px 10px 10px 10px;margin-right:10px;">
        		<p style="margin-top: 10px;">{$LNG.pl_ally}: <font style="color:#5ca6aa">{if $allyname}<a href="#" onclick="parent.location = 'game.php?page=alliance&amp;mode=info&amp;id={$allyid}';return false;">{$allyname}</a>{else}-{/if}</font></p>
        		{if $id != $yourid}
					<p style="margin-top: 10px;"><font style="color:#5ca6aa"><a href="#" onclick="return Dialog.PM({$id});" class="tooltip" data-tooltip-content="{$LNG.write_message}">
						{$LNG.pl_send_message}
					</a></font></p>
				{/if}
        		{if $id != $yourid}
        			<p style="margin-top: 10px;"><font style="color:#5ca6aa"><a href="#" onclick="return Dialog.Buddy({$id})" class="tooltip" data-tooltip-content="{$LNG.gl_buddy_request}">
						{$LNG.pl_send_solicitud}
					</a></font></p>
				{/if}
	        </div>
	    </div>

	    <div class="clear"></div>

	    <!--<div style="cursor:pointer;margin-top: 3px;padding: 2px 6px;" class="title" >
        	 {$LNG.achiev_3} <i onclick="$('#achive_general').stop(false, true).slideToggle();" class="fas fa-angle-up"></i>
        </div> 
	    <div id="achive_general" class="playercard_achive_block" style="display: block;margin-top:4px;">
            <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_common_1_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_level.png">
                <div class="playercard_achive_block_lvl">{$achievement_common_1}</div>
            </div>
            <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_common_2_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_batle_level.png">
                <div class="playercard_achive_block_lvl">{$achievement_common_2}</div>
            </div>
            <div class="clear"></div>
        </div>-->

        <div style="cursor:pointer;margin-top: 3px;padding: 2px 6px;" class="title" >
        	 {$LNG.achiev_5} <i onclick="$('#achive_build').stop(false, true).slideToggle();" class="fas fa-angle-up"></i>
        </div>
        <div id="achive_build" class="playercard_achive_block" style="display: block;margin-top:4px;">
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_1_title}">
                <img alt="Добытчик металла" src="{$dpath}achiev/ach_mine_metal.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_1}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_2_title}">
                <img alt="Добытчик кристалла" src="{$dpath}achiev/ach_crystal_mine.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_2}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_3_title}">
                <img alt="Добытчик дейтерия" src="{$dpath}achiev/ach_deuterium_sintetizer.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_3}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_4_title}">
                <img alt="Легкий конвейер" src="{$dpath}achiev/ach_conveyor1.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_4}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_5_title}">
                <img alt="Средний конвейер" src="{$dpath}achiev/ach_conveyor2.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_5}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_6_title}">
                <img alt="Тяжёлый конвейер" src="{$dpath}achiev/ach_conveyor3.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_6}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_7_title}">
                <img alt="Технополис" src="{$dpath}achiev/ach_university.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_7}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_8_title}">
                <img alt="Лунная база" src="{$dpath}achiev/ach_mondbasis.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_8}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_9_title}">
                <img alt="Сенсорная фаланга" src="{$dpath}achiev/ach_phalanx.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_9}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_build_10_title}">
                <img alt="Терраформер" src="{$dpath}achiev/ach_terraformer.png">
                <div class="playercard_achive_block_lvl">{$achievement_build_10}</div>
            </div>
            <div class="clear"></div>
        </div>

        <div style="cursor:pointer;margin-top: 3px;padding: 2px 6px;" class="title" >
        	 {$LNG.achiev_6} <i onclick="$('#achive_tech').stop(false, true).slideToggle();" class="fas fa-angle-up"></i>
        </div>
        <div id="achive_tech" class="playercard_achive_block" style="display: block;margin-top:4px;">
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_1_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_spy_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_1}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_2_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_computer_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_2}</div>
            </div>
			
			<div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_3_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_war_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_3}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_4_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_expedition_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_4}</div>
            </div>
			
			<div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_5_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_gravity_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_5}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_6_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_gun_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_6}</div>
            </div>
			
			<div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_7_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_energy_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_7}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_8_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_bank_ally_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_8}</div>
            </div>
			
			<div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_9_title}">
                <img alt="Мирный" src="{$dpath}achiev/ach_motor_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_9}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_tech_10_title}">
                <img alt="Ветеран" src="{$dpath}achiev/ach_mining_tech.png">
                <div class="playercard_achive_block_lvl">{$achievement_tech_10}</div>
            </div>
            <div class="clear"></div>
        </div>

        <!--<div style="cursor:pointer;margin-top: 3px;padding: 2px 6px;" class="title" >
        	 {$LNG.achiev_7} <i onclick="$('#achive_fleet').stop(false, true).slideToggle();" class="fas fa-angle-up"></i>
        </div>
        <div id="achive_fleet" class="playercard_achive_block">
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_1_title}">
                <img alt="Флот Истребителей" src="{$dpath}achiev/ach_hunter_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_1}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_2_title}">
                <img alt="Флот Поддержки" src="{$dpath}achiev/ach_support_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_2}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_3_title}">
                <img alt="Боевой флот" src="{$dpath}achiev/ach_battle_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_3}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_4_title}">
                <img alt="Флот Разрушения" src="{$dpath}achiev/ach_destruction_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_4}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_5_title}">
                <img alt="Флот Осады" src="{$dpath}achiev/ach_siege_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_5}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_6_title}">
                <img alt="Тяжелый флот" src="{$dpath}achiev/ach_heavy_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_6}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_fleet_7_title}">
                <img alt="Имперский флот" src="{$dpath}achiev/ach_emperor_fleet.png">
                <div class="playercard_achive_block_lvl">{$achievement_fleet_7}</div>
            </div>
                        <div class="clear"></div>
        </div>

        <div style="cursor:pointer;margin-top: 3px;padding: 2px 6px;" class="title" >
        	 {$LNG.achiev_9} <i onclick="$('#achive_varia').stop(false, true).slideToggle();" class="fas fa-angle-up"></i>
        </div>
        <div id="achive_varia" class="playercard_achive_block" style="display: block;margin-top:4px;">
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_1_title}">
                <img alt="Боец" src="{$dpath}achiev/ach_wons.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_1}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_2_title}">
                <img alt="Уничтожитель лун" src="{$dpath}achiev/ach_destroyer_moons.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_2}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_3_title}">
                <img alt="Лунодел" src="{$dpath}achiev/ach_creation_moons.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_3}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_5_title}">
                <img alt="Удачная экспедиция" src="{$dpath}achiev/ach_expedition.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_5}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_6_title}">
                <img alt="Искатель материи" src="{$dpath}achiev/ach_found_tm.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_6}</div>
            </div>
            <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_7_title}">
                <img alt="Искатель апгрейдов" src="{$dpath}achiev/ach_found_up.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_7}</div>
            </div>
                        <div class="playercard_achive_blocks tooltip" data-tooltip-content="{$achievement_varia_8_title}">
                <img alt="Интегратор апгрейдов" src="{$dpath}achiev/ach_action_up.png">
                <div class="playercard_achive_block_lvl">{$achievement_varia_8}</div>
            </div>
            <div class="clear" ></div>
        </div>-->

        <div class="clear"></div>
        <br>

        <div>
        	<table class="text-center" style="width:100%;">
    			<tr>
	                <th class="gray_stripe text-center">{$LNG.pl_statics} </th>
	                <th class="gray_stripe text-center">{$LNG.pl_points}</th>
	                <th class="gray_stripe text-center">{$LNG.pl_range}</th>
	            </tr>
	            <tr>
					<td class="gray_stripe">{$LNG.pl_builds}</td>
					<td>{$build_points}</td>
					<td>{$build_rank}</td>
				</tr>
				<tr>
					<td class="gray_stripe">{$LNG.pl_tech}</td>
					<td>{$tech_points}</td>
					<td>{$tech_rank}</td>
				</tr>
				<tr>
					<td class="gray_stripe">{$LNG.pl_fleet}</td>
					<td>{$fleet_points}</td>
					<td>{$fleet_rank}</td>
				</tr>
				<tr>
					<td class="gray_stripe">{$LNG.pl_def}</td>
					<td>{$defs_points}</td>
					<td>{$defs_rank}</td>
				</tr>
				<tr>
					<td class="gray_stripe">{$LNG.pl_total}</td>
					<td>{$total_points}</td>
					<td>{$total_rank}</td>
				</tr>
	        </table>

	        <!--<table class="text-center" style="width:100%;">
        		<tbody>
        			<tr>
		                <th class="gray_stripe text-center">{$LNG.pl_fightstats} </th>
		                <th class="gray_stripe text-center">{$LNG.pl_fights}</th>
		                <th class="gray_stripe text-center">{$LNG.pl_fprocent}</th>
		            </tr>
		            <tr>
						<td class="gray_stripe">{$LNG.pl_fightwon}</td>
						<td>{$wons}</td>
						<td>{$siegprozent} %</td>
					</tr>
					<tr>
						<td class="gray_stripe">{$LNG.pl_fightdraw}</td>
						<td>{$draws}</td>
						<td>{$drawsprozent} %</td>
					</tr>
					<tr>
						<td class="gray_stripe">{$LNG.pl_fightlose}</td>
						<td>{$loos}</td>
						<td>{$loosprozent} %</td>
					</tr>
					<tr>
						<td class="gray_stripe">{$LNG.pl_totalfight}</td>
						<td>{$totalfights}</td>
						<td>100 %</td>
					</tr>
        		</tbody>
        	</table>-->
            <div style="margin-top: 3px;padding: 2px 6px;" class="title" >
                 {$LNG.pl_fightstats}
            </div>
            <div class="alleanza1">
                <p class="alleanza7" style="color:rgba(0, 161, 2, 0.59)">{$LNG.pl_fightwon}<br><span class="alleanza6">{$wons} ({$siegprozent}%)</span></p>
                <p class="alleanza8" style="color:rgba(161, 0, 0, 0.59)">{$LNG.pl_fightlose}<br><span class="alleanza6">{$loos} ({$loosprozent}%)</span></p>
                <p class="alleanza9">{$LNG.pl_fightdraw}<br><span class="alleanza6">{$draws} ({$drawsprozent}%)</span></p>
                <p class="alleanza10">{$LNG.pl_totalfight} <span style="float: right;">{$totalfights}</span></p>
                <p class="alleanza11">{$LNG.op_damage_coef} <span style="float: right;">{$damageCoef}</span></p>
                <div class="alleanza12 tooltip" data-tooltip-content="{$LNG.pl_unitsshot} {$desunits}" style="width:{$damageDes}%"></div>
                <div class="alleanza13 tooltip" data-tooltip-content="{$LNG.pl_unitslose} {$lostunits}" style="width:{$damageLost}%"></div>
            </div>

        </div>

        <div class="clear"></div>
	</table>
</div>
{/block}
