<div class="container">
	<footer>
		<p class="pull-right"><a href="#">Back to top</a></p>
		<p>© 2020 {$gameName}, Inc. · <b>TeamDevOps</b> · Powered By <a href="https://facebook.com/yamil.readigoshurtado">YamilRH</a></p>
	</footer>
</div>
<div id="dialog" style="display:none;"></div>
<script>
var LoginConfig = {
    'isMultiUniverse': {$isMultiUniverse|json},
	'unisWildcast': {$unisWildcast|json},
	'referralEnable' : {$referralEnable|json},
	'basePath' : {$basepath|json}
};
</script>
{if $analyticsEnable}
<script type="text/javascript" src="scripts/login/ga.js"></script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("{$analyticsUID}");
pageTracker._trackPageview();
} catch(err) {}</script>
{/if}
</body>
</html>