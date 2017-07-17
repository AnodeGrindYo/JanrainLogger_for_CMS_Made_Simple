{$start_form}
    <fieldset>
        <div class="pageoverflow">
            <p class="pagetext"><label for="AppDomain">Janrain Application Domain in the form https://username.rpxnow.com/</label></p>
            <p class="pageinput"><input type="text" name="{$actionid}AppDomain" value="{$AppDomain}" size="50" required></p>
        </div>
        <div class="pageoverflow">
            <p class="pagetext"><label for="AppID">Janrain Application ID</label></p>
            <p class="pageinput"><input type="text" name="{$actionid}AppID" value="{$AppID}" size="50" required></p>
        </div>
        <div class="pageoverflow">
            <p class="pagetext"><label for="ApiKey">Janrain API Key</label></p>
            <p class="pageinput"><input type="text" name="{$actionid}ApiKey" value="{$ApiKey}" size="50" required></p>
        </div>
        <div class="pageoverflow">
            <p class="pagetext"><label for="ApiKey">Nom de votre application enregistrée dans votre dashboard Janrain</label></p>
            <p class="pageinput"><input type="text" name="{$actionid}AppName" value="{$AppName}" size="50" required></p>
        </div>
    </fieldset>
    <div class="pageoverflow">
        <input type="hidden" name="{$actionid}save_config" value="1">
        <p class="pageinput"><input type="submit" name="{$actionid}submit" value="Sauvegarder"></p>
    </div>
{$end_form}