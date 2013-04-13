<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Fields
$lang['backups_email_name']											= 'Email';
$lang['backups_email_address']										= 'Adresse électronique';
$lang['backups_email_address_placeholder']							= 'A laquelle les sauvegardes seront envoyées';

// Delivery message
$lang['backups_email_delivery_message']								= 'Cher administrateur de site,<p></p>
Veuillez trouver ci-joint la dernière sauvegarde réalisée.
<p></p>
<strong>Date de réalisation </strong>: %s
<br /><strong>Nom </strong>: %s
<br /><strong>Description</strong>: %s
<br /><strong>Tables </strong>: %s
<p></p>
Pour visualiser ou modifier ce paramétrage, merci de '.anchor('%s', 'cliquer ici').'.
<p></p>Cordialement.
<p></p>';

// Error messages
$lang['backups_email_errors_send_fail']							= 'Une erreur a eu lieu pendant l\'envoi du message électronique.';
