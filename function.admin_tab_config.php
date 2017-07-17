<?php

// Sécurité
if (! isset($gCms)) exit;

// Permission
if (! $this->VisibleToAdminUser()) {
	echo $this->ShowErrors($this->Lang('accessdenied'));
	return;
}

// Action du formulaire
$smarty->assign('start_form', $this->CreateFormStart($id, 'defaultadmin', $returnid));

// Id du formulaire
$smarty->assign('actionid', $id);

// On récupère les préférences et on les assigne
$smarty->assign('ApiKey', $this->GetPreference('ApiKey'));
$smarty->assign('AppID', $this->GetPreference('AppID'));
$smarty->assign('AppDomain', $this->GetPreference('AppDomain'));
$smarty->assign('AppName', $this->GetPreference('AppName'));

// On charge le template
echo $this->ProcessTemplate('admin_config.tpl');