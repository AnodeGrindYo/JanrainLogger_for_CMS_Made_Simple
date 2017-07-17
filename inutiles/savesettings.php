<?php
// juste un test
echo $_POST["AppDomain"];
echo $_POST["AppID"];
echo $_POST["APIKey"];
// Adresse du fichier qui contiendra l'API Key
$ApiKeyFile = 'ApiKey.txt';
// Adresse du fichier qui contiendra l'App ID
$AppIdFile = 'AppId.txt';
// Adresse du fichier qui contiendra le nom de domaine de l'appli
$AppDomainFile = 'AppDomain.txt';

// cette fonction est utilisée plus bas pour écrire
// le contenu des champs du formulaire dans les fichiers adéquats
function SaveInTxt($fileAdress, $stringtowrite)
{
  $FileStream = fopen($fileAdress, 'w+');
  ftruncate($FileStream, 0);
  fwrite($FileStream, $stringtowrite);
  fclose($FileStream);
}

// si les champs sont renseignés, on les enregistre dans les fichiers concernés
// le fichier texte contenant l'API Key est utilisé par rpx-token-url.php
if (isset($_POST["APIKey"]))
{
  SaveInTxt($ApiKeyFile, $_POST["APIKey"]);
  echo "API Key saved";
}
if (isset($_POST["AppID"]))
{
  SaveIntxt($AppIdFile, $_POST["AppID"]);
  echo "Application ID saved";
}
if (isset($_POST["AppDomain"]))
{
  SaveInTxt($AppDomainFile, $_POST["APIKey"]);
  echo "AppDomain Saved";
}


  // On écrit une ligne dans le log de CmsMadeSimple
  $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('prefsupdated') );
  // retour à la page d'accueil de mon module
  $this->Redirect($id, 'defaultadmin', $returnid, array('tab_message'=> 'prefsupdated', 'active_tab' => 'configuration'));
 ?>
