<?php
// sécurité CMSMS
if (! isset($gCms)) exit; // A ENLEVER SI CA FONCTIONNE SANS
/* Voici un script PHP très simple et détaillé qui implémente le traitement Engage
*  token URL et quelques exemples populaires Pro / Enterprise. Le code ci-dessous
*  suppose quel'on a la bibliothèque CURL HTTP fetching avec SSL.
*/
ini_set('display_errors', 1);
echo 'entered in rpx-token-url';
require({root_url}.'/modules/JanrainLogger/helpers.php');
ob_start();
/* PATH_TO_API_KEY_FILE doit contenir un chemin d'accès vers un fichier texte
*  simple contenant uniquement la clé API. Ce fichier doit exister dans un
*  chemin qui peut être lu par le serveur Web, mais pas accessible au public
*  sur Internet.
*/

// $ApiKeyFile = 'ApiKeyFile.txt';// chemin vers le fichier qui contient l'API Key
// $janrain_api_key = $this->GetPreference('ApiKey'); // <=======
$janrain_api_key = "2bc89ae3fb9f3e7ad095806cc117c14337f7d865";
// $janrain_api_key = trim(file_get_contents($ApiKeyFile));
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
        echo "\n auth_info:";
        echo "\n"; var_dump($auth_info);
        // Exemple pour la version pro et entreprise
        if ($social_login_pro) {
            include({root_url}.'/modules/JanrainLogger/social_login_pro_examples.php');
        }
        // Etape 4: Votre code va ici! Utilisez l'identifiant dans
        // $auth_info['profile']['identifier'] Comme clé unique pour connecter
        // l'utilisateur à l'appli.
        $db =& $this->GetDb(); // connexion à la bdd
        // requête
        $query = "
        SELECT userid, first_name, last_name, identifier, email
        FROM ".cms_db_prefix() ."module_JanrainLogger_users
        WHERE identifier = ".$auth_info['profile']['identifier'];

        // exécution de la requête
        $row = &$db->GetRow($query);
        if (!$row || count($row) == 0) // dans ce cas, il s'agit d'un nouvel utilisateur
        {
            // création d'un nouveau compte
            $query = "
            INSERT INTO module_JanrainLogger_users
            (identifier, display_name, email, avatar)
            VALUES ('".
            .$auth_info['profile']['identifier']."', '"
            .$auth_info['profile']['displayName']."', '"
            .$auth_info['profile']['email']."', '"
            .$auth_info['profile']['photo'].
            "')";
            $dbadd =& $db->Execute($query);
            // on démarre la session utilisateur
            session_start();
            // on enregistre une variable de session pour l'utilisateur
            $_SESSION['user_id'] = $auth_info['profile']['identifier'];
            // header('Location: https://'.GetPreference('AppDomain'));
        }
        else // c'est un utilisateur connu
        {
            // on démarre la session utilisateur
            session_start();
            // on enregistre une variable de session pour l'utilisateur
            $_SESSION['user_id'] = $auth_info['profile']['identifier'];
            // header('Location: https://'.GetPreference('AppDomain'));
        }


    } else
    {
        // Gère l'erreur auth_info.
        output('An error occurred', $auth_info);
        output('result', $result);
    }
} else
{
    echo 'No authentication token.';
}
$debug_out = ob_get_contents();
ob_end_clean();
