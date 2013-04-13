<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Presets overview
$lang['backups_presets_title']									= 'Paramétrages';
$lang['backups_no_presets_defined']								= 'Il n\'y a pas de paramétrage';
$lang['backups_no_presets_defined_create'] 						= 'Souhaitez-vous en '.anchor('%s', 'créer un').' ?';
$lang['backups_video'] 											= 'Nouveau venu ? '.anchor('%s', 'Consultez la vidéo').'.';
$lang['backups_presets_info']									= 'Un paramétrage est une routine de sauvegarde enregistrée qui a été configurée pour utiliser certaines tables et qui effectue une sauvegarde de vos données via email ou Amazon S3.';

// Generic Actions
$lang['backups_view']											= 'Voir';
$lang['backups_edit']											= 'Editer';
$lang['backups_delete']											= 'Supprimer';
$lang['backups_run']											= 'Lancer';
$lang['backups_create_preset']									= 'Ajouter un paramétrage';
$lang['backups_run_preset']										= 'Lancer le paramétrage maintenant';
$lang['backups_edit_preset_page']								= 'Edition du paramétrage \'%s\'';
$lang['backups_edit_preset']									= 'Editer le paramétrage';
$lang['backups_delete_preset']									= 'Supprimer le paramétrage';

// Preset Column Names
$lang['backups_preset_name']									= 'Nom';
$lang['backups_type']											= 'Type';
$lang['backups_created']										= 'Créé';
$lang['backups_last_run']										= 'Dernier lancement';
$lang['backups_actions']										= 'Actions';
$lang['backups_status']											= 'Statut';
$lang['backups_download']										= 'Télécharger';
$lang['backups_all_tables']										= 'Toutes';

// Warnings / Flashdata
$lang['backups_delete_preset_confirm']							= 'Etes-vous sûr de vouloir supprimer ce paramétrage ? Ceci causera un arrêt des routines de sauvegarde (cron). Le compte associé à ce paramétrage ne sera pas supprimé.';
$lang['backups_preset_created']									= 'Le paramétrage a bien été créé.';
$lang['backups_preset_updated']									= 'Le paramétrage a bien été mis à jour.';
$lang['backups_preset_not_found']								= 'Désolé, ce paramétrage n\'existe pas.';
$lang['backups_preset_deleted']									= 'Le paramétrage a été supprimé.';
$lang['backups_no_errors']										= 'Aucune erreur n\'a été relevée lors du dernier lancement.';
$lang['backups_passed']											= 'La sauvegarde a bien été effectuée.';
$lang['backups_failed']											= 'La sauvegarde n\'a pas pu être effectuée. Merci de consulter les erreurs ci-dessous.';

// Preset Form Fields
$lang['backups_name']											= 'Nom du paramétrage';
$lang['backups_name_placeholder']								= 'Comment doit-il être intitulé ?';
$lang['backups_description']									= 'Description';
$lang['backups_description_placeholder']						= 'Quel est le but de ce paramétrage ?';
$lang['backups_tables']											= 'Tables';
$lang['backups_tables_all']										= 'Toutes les tables';
$lang['backups_tables_specific']								= 'Tables spécifiques';
$lang['backups_tables_prefix']									= 'Tables avec préfixes';
$lang['backups_tables_prefix_example']							= 'par ex. "default_" ou "site1_, site2_, site_3"';
$lang['backups_tables_prefix_placeholder']						= 'Préfixe';
$lang['backups_tables_prefix_with']								= 'Préfixé par : ';
$lang['backups_tables_select_all']								= 'Tout sélectionner';
$lang['backups_tables_select_none']								= 'Aucune';
$lang['backups_backup_method']									= 'Méthode de sauvegarde';
$lang['backups_add_account']									= 'Ajouter';
$lang['backups_backup_method_add_account']						= 'Ajouter le compte %s';
$lang['backups_public_url']										= 'URL publique';

