<?php

// Sécurité
if (!isset($gCms)) exit;

// CmsMs
$config = cmsms()->GetConfig();
$smarty = cmsms()->GetSmarty();

// Session
session_start();

// Action login 
// Affiche le bouton de connexion et une fenêtre 
// avec les réseaux sociaux lors du click pour s'inscrire ou s'identifier

if (isset($params['mode']) && $params['mode'] == 'login') {
	
	// Bouton de connexion
	$smarty->assign('btnJanrainLogger', $this->lang('btn_login_with_Janrain'));
	$smarty->assign('_AppName', $this->GetPreference('AppName'));

	// On charge le template
	echo $this->ProcessTemplate('janrain.tpl');

}

// Pour la page de retour après l'identification
// On récupère les informations et on teste si l'utilisateur est déjà inscrit
// Si il n'est pas inscrit on le rentre dans la table

if (isset($params['mode']) && $params['mode'] == 'rpx') {

	// On mémorise l'adresse de la page lors de la demande d'identification
	$_SESSION['page_signin'] = $_SERVER["HTTP_REFERER"];

	// Action pour vérifier si l'utilisateur existe ou non et donc le créer
	include (realpath(dirname(__FILE__) . '/action.user_signin.php'));

	// On charge le template
	echo $this->ProcessTemplate('janrain_result.tpl');
}