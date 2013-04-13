<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Field Names
$lang['backups_amazons3_name']										= 'Amazon S3';
$lang['backups_amazons3_access_key']								= 'Clé d\'accès Amazon';
$lang['backups_amazons3_access_key_placeholder']					= 'Votre clé d\'accès';
$lang['backups_amazons3_secret_key']								= 'Clé secrète Amazon';
$lang['backups_amazons3_secret_key_placeholder']					= 'Votre clé secrète';
$lang['backups_amazons3_bucket']									= 'Compartiment Amazon';
$lang['backups_amazons3_bucket_placeholder']						= 'Compartiment de sauvegarde';
$lang['backups_amazons3_path']										= 'Chemin de sauvegarde Amazon';
$lang['backups_amazons3_path_root']									= 'Dossier racine';
$lang['backups_amazons3_path_other']								= 'Autre';
$lang['backups_amazons3_path_other_placeholder']					= '/chemin/vers/dossier/';

// Validation failures
$lang['backups_amazons3_validation_failed']							= 'Les identifiants Amazon S3 sont incorrects ou le compartiment \'%s\' n\'existe pas.';
$lang['backups_amazons3_validation_path']							= 'Le chemin du fichier contient des caractères interdits.';

// Erros for the Backup Method
$lang['backups_amazons3_errors_no_bucket_or_auth']					= 'Le compartiment spécifié n\'a pas pu être trouvé ou les détails du compte ne sont plus valides.';
$lang['backups_amazons3_errors_put_file']							= 'Le fichier de sauvegarde n\'a pas pu être chargé sur le serveur Amazon S3.';