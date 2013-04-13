<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Fields
$lang['backups_email_name']											= 'Email';
$lang['backups_email_address']										= 'Indirizzo Email';
$lang['backups_email_address_placeholder']							= 'Dove saranno spediti i Backup';

// Delivery message
$lang['backups_email_delivery_message']								= 'Caro Amministratore,<p></p>
In allegato puoi trovare l\'ultimo backup effettuato.
<p></p>
<strong>Effettuato il</strong>: %s
<br /><strong>Nome</strong>: %s
<br /><strong>Descrizione</strong>: %s
<br /><strong>Tabelle</strong>: %s
<p></p>
Per vedere o modificare questo Preset, puoi '.anchor('%s', 'Cliccare qui').'.
<p></p>Cordialmente.
<p></p>';

// Error messages
$lang['backups_email_errors_send_fail']							= 'Si è verificato un errore nell\'inviare l\'email.';
