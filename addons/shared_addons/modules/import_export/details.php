<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Import_export extends Module {

	public $version = '1.1.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Import/Export',
				'fr' => 'Import/Export'
			),
			'description' => array(
				'en' => 'Import and export your PyroCMS site(s).',
				'fr' => 'Importer et exporter vos sites PyroCMS.'
			),
			'frontend'	=> true,
			'backend'	=> true,
			//'skip_xss'	=> true,
			'menu'		=> 'utilities',
			'sections' => array(
			    'import' => array(
				    'name' => 'ie:import',
				    'uri' => 'admin/import_export',
				    /*
				    'shortcuts' => array(
						array(
					 	   'name' => 'ie:create',
						    'uri' => 'admin/import_export/create',
						    'class' => 'add'
						),
					),
					*/
				),
				'export' => array(
				    'name' => 'ie:export',
				    'uri' => 'admin/import_export/export',
				    /*
				    'shortcuts' => array(
						array(
						    'name' => 'ie:create',
						    'uri' => 'admin/import_export/export/create',
						    'class' => 'add'
						),
				    ),
				    */
			    ),
		    ),
		);
	}

	public function install()
	{
		/*
		$this->dbforge->drop_table('sample');
		$this->db->delete('settings', array('module' => 'sample'));

		$sample = array(
                        'id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
						'name' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'slug' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										)
						);

		$sample_setting = array(
			'slug' => 'sample_setting',
			'title' => 'Sample Setting',
			'description' => 'A Yes or No option for the Sample module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'sample'
		);

		$this->dbforge->add_field($sample);
		$this->dbforge->add_key('id', TRUE);

		if($this->dbforge->create_table('sample') AND
		   $this->db->insert('settings', $sample_setting) AND
		   is_dir($this->upload_path.'sample') OR @mkdir($this->upload_path.'sample',0777,TRUE))
		{
			return TRUE;
		}
		*/
		return is_dir($this->upload_path.'import_export') or @mkdir($this->upload_path.'import_export',0777,TRUE);
	}

	public function uninstall()
	{
		/*
		$this->dbforge->drop_table('sample');
		$this->db->delete('settings', array('module' => 'sample'));
		{
			return TRUE;
		}
		*/
		@rmdir($this->upload_path.'import_export');
		return true;
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return true;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
