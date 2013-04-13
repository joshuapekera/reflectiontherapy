<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Backup Method Fields
$lang['backups_email_name']											= 'Email';
$lang['backups_email_address']										= 'Email Address';
$lang['backups_email_address_placeholder']							= 'Where backups will be delivered';

// Delivery message
$lang['backups_email_delivery_message']								= 'Dear Site Administrator,<p></p>
Please find attached your latest backup.
<p></p>
<strong>Date Run</strong>: %s
<br /><strong>Name</strong>: %s
<br /><strong>Description</strong>: %s
<br /><strong>Tables</strong>: %s
<p></p>
To view or ammend this Preset, please '.anchor('%s', 'click here').'.
<p></p>Best regards.
<p></p>';

// Error messages
$lang['backups_email_errors_send_fail']							= 'There was an error in sending the email.';
