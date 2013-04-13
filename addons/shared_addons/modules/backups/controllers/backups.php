<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backups extends Public_Controller {
	
	/**
	 * Run
	 * Provides a public interface for Cron Jobs
	 * @param int $preset_id Preset ID
	 * @param string $key The Preset's Public Key, to stop backups being run by anyone
	 **/
	public function run($preset_id, $key)
	{
		$this->load->model('presets_m');
		$this->load->model('backup_m');
		$preset = $this->presets_m->get_preset($preset_id);
		if($preset == NULL || $preset->public_key != $key)
			show_404();
			
		return $this->backup_m->backup($preset_id);
	}
}