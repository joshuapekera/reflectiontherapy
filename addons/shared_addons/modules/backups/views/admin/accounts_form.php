<section class="title">
	<h4><?php if($this->uri->segment(4) != false): ?><?php echo lang('backups_edit_account'); ?><?php else: ?><?php echo lang('backups_add_account'); ?><?php endif; ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open('', 'class="crud" id="variables"'); ?>

			<div class="form_inputs">

			<fieldset>
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="method"><?php echo lang('backups_accounts_type'); ?><span> *</span></label>
						<div class="input">
						<?php
						echo form_dropdown('method', $backup_methods, $form_data['method'], 'id="backup_method"'); ?>
						</div>
					</li>
					<?php echo $backup_fields; ?>
				</ul>
				<div class="buttons float-left padding-top">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
				</div>
			</fieldset>

			</div>
		<?php echo form_close(); ?>
	</div>
</section>