<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Field Names
$lang['backups_amazons3_name']										= 'Amazon S3';
$lang['backups_amazons3_access_key']								= 'Chiave di accesso Amazon (Access Key)';
$lang['backups_amazons3_access_key_placeholder']					= 'La tua chiave di accesso (Access Key)';
$lang['backups_amazons3_secret_key']								= 'Chiave segreta Amazon (Secret Key)';
$lang['backups_amazons3_secret_key_placeholder']					= 'La tua chiave segreta (Secret Key)';
$lang['backups_amazons3_bucket']									= 'Amazon Bucket';
$lang['backups_amazons3_bucket_placeholder']						= 'Posto (Bucket) dove salvare i backups ';
$lang['backups_amazons3_path']										= 'Path per il backup su Amazon';
$lang['backups_amazons3_path_root']									= 'Cartella principale (Root)';
$lang['backups_amazons3_path_other']								= 'Altro';
$lang['backups_amazons3_path_other_placeholder']					= '/path/alla/cartella/';

// Validation failures
$lang['backups_amazons3_validation_failed']							= 'Le credenziali Amazon S3 non sono corrette, o il posto (bucket) \'%s\' non esiste.';
$lang['backups_amazons3_validation_path']							= 'Il percorso del file contiene caratteri non consentiti.';

// Erros for the Backup Method
$lang['backups_amazons3_errors_no_bucket_or_auth']					= 'Il posto (bucket) specificato non è stato trovato o i dettagli dell\'account non sono più validi.';
$lang['backups_amazons3_errors_put_file']							= 'Il file di backup non può essere caricato nel server Amazon S3.';