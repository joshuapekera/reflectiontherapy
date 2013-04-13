<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Presets overview
$lang['backups_presets_title']									= 'Presets';
$lang['backups_no_presets_defined']								= 'There are no Presets';
$lang['backups_no_presets_defined_create'] 						= 'Would you like to '.anchor('%s', 'create one').'?';
$lang['backups_video'] 											= 'New to this? '.anchor('%s', 'Watch the video').'.';
$lang['backups_presets_info']									= 'A Preset is a stored backup job that has been configured to use certain tables which backs up your data via Email and Amazon S3.';

// Generic Actions
$lang['backups_view']											= 'View';
$lang['backups_edit']											= 'Edit';
$lang['backups_delete']											= 'Delete';
$lang['backups_run']											= 'Run';
$lang['backups_create_preset']									= 'Add Preset';
$lang['backups_run_preset']										= 'Run Preset Now';
$lang['backups_edit_preset_page']								= 'Editing Preset \'%s\'';
$lang['backups_edit_preset']									= 'Edit Preset';
$lang['backups_delete_preset']									= 'Delete Preset';

// Preset Column Names
$lang['backups_preset_name']									= 'Name';
$lang['backups_type']											= 'Type';
$lang['backups_created']										= 'Created';
$lang['backups_last_run']										= 'Last Run';
$lang['backups_actions']										= 'Actions';
$lang['backups_status']											= 'Status';
$lang['backups_download']										= 'Download';
$lang['backups_all_tables']										= 'All';

// Warnings / Flashdata
$lang['backups_delete_preset_confirm']							= 'Are you sure you would like to delete this Preset? This will result in backup jobs (cron jobs) not being run. The account associated with this preset will not be removed.';
$lang['backups_preset_created']									= 'The Preset has now been created successfully.';
$lang['backups_preset_updated']									= 'The Preset has been successfully updated.';
$lang['backups_preset_not_found']								= 'Sorry, this preset does not exist.';
$lang['backups_preset_deleted']									= 'The preset has been deleted.';
$lang['backups_no_errors']										= 'No errors were reported on the last run.';
$lang['backups_passed']											= 'The backup has completed successfully.';
$lang['backups_failed']											= 'The backup was not able to complete. Please see the errors below.';

// Preset Form Fields
$lang['backups_name']											= 'Preset Name';
$lang['backups_name_placeholder']								= 'What should it be called?';
$lang['backups_description']									= 'Description';
$lang['backups_description_placeholder']						= 'What is the purpose of this Preset?';
$lang['backups_tables']											= 'Tables';
$lang['backups_tables_all']										= 'All Tables';
$lang['backups_tables_specific']								= 'Specific Tables';
$lang['backups_tables_prefix']									= 'Tables With Prefix';
$lang['backups_tables_prefix_example']							= 'e.g. "default_" or "site1_, site2_, site_3"';
$lang['backups_tables_prefix_placeholder']						= 'Prefix';
$lang['backups_tables_prefix_with']								= 'Prefixed with:';
$lang['backups_tables_select_all']								= 'Select All';
$lang['backups_tables_select_none']								= 'None';
$lang['backups_backup_method']									= 'Backup Method';
$lang['backups_add_account']									= 'Add';
$lang['backups_backup_method_add_account']						= 'Add %s Account';
$lang['backups_public_url']										= 'Public URL';

// Shortcuts		
$lang['backups_shortcuts']										= 'Shortcuts';
$lang['backups_add_preset']										= 'Add Preset';
$lang['backups_list_presets']									= 'Presets';
$lang['backups_list_accounts']									= 'Accounts';
$lang['backups_add_account']									= 'Add Account';
$lang['backups_take_snapshot']									= 'Download Snapshot!';

// Preset Overview
$lang['backups_date_friendly']									= 'jS M Y \\a\t H:i';
$lang['backups_never_run']										= 'Never Run';
$lang['backups_all']											= 'All';		
$lang['backups_view_preset']									= 'Preset Details';
$lang['backups_account_details']								= 'Account Details';
		
// Cron Jobs
$lang['backups_cron_jobs']										= 'Cron Jobs';
$lang['backups_cron_using_curl']								= 'Using cURL';
$lang['backups_cron_using_wget']								= 'Using Wget';
$lang['backups_cron_builder']									= 'Cron Job Builder';
$lang['backups_cron_every']										= 'Every';
$lang['backups_cron_minute']									= 'Minute';
$lang['backups_cron_minute_every']								= 'Every Minute';
$lang['backups_cron_hour']										= 'Hour';
$lang['backups_cron_hour_every']								= 'Every Hour';
$lang['backups_cron_day']										= 'Day';
$lang['backups_cron_day_every']									= 'Every Day';
$lang['backups_cron_month']										= 'Month';
$lang['backups_cron_month_every']								= 'Every Month';
$lang['backups_cron_weekday']									= 'Weekday';
$lang['backups_cron_weekday_every']								= 'Every Weekday';
$lang['backups_cron_crontab_edit']								= 'You can typically change your Cron Jobs by issuing the following command: %s . <br />A full guide to Cron Jobs can be found <a href="%s">here</a>';

// Accounts
$lang['backups_no_accounts']									= 'There are no accounts.';
$lang['backups_accounts_none']									= 'There are currently no Presets using this account.';
$lang['backups_accounts_type']									= 'Account Type';
$lang['backups_accounts_info']									= 'Info';
$lang['backups_accounts_presets_using']							= 'Presets using this account';
$lang['backups_accounts_no_account']							= 'Sorry, that account could not be found.';
$lang['backups_edit_account']									= 'Edit Account';
$lang['backups_account_updated']								= 'The account details have been updated';
$lang['backups_switch_accounts']								= 'Switch Accounts';
$lang['backups_switch_account_info']							= 'The account details have been updated';
$lang['backups_account_deleted']								= 'The account has been deleted.';
$lang['backups_account_not_found']								= 'The specified account could not be found.';
$lang['backups_no_accounts_to_change']							= 'Sorry, some Presets depend on this account. Please create another account for them to be switched to.';
$lang['backups_presets_dependent_on_account']					= 'Some Presets are dependant on this account. Please select from below which account to change these to.';
$lang['backups_account_created']								= 'The account has now been created';
$lang['backups_delete_account_confirm']									= 'Are you sure that you want to delete this account? Cron jobs for Presets using this account will no longer work.';

// No Backup Method (NULL)
$lang['backups_none_name']										= 'N/A';
$lang['backups_none_account_name']								= 'No Account';
$lang['backups_no_account_linked']								= 'There is no account linked to this Preset';
$lang['backups_no_account_linked_cron']							= 'You cannot run a cron job on a Preset which has no account linked to it.';



