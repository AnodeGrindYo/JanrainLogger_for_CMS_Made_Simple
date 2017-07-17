<?php
// sécurité CMSMS
// if (! isset($gCms)) exit; // A ENLEVER SI CA FONCTIONNE SANS
/* Voici un script PHP très simple et détaillé qui implémente le traitement Engage
*  token URL et quelques exemples populaires Pro / Enterprise. Le code ci-dessous
*  suppose quel'on a la bibliothèque CURL HTTP fetching avec SSL.
*/
ini_set('display_errors', 1);
echo 'entered in rpx-token-url<br>';
// debugging
require('ChromePhp.php');
require('helpers.php');
echo 'require OK<br>';
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
    ChromePhp::log($token);
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
    ChromePhp::log($result);
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
            include('social_login_pro_examples.php');
        }
        // Etape 4: Votre code va ici! Utilisez l'identifiant dans
        // $auth_info['profile']['identifier'] Comme clé unique pour connecter
        // l'utilisateur à l'appli.

        // Chargement du fichier config CMSMS pour les idenfiants à la bdd
        include ('../../config.php');

        // Connexion à la bdd
        // $db =& $this->GetDb(); // connexion à la bdd
        $conn = new mysqli( $config['db_hostname'],
        $config['db_username'],
        $config['db_password'],
        $config['db_name']);
        ChromePhp::log($config['db_name']);

        if ($conn->connect_errno)
        {
            echo "Echec lors de la connexion à MySQL : (" . $conn->connect_errno . ") " . $conn->connect_error;
            ChromePhp::log('Echec lors de la connexion à MySQL');
        }

        // requête (vérifiez voter préfixe pour la table)
        $query = "
        SELECT userid, first_name, last_name, identifier, email
        FROM cms_module_JanrainLogger_users
        WHERE email = '".$auth_info['profile']['email']."';";
        ChromePhp::log($query);
        ChromePhp::log('identifier : '.$auth_info['profile']['identifier']);
        ChromePhp::log('display name : '.$auth_info['profile']['displayName']);
        ChromePhp::log('email : '.$auth_info['profile']['email']);
        // exécution de la requête
        // $result = &$db->GetRow($query);
        $result = $conn->query($query);
        ChromePhp::log('réponse de la requête : '.count($result));
        ChromePhp::log(print_r($result));
        ChromePhp::log('Contenu de $row : '.mysqli_fetch_array($result));
        // ChromePhp::log('$result : '.$result);
        if ($result->num_rows == 0) // dans ce cas, il s'agit d'un nouvel utilisateur
        {
            ChromePhp::log('nouveau compte');
            if($auth_info['profile']['email']==null)
            {

            }
            else
            {
                // création d'un nouveau compte (vérifiez votre préfixe pour la table)
                $query = "
                INSERT INTO cms_module_JanrainLogger_users
                (identifier, display_name, first_name, last_name, email, avatar)
                VALUES ('"
                .$auth_info['profile']['identifier']."', '"
                .$auth_info['profile']['displayName']."', '"
                .$auth_info['profile']['name']['givenName']."', '"
                .$auth_info['profile']['name']['familyName']."', '"
                .$auth_info['profile']['email']."', '"
                .$auth_info['profile']['photo'].
                "')";
                ChromePhp::log($query);
                $dbadd = $conn->query($query);
                ChromePhp::log('$dbadd : '.$dbadd);
                // on démarre la session utilisateur
                session_start();
                // on enregistre une variable de session pour l'utilisateur
                // TODO trouver un moyen de ne pas écrire en dur le nom de domaine dans la fonction header
                $_SESSION['user_id'] = $auth_info['profile']['identifier'];
                // header('Location: https://'.GetPreference('AppDomain'));
                echo "<script>alert(\"nouvel utilisateur enregistré et connecté:\n
                ".$auth_info['profile']['identifier']."\")</script>";
                // header('Location: https://www.ericfreelancedev.com');
            }
        }
        else // c'est un utilisateur connu
        {
            ChromePhp::log('compte existant');
            // on démarre la session utilisateur
            session_start();
            // on enregistre une variable de session pour l'utilisateur
            $_SESSION['user_id'] = $auth_info['profile']['identifier'];
            echo "<script>alert(\"connecté:\n
            ".$auth_info['profile']['identifier']."\")</script>";

            // header('Location: https://'.GetPreference('AppDomain'));
            // header('Location: https://www.ericfreelancedev.com');
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
// header('Location: https://www.ericfreelancedev.com');
