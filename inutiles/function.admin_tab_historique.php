<?php
if (!isset($gCms)) exit;
// Verification de la permission
if (! $this->VisibleToAdminUser()) {
 echo $this->ShowErrors($this->Lang('accessdenied'));
 return;
}

// Récupère l'historique des logs
// $query = 'SELECT * FROM '.cms_db_prefix().'module_JanRainLogger_log ORDER BY log_date DESC';
// $result = $db->Execute($query);
//
// // Traitement en cas d'erreur SQL
// if ($result === false)
// {
//     echo "Database error!";
//     exit;
// }
//
// // Boucle sur les résultats et on fait une liste d'objets qui contiendra toutes les infos.
// $listeFrontal = array();
// $i = 0;
// while ($row = $result->FetchRow())
// {
//     $obj = new stdClass;
//     $obj->id = $row['log_id'];
//     $obj->date = $db->UnixTimeStamp($row['log_date']);
//     $obj->text = $row['log_texte'];
//     $obj->rowclass = ($i++%2 == 0?'row1':'row2');
//     $listeFrontal[] = $obj;
// }

//On passe à smarty les informations dans la variable nommée listeHistorique.
$smarty->assign('listeHistorique', $listeFrontal);
 //elle sera accessible dans les templates via le code {$listeHistorique}
