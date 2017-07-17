<?php

class JanrainLogger extends CMSModule {

	function GetName() {
		return 'JanrainLogger';
	}

	function GetFriendlyName() {
		return $this->Lang('friendlyname');
	}

	function GetVersion() {
		return '1.0.0';
	}

	function GetHelp() {
		return '';
	}

	function GetAuthor() {
		return 'Adr_G';
	}

	function IsPluginModule() {
		return true;
	}

	function HasAdmin() {
		return true;
	}

	function GetAdminSection() {
		return 'extensions';
	}

	function GetAdminDescription() {
		return '';
	}

	function VisibleToAdminUser() {
		return true;
	}

	function MinimumCMSVersion() {
		return "1.11.0";
	}

	function InitializeFrontend()
	{
		$this->RegisterModulePlugin(true, false);
		$this->RestrictUnknownParams();
		$this->SetParameterType('mode', CLEAN_STRING);
		$this->SetParameterType('displayName', CLEAN_STRING);
		$this->SetParameterType('firstName', CLEAN_STRING);
		$this->SetParameterType('lastName', CLEAN_STRING);
		$this->SetParameterType('email', CLEAN_STRING);
		$this->SetParameterType('userIdentifier', CLEAN_STRING);
		$this->SetParameterType('avatar', CLEAN_STRING);
	}

	function InstallPostMessage() {
		return $this->Lang('postinstall');
	}

	function UninstallPostMessage() {
		return $this->Lang('postuninstall');
	}

	function UninstallPreMessage() {
		return $this->Lang('really_uninstall');
	}

}
?>
