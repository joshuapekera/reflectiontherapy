<section class="title">
	<h4><?php if($this->uri->segment(4) != false): ?><?php printf(lang('backups_edit_preset_page'), $form_data['name']); ?><?php else: ?><?php echo lang('backups_create_preset'); ?><?php endif; ?>
	</h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open('', 'class="crud"'); ?>
		<div class="form_inputs">
		<fieldset>
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="name"><?php echo lang('backups_name'); ?><span> *</span></label>
					<div class="input">
						<?php echo form_input('name', $form_data['name'], 'maxlength="70" placeholder="'.lang('backups_name_placeholder').'"'); ?>
					</div>
					
				</li>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="description"><?php echo lang('backups_description'); ?></label>
					<div class="input">
						<?php echo form_textarea('description', $form_data['description'], 'placeholder="'.lang('backups_description_placeholder').'"'); ?>
					</div>
				</li>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="tables_select" style="height:100%;"><?php echo lang('backups_tables'); ?><span> *</span></label>
					<div class="input">
						<?php echo form_dropdown('tables_select', array('all' => lang('backups_tables_all'), 'specific' => lang('backups_tables_specific'), 'prefix' => lang('backups_tables_prefix')), $form_data['tables_select'], 'id="tables_select"'); ?>
					<div class="tables_list" style="margin-top: 10px;">
						<?php foreach($form_data['tables_selection'] as $table) : ?>
						<?php echo form_checkbox('tables_selection[]', $table, in_array($table, $form_data['tables_picked']), 'class="tables_checkbox" style="margin-right:5px;"').$table.'<br />'; ?>
						<?php endforeach; ?>
						<a class="tables_select_all" style="cursor: pointer;"><?php echo lang('backups_tables_select_all'); ?></a> | <a class="tables_select_none" style="cursor: pointer;"><?php echo lang('backups_tables_select_none'); ?></a>
					</div>

					<div class="tables_prefix" style="margin-top: 10px;">
						<?php echo form_input('prefix', $form_data['prefix'], 'placeholder="'.lang('backups_tables_prefix_placeholder').'"'); ?> <?php echo lang('backups_tables_prefix_example'); ?>
					</div>

					</div>
				</li>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="method"><?php echo lang('backups_backup_method'); ?><span> *</span></label>
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
