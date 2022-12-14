{block name="title" prepend}{$LNG.lm_alliance}{/block}
{block name="content"}

<div class="content_page">
    <div class="title">
        {$al_users_list}
    </div>

    <div>
        <form action="game.php?page=alliance&amp;mode=admin&amp;action=membersSave" method="post">
            <table id="memberList" style="width:100%;" class="tablesorter">
                <thead>
                <tr>
                    <th class="text-center">{$LNG.al_num}</th>
                    <th class="text-center">{$LNG.al_member}</th>
                    <th class="text-center">{$LNG.al_message}</th>
                    <th class="text-center">{$LNG.al_position}</th>
                    <th class="text-center">{$LNG.al_points}</th>
                    <th class="text-center">{$LNG.al_coords}</th>
                    <th class="text-center">{$LNG.al_member_since}</th>
                    <th class="text-center">{$LNG.al_estate}</th>
                    <th class="text-center">{$LNG.al_actions}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $memberList as $userID => $memberListRow}
                    <tr class="text-center">
                        <td>{$memberListRow@iteration}</td>
                        <td><a href="#" onclick="return Dialog.Playercard({$userID},'{$memberListRow.username}');">{$memberListRow.username}</a></td>
                        <td>
                            <a href="#" onclick="return Dialog.PM({$userID});">
                                <i class="far fa-envelope tooltip" data-tooltip-content="{$LNG.write_message}" style="font-size: 15px;"></i>
                            </a>
                        </td>
                        <td>{if $memberListRow.rankID == -1}{$founder}{elseif !empty($rankSelectList)}{html_options class="rankSelect" name="rank[{$userID}]" options=$rankSelectList selected=$memberListRow.rankID}{else}{$rankList[$memberListRow.rankID]}{/if}</td>
                        <td><span title="{$memberListRow.points|number}">{shortly_number($memberListRow.points)}</span></td>
                        <td><a href="game.php?page=galaxy&amp;galaxy={$memberListRow.galaxy}&amp;system={$memberListRow.system}">[{$memberListRow.galaxy}:{$memberListRow.system}:{$memberListRow.planet}]</a></td>
                        <td>{$memberListRow.register_time}</td>
                        <td>{if $rights.ONLINESTATE}{if $memberListRow.onlinetime < 4}<span style="color:lime">{$LNG.al_memberlist_on}</span>{elseif $memberListRow.onlinetime >= 4 && $memberListRow.onlinetime <= 15}<span style="color:yellow">{$memberListRow.onlinetime} {$LNG.al_memberlist_min}</span>{else}<span style="color:red">{$LNG.al_memberlist_off}</span>{/if}{else}-{/if}</td>
                        <td>{if $memberListRow.rankID != -1}
                                {if $canKick}<a href="game.php?page=alliance&amp;mode=admin&amp;action=membersKick&amp;id={$userID}" onclick="return confirm('{$memberListRow.kickQuestion}');" ><i class="fas fa-times fa-2x tooltip text-danger" data-tooltip-content="{$LNG.al_legend_kick_users}"></i>{/if}{else}-{/if}
                        </td>
                    </tr>
                {/foreach}
                </tbody>
                <tr>
                    <th colspan="9"><a class="btn btn-dark btn-xs" href="game.php?page=alliance&amp;mode=admin">{$LNG.al_back}</a></th>
                </tr>
            </table>
        </form>
    </div>
</div>

{/block}
{block name="script" append}
    <script src="scripts/base/jquery.tablesorter.js"></script>
    <script>$(function() {
            $("#memberList").tablesorter({
                headers: {
                    0: { sorter: false } ,
                    3: { sorter: false } ,
                    9: { sorter: false }
                },
                debug: false
            });

            $('.rankSelect').on('change', function () {
                $.post('game.php?page=alliance&mode=admin&action=rank&ajax=1', $(this).serialize(), function (data) {
                    NotifyBox(data);
                }, 'json');
            });
        });
    </script>
{/block}