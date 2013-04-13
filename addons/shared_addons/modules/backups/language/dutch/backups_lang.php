<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Presets overview
$lang['backups_presets_title']									= 'Voorinstellingen';
$lang['backups_no_presets_defined']								= 'Er zijn geen Voorinstellingen beschikbaar.';
$lang['backups_no_presets_defined_create'] 						= 'Wilt u een '.anchor('%s', 'maken').'?';
$lang['backups_video'] 											= 'Is dit nieuw voor u? '.anchor('%s', 'Bekijk de video').'.';
$lang['backups_presets_info']									= 'Een Preset is een opgeslagen backup taak die geconfigureerd is om van bepaalde tabellen back-up te maken en deze te verzenden naar e-mail of Amazon S3.';

// Generic Actions
$lang['backups_view']											= 'Bekijk';
$lang['backups_edit']											= 'Bewerk';
$lang['backups_delete']											= 'Verwijder';
$lang['backups_run']											= 'Start';
$lang['backups_create_preset']									= 'Voeg voorinstelling toe';
$lang['backups_run_preset']										= 'Start voorinstelling nu';
$lang['backups_edit_preset_page']								= 'voorinstelling \'%s\' bewerken';
$lang['backups_edit_preset']									= 'Bewerk voorinstelling';
$lang['backups_delete_preset']									= 'Verwijder voorinstelling';

// Preset Column Names
$lang['backups_preset_name']									= 'Naam';
$lang['backups_type']											= 'Type';
$lang['backups_created']										= 'Aangemaakt';
$lang['backups_last_run']										= 'Laatste gebruik';
$lang['backups_actions']										= 'Acties';
$lang['backups_status']											= 'Status';
$lang['backups_download']										= 'Download';
$lang['backups_all_tables']										= 'Alles';

// Warnings / Flashdata
$lang['backups_delete_preset_confirm']							= 'Weet u zeker dat u deze voorinstelling wilt verwijderen? Het verwijderen van deze voorinstelling kan verzorgen dat er geen geautomatiseerde (cron jobs) back-ups worden gemaakt . Het account die verbonden is aan deze instelling zal niet verwijderd worden.';
$lang['backups_preset_created']									= 'De voorinstelling is succesvol aangemaakt.';
$lang['backups_preset_updated']									= 'De voorinstelling is succesvol bijgewerkt.';
$lang['backups_preset_not_found']								= 'Sorry, Dit voorinstelling bestaat niet.';
$lang['backups_preset_deleted']									= 'De voorinstelling is verwijderd.';
$lang['backups_no_errors']										= 'Er waren geen fouten gemeld bij het laatste taak.';
$lang['backups_passed']											= 'De back-up is succesvol uitgevoerd.';
$lang['backups_failed']											= 'De back-up kon niet aangemaakt worden. Zie de foutmelding hieronder.';

// Preset Form Fields
$lang['backups_name']											= 'Voorinstelling naam';
$lang['backups_name_placeholder']								= 'Hoe zal de voorinstelling benoemd worden?';
$lang['backups_description']									= 'Beschrijving';
$lang['backups_description_placeholder']						= 'Wat is het doel van deze voorinstelling?';
$lang['backups_tables']											= 'Tables';
$lang['backups_tables_all']										= 'Alle Tables';
$lang['backups_tables_specific']								= 'Specific Tables';
$lang['backups_tables_prefix']									= 'Tables met voorvoegsel ';
$lang['backups_tables_prefix_example']							= 'V.B. "default_" of "site1_, site2_, site_3"';
$lang['backups_tables_prefix_placeholder']						= 'Voorvoegsel';
$lang['backups_tables_prefix_with']								= 'Voorvoegsel met:';
$lang['backups_tables_select_all']								= 'Selecteer Alles';
$lang['backups_tables_select_none']								= 'Niets';
$lang['backups_backup_method']									= 'Back-up Methode';
$lang['backups_add_account']									= 'Voeg toe';
$lang['backups_backup_method_add_account']						= 'Voeg %s Account toe';
$lang['backups_public_url']										= 'Publieke link';

