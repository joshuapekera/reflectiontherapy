<section class="title">
	<h4><?php echo lang('ie:import'); ?></h4>
</section>

<section class="item">

	<section class="content">

		<?php echo form_open_multipart($this->uri->uri_string().'/upload', 'class="uplaod"'); ?>
			
			<div class="form_inputs">
		
				<ul>
					<li>
		            	<p><?php echo lang('ie:import_inst'); ?></p>
						<div class="input"><input type="file" name="userfile" size="20" /></div>
					</li>
					<li>
		            	<p><?php echo lang('ie:import_users_help'); ?></p>
						<div class="input"><label><?php echo lang('ie:import_users'); ?></label><?php echo form_checkbox('import_users','accept'); ?></div>
					</li>
				</ul>
			
			</div>
			
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('import'))); ?>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('wp_import'))); ?>
			</div>

		<?php echo form_close(); ?>

	</section>

</section>