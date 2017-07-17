<?php

// Sécurité
if (!isset($gCms)) exit;

// Permission
if (! $this->VisibleToAdminUser()) {
	echo $this->ShowErrors($this->Lang('accessdenied'));
	return;
}

// On enregistre la configuration
$this->SetPreference('ApiKey', $params['ApiKey']);
$this->SetPreference('AppName', $params['AppName']);
$this->SetPreference('AppID', $params['AppID']);
$this->SetPreference('AppDomain', $params['AppDomain']);