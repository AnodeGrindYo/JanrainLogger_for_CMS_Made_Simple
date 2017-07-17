<?php

/* 
*  Script PHP qui implémente le traitement Engage token URL.
*  Le code ci-dessous suppose que l'on a la bibliothèque CURL HTTP fetching avec SSL.
*/

require('helpers.php');

ob_start();

// Session
session_start();

// Variables
$hasMail = true;

// On récupère la clé dans les préférences
$janrain_api_key = $this->GetPreference('ApiKey');

// Mettre true à cette variable si l'appli est pro ou entreprise
$social_login_pro = false;

// Etape 1: Extrait le paramètre POST token
$token = $_POST['token'];

if ($token) {

    // Etape 2: Utilisez le token pour appeler l'API auth_info.
    $post_data = array(
        'token' => $token,
        'apiKey' => $janrain_api_key,
        'format' => 'json'
        );

    if ($social_login_pro) {
        $post_data['extended'] = 'true';
    }

    $curl = curl_init();
    $url = 'https://rpxnow.com/api/v2/auth_info';
    $result = curl_helper_post($curl, $url, $post_data);
    
    if ($result == false) {
        curl_helper_error($curl, $url, $post_data);
        die();
    }

    curl_close($curl);

    // Etape 3: Parse la réponse de JSON auth_info response
    $auth_info = json_decode($result, true);

    if ($auth_info['stat'] == 'ok') {

        // On ouvre la session utilisateur
        $_SESSION['token'] = $token;

        // Information Janrain de l'utilisateur
        $userIdentifier = $auth_info['profile']['identifier'];
        $displayName = $auth_info['profile']['displayName'];
        $firstName = $auth_info['profile']['name']['givenName'];
        $lastName = $auth_info['profile']['name']['familyName'];
        $email = $auth_info['profile']['email'];
        $avatar = $auth_info['profile']['photo'];
        
        // Pour les champs dates inscription, mise à jour, connexion
        $date = date('Y-m-d H:i:s');

        // On regarde si l'utilisateur existe déjà chez nous
        $query = 'SELECT * FROM '.cms_db_prefix().'module_JanrainLogger_users WHERE identifier = ?';
        $row = $db->GetRow($query, array($userIdentifier));     

        // On teste le resultat de la recherche de l'utilisateur
        if (!$row || count($row) == 0) {
            // Dans ce cas, il s'agit d'un nouvel utilisateur                
            if($email == '' || $displayName == '' || $firstName == '' || $lastName == '') {
                // Profil incomplet on affiche le formulaire pour compléter les infos
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
                // Profil complet on insère dans la table
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
        } else {
            // L'utilisateur existe, on met à jour la date de dernière connexion
            $query = 'UPDATE '.cms_db_prefix().'module_JanrainLogger_users SET date_last_connect = ? WHERE identifier = ?';
            $db->Execute($query,array(date('Y-m-d H:i:s'),$userIdentifier));

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
    }
}

$debug_out = ob_get_contents();
ob_end_clean();