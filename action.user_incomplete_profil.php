<?php

// Sécurité
if (!isset($gCms)) exit;

// CmsMs
$config = cmsms()->GetConfig();
$smarty = cmsms()->GetSmarty();

// Session
session_start();

// Variables
$error = 0;

// On récupère les données
$displayName = ($params['displayName'] != '') ? $params['displayName'] : '';
$firstName = ($params['firstName'] != '') ? $params['firstName'] : '';
$lastName = ($params['lastName'] != '') ? $params['lastName'] : '';
$email = ($params['email'] != '') ? $params['email'] : '';
$userIdentifier = ($params['userIdentifier'] != '') ? $params['userIdentifier'] : '';
$avatar = ($params['avatar'] != '') ? $params['avatar'] : '';

// On teste si les champs ont bien été remplis
if ($displayName == '') {
	$error = 1;
	$smarty->assign('errorDisplayName', 'Vous devez saisir un pseudo!');
}

if ($firstName == '') {
	$error = 1;
	$smarty->assign('errorFirstName', 'Vous devez saisir un prénom!');
}

if ($lastName == '') {
	$error = 1;
	$smarty->assign('errorLastName', 'Vous devez saisir un nom!');
}

if ($email == '') {
	$error = 1;
	$smarty->assign('errorEmail', 'Vous devez saisir un email!');
}

// vérifie le format de l'adresse mail mieux que bootstrap
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$error = 1;
	$smarty->assign('errorEmail', 'Le format de votre adresse email est invalide');
}

// Il y a des erreurs on réaffiche le formulaire
if ($error == 1) {
	
	// Smarty
	$smarty->assign('profil', 'false');
	$smarty->assign('userIdentifier', $userIdentifier);
	$smarty->assign('displayName', $displayName);
	$smarty->assign('firstName', $firstName);
	$smarty->assign('lastName', $lastName);
	$smarty->assign('email', $email);
	$smarty->assign('avatar', $avatar);
	$smarty->assign('actionId', $id);
	$smarty->assign('formStart', $this->CreateFrontendFormStart($id, $returnid, $action = 'user_incomplete_profil', 'post'));

} else {

	// Pour les champs dates inscription, mise à jour, connexion
    $date = date('Y-m-d H:i:s');

    // Profil complété on insère dans la table
    $query = "INSERT INTO ". cms_db_prefix() ."module_JanrainLogger_users 
        (identifier, display_name, first_name, last_name, email, avatar, date_new, date_update, date_last_connect)
        values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $result = $db->Execute($query, array($userIdentifier, $displayName, $firstName, $lastName, $email, $avatar, $date, $date, $date));

    // On récupère les informations de l'utilisateur
    $query = 'SELECT * FROM '.cms_db_prefix().'module_JanrainLogger_users WHERE identifier = ?';
    $row = $db->GetRow($query, array($userIdentifier));
    
    // On mémorise le id
    $_SESSION['janrain_id'] = $row['userid'];
    
    // Utilisateur est identifé
    $_SESSION['signin'] = 1;

    // Redirection
    header('Location: '.$_SESSION['page_signin']);
    
}

// On charge le template
echo $this->ProcessTemplate('janrain_result.tpl');
