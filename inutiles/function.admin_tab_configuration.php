<?php
if (!isset($gCms)) exit;
// Verification de la permission
if (! $this->VisibleToAdminUser()) {
 echo $this->ShowErrors($this->Lang('accessdenied'));
 return;
}
// On définit dans smarty un début de formulaire
// $id permet de protéger les formulaires
$smarty->assign('start_form', $this->CreateFormStart($id, 'admin_save_prefs', $returnid));
// On définit également une fin de formulaire
$smarty->assign('end_form', $this->CreateFormEnd());
//On ajoute un inputText pour préciser le domaine de l'application
$smarty->assign('AppDomain',$this->CreateInputText($id, 'domain'/*, $this->GetPreference('delay'),10,10)*/);
$smarty->assign('AppID',$this->CreateInputText($id, 'ID'/*, $this->GetPreference('delay'),10,10)*/);
$smarty->assign('ApiKey',$this->CreateInputText($id, 'Key'/*, $this->GetPreference('delay'),10,10)*/);
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->Lang('saveConfig')));
// ici, on mettra un formulaire pour la configuration du module? par exemple





/*//On ajoute un inputText pour préciser le délay avant un nettoyage automatique
$smarty->assign('input_delay',$this->CreateInputText($id, 'delay', $this->GetPreference('delay'),10,10));*/
//On ajoute une checkbox pour activer ou désactiver le nettoyage définitif
/*$smarty->assign('input_suppression',$this->CreateInputCheckbox($id, 'suppression', 1, $this->GetPreference('suppression')));*/
//On ajoute le bouton d'action type submit
/*$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->Lang('saveConfig')));*/

?>
