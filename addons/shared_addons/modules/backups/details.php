<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_Backups extends Module {
	
	public $version = '1.6';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'PyroBackup',
				'fr' => 'PyroBackup',
				'it' => 'PyroBackup',
				'nl' => 'PyroBackup'
			),

			'description' => array(
				'en' => 'Backup all your important data to Amazon S3, Dropbox, Email or by direct download.',
				'fr' => 'Sauvegarder toutes vos données sur Amazon S3, Dropbox, via Email ou par téléchargement direct.',
				'it' => 'Esegui il Backup di tutti i dati importanti su Amazon S3, Dropbox, Email o tramite download diretto',
				'nl' => 'Maak back-up van al je belangrijke data naar Amazon S3, Dropbox, E-mail of download het gelijk.'
				
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => 'content',
			'sections' => array(
			    'presets' => array(
				    'name' => 'backups_list_presets',
				    'uri' => 'admin/backups'
				),

				'add_preset' => array(
					 	   'name' => 'backups_add_preset',
						    'uri' => 'admin/backups/preset',
						    'class' => 'add'
				),
				
				'accounts' => array(
				    'name' => 'backups_list_accounts',
				    'uri' => 'admin/backups/accounts',
			    ),

			    'add_account' => array(
						    'name' => 'backups_add_account',
						    'uri' => 'admin/backups/accounts_form',
						    'class' => 'add'
				),

			    'snapshot' => array(
				    'name' => 'backups_take_snapshot',
				    'uri' => 'admin/backups/snapshot'
				),
		    )
		);
	}
	
	public function install()
	{
		$this->dbforge->drop_table('backup_presets');
		$this->dbforge->drop_table('backup_accounts');

		$accounts = "CREATE TABLE ".$this->db->dbprefix('backup_accounts')." (
						  account_id int(11) NOT NULL AUTO_INCREMENT,
						  account_type varchar(100) NOT NULL,
						  username varchar(255) NOT NULL,
						  password varchar(255) DEFAULT NULL,
						  bucket varchar(150) DEFAULT NULL,
						  path varchar(255) DEFAULT NULL,
						  PRIMARY KEY (account_id),
						  UNIQUE KEY account_id (account_id)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
		
		$presets = "CREATE TABLE ".$this->db->dbprefix('backup_presets')." (
						  preset_id int(11) NOT NULL AUTO_INCREMENT,
						  name varchar(150) DEFAULT NULL,
						  description tinytext,
						  account_id int(11) DEFAULT NULL,
						  created_on datetime NOT NULL,
						  last_run datetime DEFAULT NULL,
						  tables text NULL,
						  public_key varchar(20) NOT NULL,
						  last_run_error varchar(200) DEFAULT NULL,
						  PRIMARY KEY (preset_id),
						  UNIQUE KEY preset_id (preset_id),
						  KEY account_id_idxfk (account_id)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
		
		if($this->db->query($accounts) && $this->db->query($presets))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('backup_presets');
		$this->dbforge->drop_table('backup_accounts');
		return TRUE;
	}

	public function upgrade($old_version)
	{
		$fields = array('account_type' => array(
							'name' => 'account_type',
							'type' => 'varchar(100) NOT NULL',
				),

		);
		$this->dbforge->modify_column('backup_accounts', $fields);
		
		return TRUE;
	}

	public function help()
	{
		return TRUE;
	}

}
