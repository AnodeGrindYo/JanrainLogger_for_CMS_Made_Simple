{*
	Template pour la connexion
*}

<script type="text/javascript">
var _rootUrl = "{root_url}";
var _appName = "{$_AppName}";
var _tokenUrl = _rootUrl+'/fr/rpx.html';

{literal}
(function() {
	if (typeof window.janrain !== 'object') window.janrain = {};
	if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};

	// Janrain Widget préférences
	janrain.settings.tokenUrl = _tokenUrl;
	janrain.settings.tokenAction = 'event';
	janrain.settings.type = 'modal';
	janrain.settings.linkClass = 'social-login-button';
	janrain.settings.language = 'fr';
	

	function isReady() {
		janrain.ready = true;
	};

	if (document.addEventListener) {
		console.log('document.addEventListenenr');
		document.addEventListener("DOMContentLoaded", isReady, false);
	} else {
		console.log('!document.addEventListener');
		window.attachEvent('onload', isReady);
	}

	var e = document.createElement('script');
	e.type = 'text/javascript';
	e.id = 'janrainAuthWidget';

	if (document.location.protocol === 'https:') {
		e.src = 'https://rpxnow.com/js/lib/'+_appName+'/engage.js';
	} else {
		e.src = 'http://widget-cdn.rpxnow.com/js/lib/'+_appName+'/engage.js';
	}

	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(e, s);
}());

function janrainWidgetOnload() {
	janrain.events.onProviderLoginToken.addHandler(function(response) {
		console.log(response);
		var form = $('<form action="' + _tokenUrl + '" method="post">' +
		'<input type="hidden" name="token" value="' + response.token + '">' +
		'</form>');
		$('body').append(form);
		form.submit();
	});
};
</script>
{/literal}

<a href="javascript:void(0)" class="btn btn-login social-login-button">
	<i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;
	<span class="hidden-sm hidden-md">{$btnJanrainLogger}</span>
</a>