<?php

// Sécurité
if (!isset($gCms)) exit;

// Initialisation de la bdd
$db =& $this->GetDb();
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict = NewDataDictionary( $db );

// La table
$flds ="
userid I KEY,
first_name C(50),
last_name C(50),
display_name C(50),
identifier X,
email X,
avatar X
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_JanrainLogger_users", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Mise en place de la configuration de Jarain
$this->SetPreference('AppDomain', '');
$this->SetPreference('AppName', '');
$this->SetPreference('AppID', '');
$this->SetPreference('ApiKey', '');

// La séquence
$db->CreateSequence(cms_db_prefix()."module_JanrainLogger_users_seq");

// Permission
$this->CreatePermission('module_JanrainLogger_access', 'JanrainLogger');

// Log des install/desinstall
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('installed'));