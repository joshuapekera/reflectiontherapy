<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Fields
$lang['backups_email_name']											= 'E-mail';
$lang['backups_email_address']										= 'E-mail adres';
$lang['backups_email_address_placeholder']							= 'Waar de back-ups worden geleverd';

// Delivery message
$lang['backups_email_delivery_message']								= 'Beste website beheerder,<p></p>
als bijlage vindt u uw laatste back-up.
<p></p>
<strong>Datum gestart</strong>: %s
<br /><strong>Naam</strong>: %s
<br /><strong>Beschrijving</strong>: %s
<br /><strong>Tables</strong>: %s
<p></p>
Voor het bekijken of wijzigen van de vooraf ingestelde instellingen, '.anchor('%s', 'klik hier').'.
<p></p>Met vriendelijke groet.
<p></p>';

// Error messages
$lang['backups_email_errors_send_fail']							= 'Er is een fout opgetreden bij het verzenden van de e-mail.';
