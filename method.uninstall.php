<?php
// sécurité
if (!isset($gCms)) exit;



// suppression des tables et des préférences liées au module
$db =& $this->GetDb();

// suppression des templates
$this->DeleteTemplate('defaultadmin');
$this->DeleteTemplate('janrain');

// remove the database module_JanrainLogger_users
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_JanrainLogger_users" );
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence( cms_db_prefix()."module_JanrainLogger_users_seq" );

// suppression des permissions
$this->RemovePermission('module_JanrainLogger_access');
// retire les préférences
$this->RemovePreference();
// supprime tous les templates
$this->DeleteTemplate();

$this->RemoveSmartyPlugin();

cms_route_manager::del_static('',$this->GetName());

// maj du log de CmsMadeSimple
// $this->Audit(( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled')));
