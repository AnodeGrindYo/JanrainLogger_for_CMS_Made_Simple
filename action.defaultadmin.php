<?php

// Sécurité
if (!isset($gCms)) exit;

// Permission
if(! $this->CheckPermission('JanrainLogger')) {
	echo $this->Lang('accessdenied');
	exit;
}

// On sauve la config si envoie du formulaire
if (isset($params['save_config'])) {
	$this->SetPreference('ApiKey', $params['ApiKey']);
	$this->SetPreference('AppName', $params['AppName']);
	$this->SetPreference('AppID', $params['AppID']);
	$this->SetPreference('AppDomain', $params['AppDomain']);
}

// Onglet par défaut
$active_tab = isset($params['active_tab'])? $params['active_tab'] : 'config';

if (FALSE == empty($params['active_tab'])) {
	$tab = $params['active_tab'];
} else {
	$tab = '';
}

// Tabs headers
$active_tab = isset($params['active_tab'])?$params['active_tab']:'config';

echo $this->StartTabHeaders();
echo $this->SetTabHeader('config', 'Configuration', ('config' == $active_tab) ? true : false);
echo $this->EndTabHeaders();

// Tab content
echo $this->StartTabContent();

// Tab config
echo $this->StartTab('config', $params);
include (dirname(__FILE__).'/function.admin_tab_config.php');
echo $this->EndTab();

// Fin tab content
echo $this->EndTabContent();