// Shortcuts		
$lang['backups_shortcuts']										= 'Raccourcis';
$lang['backups_add_preset']										= 'Ajouter un paramétrage';
$lang['backups_list_presets']									= 'Paramétrages';
$lang['backups_list_accounts']									= 'Comptes';
$lang['backups_add_account']									= 'Ajouter un compte';
$lang['backups_take_snapshot']									= 'Télécharger un instantané !';

// Preset Overview
$lang['backups_date_friendly']									= 'j M Y \\à\ H:i';
$lang['backups_never_run']										= 'Jamais lancé';
$lang['backups_all']											= 'Toutes';		
$lang['backups_view_preset']									= 'Détails du paramétrage';
$lang['backups_account_details']								= 'Détails du compte';
		
// Cron Jobs
$lang['backups_cron_jobs']										= 'Routine Cron';
$lang['backups_cron_using_curl']								= 'En utilisant cURL';
$lang['backups_cron_using_wget']								= 'En utilisant Wget';
$lang['backups_cron_builder']									= 'Constructeur de routine Cron';
$lang['backups_cron_every']										= 'Chaque';
$lang['backups_cron_minute']									= 'Minute';
$lang['backups_cron_minute_every']								= 'Chaque Minute';
$lang['backups_cron_hour']										= 'Heure';
$lang['backups_cron_hour_every']								= 'Chaque heure';
$lang['backups_cron_day']										= 'Jour';
$lang['backups_cron_day_every']									= 'Chaque jour';
$lang['backups_cron_month']										= 'Mois';
$lang['backups_cron_month_every']								= 'Chaque mois';
$lang['backups_cron_weekday']									= 'Jours de la semaine';
$lang['backups_cron_weekday_every']								= 'Chaque jour de la semaine';
$lang['backups_cron_crontab_edit']								= 'Vous pouvez par exemple modifier vos routines Cron avec la commande suivante : %s . <br />Un guide complet des routines Cron est disponible <a href="%s">ici</a>';

// Accounts
$lang['backups_no_accounts']									= 'Il n\y a pas de compte.';
$lang['backups_accounts_none']									= 'Il n\'existe aucun paramétrage utilisant ce compte.';
$lang['backups_accounts_type']									= 'Type de compte';
$lang['backups_accounts_info']									= 'Info';
$lang['backups_accounts_presets_using']							= 'Paramétrages utilisant ce compte';
$lang['backups_accounts_no_account']							= 'Désolé, ce compte est introuvable.';
$lang['backups_edit_account']									= 'Editer le compte';
$lang['backups_account_updated']								= 'Les informations du compte ont été mis à jour';
$lang['backups_switch_accounts']								= 'Changer de comptes';
$lang['backups_switch_account_info']							= 'Les informations du compte ont été mis à jour';
$lang['backups_account_deleted']								= 'Le compte a été supprimé.';
$lang['backups_account_not_found']								= 'Le compte spécifié n\'a pas pu être trouvé.';
$lang['backups_no_accounts_to_change']							= 'Désolé, des paramétrages sont liés à ce compte. Merci de créer un autre compte sur lequel les basculer.';
$lang['backups_presets_dependent_on_account']					= 'Des paramétrages sont liés à ce compte. Merci de sélectionner ci-dessous le compte sur lequel les basculer.';
$lang['backups_account_created']								= 'Le compte a bien été créé';
$lang['backups_delete_account_confirm']							= 'Etes-vous sûr de vouloir supprimer ce compte ? Les routines Cron des paramétrages utilisant ce compte ne fonctionneront plus.';

// No Backup Method (NULL)
$lang['backups_none_name']										= 'N/A';
$lang['backups_none_account_name']								= 'Pas de compte';
$lang['backups_no_account_linked']								= 'Il n\y a aucun compte lié à ce paramétrage';
$lang['backups_no_account_linked_cron']							= 'Vous ne pouvez pas lancer une routine Cron sur un paramétrage qui n\'est lié à aucun compte.';