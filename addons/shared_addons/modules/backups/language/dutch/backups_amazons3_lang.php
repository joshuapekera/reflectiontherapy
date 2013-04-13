<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Field Names
$lang['backups_amazons3_name']										= 'Amazon S3';
$lang['backups_amazons3_access_key']								= 'Amazon toegangs sleutel';
$lang['backups_amazons3_access_key_placeholder']					= 'Jouw toegangs sleutel';
$lang['backups_amazons3_secret_key']								= 'Amazon geheime sleutel';
$lang['backups_amazons3_secret_key_placeholder']					= 'Jouw geheime sleutel';
$lang['backups_amazons3_bucket']									= 'Amazon Bucket';
$lang['backups_amazons3_bucket_placeholder']						= 'Bucket Waar de back-up heen gaat';
$lang['backups_amazons3_path']										= 'Amazon back-up locatie';
$lang['backups_amazons3_path_root']									= 'Root Directory';
$lang['backups_amazons3_path_other']								= 'Anders';
$lang['backups_amazons3_path_other_placeholder']					= '/locatie/naar/map/';

// Validation failures
$lang['backups_amazons3_validation_failed']							= 'De Amazone S3 referenties zijn onjuist, of de Bucket \'%s\' bestaat niet.';
$lang['backups_amazons3_validation_path']							= 'het bestandspad bevat ongeldige tekens.';

// Erros for the Backup Method
$lang['backups_amazons3_errors_no_bucket_or_auth']					= 'De opgegeven Bucket kon niet worden gevonden of de accountgegevens zijn niet meer geldig.';
$lang['backups_amazons3_errors_put_file']							= 'De back-up bestand kan niet worden geladen op de Amazon S3-server.';