// Shortcuts		
$lang['backups_shortcuts']										= 'Snelkoppeling';
$lang['backups_add_preset']										= 'Voeg voorinstelling toe';
$lang['backups_list_presets']									= 'voorinstelling';
$lang['backups_list_accounts']									= 'Accounts';
$lang['backups_add_account']									= 'Voeg Account toe';
$lang['backups_take_snapshot']									= 'Download momentopname!';

// Preset Overview
$lang['backups_date_friendly']									= 'jS M Y \\a\t H:i';
$lang['backups_never_run']										= 'Start nooit';
$lang['backups_all']											= 'Alles';		
$lang['backups_view_preset']									= 'Voorinstelling Details';
$lang['backups_account_details']								= 'Account Details';
		
// Cron Jobs
$lang['backups_cron_jobs']										= 'Cron Jobs';
$lang['backups_cron_using_curl']								= 'Gebruik van cURL';
$lang['backups_cron_using_wget']								= 'Gebruik van Wget';
$lang['backups_cron_builder']									= 'Cron Job bouwer';
$lang['backups_cron_every']										= 'Elke';
$lang['backups_cron_minute']									= 'Minuut';
$lang['backups_cron_minute_every']								= 'Elke inuut';
$lang['backups_cron_hour']										= 'Uur';
$lang['backups_cron_hour_every']								= 'Elke Uur';
$lang['backups_cron_day']										= 'Dag';
$lang['backups_cron_day_every']									= 'Elke dag';
$lang['backups_cron_month']										= 'Maand';
$lang['backups_cron_month_every']								= 'Elke maand';
$lang['backups_cron_weekday']									= 'Werkdag';
$lang['backups_cron_weekday_every']								= 'Elek werkdag';
$lang['backups_cron_crontab_edit']								= 'U kunt de Cron Jobs aanpassen met de volgende commando: %s . <br />Volledige beschrijving naar Cron jobs kan <a href="%s">hier</a> gevonden worden';

// Accounts
$lang['backups_no_accounts']									= 'Er zijn accounts.';
$lang['backups_accounts_none']									= 'r zijn momenteel geen voorinstellingen met deze account.';
$lang['backups_accounts_type']									= 'Account type';
$lang['backups_accounts_info']									= 'Info';
$lang['backups_accounts_presets_using']							= 'voorinstellingen die gebruik maken van dit account';
$lang['backups_accounts_no_account']							= 'Sorry, dat account kon niet gevonden worden';
$lang['backups_edit_account']									= 'Bewerk account';
$lang['backups_account_updated']								= 'het account details zijn bijgewerkt';
$lang['backups_switch_accounts']								= 'Verander van accounts';
$lang['backups_switch_account_info']							= 'het account details zijn bijgewerkt';
$lang['backups_account_deleted']								= 'het account is verwijderd.';
$lang['backups_account_not_found']								= 'Het gekozen account kon niet gevonden worden.';
$lang['backups_no_accounts_to_change']							= 'Sommige voorinstellingen zijn afhankelijk van deze account. Maak een keuze uit onderstaande waarin het account aangepast wordt.';
$lang['backups_presets_dependent_on_account']					= 'Sommige voorinstellingen zijn afhankelijk van deze account. Maak een keuze uit onderstaande waarin het account aangepast wordt.';
$lang['backups_account_created']								= 'Het account is nu aangemaakt';
$lang['backups_delete_account_confirm']							= 'Weet u zeker dat u dit account wilt verwijderen? Cron jobs voor voorinstelingen die gebonden zijn aan dit account zullen niet meer werken.';

// No Backup Method (NULL)
$lang['backups_none_name']										= 'N.V.T.';
$lang['backups_none_account_name']								= 'Geen account';
$lang['backups_no_account_linked']								= 'Er zijn geen accounts verbonden aan deze voorinstelling';
$lang['backups_no_account_linked_cron']							= 'U kunt geen cron job aanmaken op een voorinstelling waar geen account op verbonden is.';