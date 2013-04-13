<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Field Names
$lang['backups_amazons3_name']										= 'Amazon S3';
$lang['backups_amazons3_access_key']								= 'Amazon Access Key';
$lang['backups_amazons3_access_key_placeholder']					= 'Your Access Key';
$lang['backups_amazons3_secret_key']								= 'Amazon Secret Key';
$lang['backups_amazons3_secret_key_placeholder']					= 'Your Secret Key';
$lang['backups_amazons3_bucket']									= 'Amazon Bucket';
$lang['backups_amazons3_bucket_placeholder']						= 'Bucket where backups will go';
$lang['backups_amazons3_path']										= 'Amazon Backup Path';
$lang['backups_amazons3_path_root']									= 'Root Directory';
$lang['backups_amazons3_path_other']								= 'Other';
$lang['backups_amazons3_path_other_placeholder']					= '/path/to/directory/';

// Validation failures
$lang['backups_amazons3_validation_failed']							= 'The Amazon S3 credentials are either incorrect, or the bucket \'%s\' does not exist.';
$lang['backups_amazons3_validation_path']							= 'The file path contains illegal characters.';

// Erros for the Backup Method
$lang['backups_amazons3_errors_no_bucket_or_auth']					= 'The specified bucket could not be found or the account details are no longer valid.';
$lang['backups_amazons3_errors_put_file']							= 'The backup file could not be loaded onto the Amazon S3 server.';