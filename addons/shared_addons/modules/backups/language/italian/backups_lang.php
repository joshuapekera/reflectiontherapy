<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Presets overview
$lang['backups_presets_title']									= 'Presets';
$lang['backups_no_presets_defined']								= 'Non ci sono Presets';
$lang['backups_no_presets_defined_create'] 						= 'Vuoi '.anchor('%s', 'crearne uno').'?';
$lang['backups_video'] 											= 'E\' la prima volta? '.anchor('%s', 'Guarda il video').'.';
$lang['backups_presets_info']									= 'Un Preset è un lavoro automatico predefinito configurato per fare il backup delle tabelle del database e salvarle su Amazon S3, Dropbox o inviarle via email.';

// Generic Actions
$lang['backups_view']											= 'Vedi';
$lang['backups_edit']											= 'Modifica';
$lang['backups_delete']											= 'Cancella';
$lang['backups_run']											= 'Avvia';
$lang['backups_create_preset']									= 'Aggiungi Preset';
$lang['backups_run_preset']										= 'Avvia Preset Adesso';
$lang['backups_edit_preset_page']								= 'Modificando Preset \'%s\'';
$lang['backups_edit_preset']									= 'Modifica Preset';
$lang['backups_delete_preset']									= 'Cancella Preset';

// Preset Column Names
$lang['backups_preset_name']									= 'Nome';
$lang['backups_type']											= 'Tipo';
$lang['backups_created']										= 'Creato';
$lang['backups_last_run']										= 'Ultimo avvio';
$lang['backups_actions']										= 'Azioni';
$lang['backups_status']											= 'Stato';
$lang['backups_download']										= 'Download';
$lang['backups_all_tables']										= 'Tutti';

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
$lang['backups_name']											= 'Nome Preset';
$lang['backups_name_placeholder']								= 'Come vuoi chiamarlo?';
$lang['backups_description']									= 'Descrizione';
$lang['backups_description_placeholder']						= 'Quale è lo scopo di questo Preset?';
$lang['backups_tables']											= 'Tabelle';
$lang['backups_tables_all']										= 'Tutte le tabelle';
$lang['backups_tables_specific']								= 'Tabelle selezionate';
$lang['backups_tables_prefix']									= 'Tabelle con Prefisso';
$lang['backups_tables_prefix_example']							= 'es. "default_" o "sito1_, sito2_, sito_3"';
$lang['backups_tables_prefix_placeholder']						= 'Prefisso';
$lang['backups_tables_prefix_with']								= 'Usa il prefisso:';
$lang['backups_tables_select_all']								= 'Seleziona tutto';
$lang['backups_tables_select_none']								= 'Nessuna';
$lang['backups_backup_method']									= 'Metodo di Backup';
$lang['backups_add_account']									= 'Aggiungi';
$lang['backups_backup_method_add_account']						= 'Aggiungi %s Account';
$lang['backups_public_url']										= 'URL pubblico';

// Shortcuts		
$lang['backups_shortcuts']										= 'Azioni veloci';
$lang['backups_add_preset']										= 'Aggiungi Preset';
$lang['backups_list_presets']									= 'Presets';
$lang['backups_list_accounts']									= 'Account';
$lang['backups_add_account']									= 'Aggiungi Account';
$lang['backups_take_snapshot']									= 'Download Snapshot!';

// Preset Overview
$lang['backups_date_friendly']									= 'jS M Y \\a\t H:i';
$lang['backups_never_run']										= 'Mai avviato';
$lang['backups_all']											= 'Tutti';		
$lang['backups_view_preset']									= 'Dettagli Preset';
$lang['backups_account_details']								= 'Dettagli Account';
		
// Cron Jobs
$lang['backups_cron_jobs']										= 'Cron Jobs';
$lang['backups_cron_using_curl']								= 'Usa cURL';
$lang['backups_cron_using_wget']								= 'Usa Wget';
$lang['backups_cron_builder']									= 'Creatore Cron Job';
$lang['backups_cron_every']										= 'Ogni';
$lang['backups_cron_minute']									= 'Minuto';
$lang['backups_cron_minute_every']								= 'Ogni minuto';
$lang['backups_cron_hour']										= 'Ora';
$lang['backups_cron_hour_every']								= 'Ogni ora';
$lang['backups_cron_day']										= 'Giorno';
$lang['backups_cron_day_every']									= 'Ogni giorno';
$lang['backups_cron_month']										= 'Mese';
$lang['backups_cron_month_every']								= 'Ogni mese';
$lang['backups_cron_weekday']									= 'Giorno della settimana';
$lang['backups_cron_weekday_every']								= 'ogni giorno della settimana';
$lang['backups_cron_crontab_edit']								= 'Di solito puoi cambiare il Cron Jobs utilizzando questo comando: %s . <br />Una guida completa ai Cron Jobs può essere trovata <a href="%s">qui</a>';

// Accounts
$lang['backups_no_accounts']									= 'Non ci sono account.';
$lang['backups_accounts_none']									= 'Non ci sono Presets che utilizzano questo account.';
$lang['backups_accounts_type']									= 'Tipo di Account';
$lang['backups_accounts_info']									= 'Info';
$lang['backups_accounts_presets_using']							= 'Presets che utilizzano questo account';
$lang['backups_accounts_no_account']							= 'Spiacenti, questo account non è stato trovato.';
$lang['backups_edit_account']									= 'Modifica Account';
$lang['backups_account_updated']								= 'I dettagli dell\'account sono stati aggiornati';
$lang['backups_switch_accounts']								= 'Cambia Account';
$lang['backups_switch_account_info']							= 'I dettagli dell\'account sono stati aggiornati';
$lang['backups_account_deleted']								= 'L\'account è stato eliminato.';
$lang['backups_account_not_found']								= 'L\'account indicato non può essere trovato.';
$lang['backups_no_accounts_to_change']							= 'Spiacenti, alcuni Preset dipendono da questo account. Per favore crea un altro account al quale associarli.';
$lang['backups_presets_dependent_on_account']					= 'Alcuni Presets dipendono da questo account. Please select from below which account to change these to.';
$lang['backups_account_created']								= 'L\'account è stato creato.';
$lang['backups_delete_account_confirm']							= 'Sei sicuro di voler cancellare questo account? I Cron jobs per i Preset che utilizzano questo account non funzioneranno più.';

// No Backup Method (NULL)
$lang['backups_none_name']										= 'N/A';
$lang['backups_none_account_name']								= 'Nessun Account';
$lang['backups_no_account_linked']								= 'Non c\'è nessun account colelgato a questo Preset';
$lang['backups_no_account_linked_cron']							= 'Non puoi avviare un cron job su un Preset che non è associato a nessun account.';