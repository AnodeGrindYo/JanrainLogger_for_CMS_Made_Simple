{*
	Résultat de la connexion
*}

{if $profil == 'false'}
<div class="container text-left">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="alert alert-danger">
				Il nous manque des informations!
			</div>
		    {$formStart}
		    	<div class="form-group{if $displayName neq ''} hidden{/if}">
		            <label for="{$actionId}displayName">Pseudo :</label>
		            <input type="text" class="form-control" id="{$actionId}displayName" placeholder="Votre pseudo" name="{$actionId}displayName" value="{$displayName}">
		        </div>
		        {if isset($errorDisplayName)}
		        <div class="alert alert-danger">
					{$errorDisplayName}
				</div>
				{/if}
		        <div class="form-group{if $firstName neq ''} hidden{/if}">
		            <label for="{$actionId}firstName">Prénom :</label>
		            <input type="text" class="form-control" id="{$actionId}firstName" placeholder="Votre prénom" name="{$actionId}firstName" value="{$firstName}">
		        </div>
		        {if isset($errorFirstName)}
		        <div class="alert alert-danger">
					{$errorFirstName}
				</div>
				{/if}
		        <div class="form-group{if $lastName neq ''} hidden{/if}">
		            <label for="{$actionId}lastName">Nom :</label>
		            <input type="text" class="form-control" id="{$actionId}lastName" placeholder="Votre nom" name="{$actionId}lastName" value="{$lastName}">
		        </div>
		        {if isset($errorLastName)}
		        <div class="alert alert-danger">
					{$errorLastName}
				</div>
				{/if}
		        <div class="form-group{if $email neq ''} hidden{/if}">
		            <label for="{$actionId}email">Email :</label>
		            <input type="text" class="form-control" id="{$actionId}email" placeholder="Votre email" name="{$actionId}email">
		        </div>
		        {if isset($errorEmail)}
		        <div class="alert alert-danger">
					{$errorEmail}
				</div>
				{/if}
		        <input type="hidden" id="{$actionId}userIdentifier" name="{$actionId}userIdentifier" value="{$userIdentifier}"></input>
		        <input type="hidden" id="{$actionId}avatar" name="{$actionId}avatar" value="{$avatar}"></input>
		        <button type="submit" class="btn btn-default">Enregistrer</button>
		    </form>
		</div>
	</div>
</div>
{else}
<div class="container text-left">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="alert alert-success">
				Merci pour ces informations.
			</div>
		</div>
	</div>
</div>
{/if}