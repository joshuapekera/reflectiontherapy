<section class="title">
	<h4><?php echo lang('backups_list_accounts'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php if(empty($accounts)) : ?>
				<div class="no_data"><?php echo lang('backups_no_accounts'); ?>
				</div>	
		<?php else : ?>
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th style="width:;"><?php echo lang('backups_accounts_type'); ?></th>
						<th style="width:;"><?php echo lang('backups_accounts_info'); ?></th>
						<th style="width:15%;"><?php echo lang('backups_actions'); ?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach($accounts as $row): ?>
					<tr style="cursor:pointer;" class="account_row" id="<?php echo $row->account_id; ?>">
						<td><?php echo $row->account_type_friendly; ?></td>
						<td><?php echo $row->info; ?></td>
						
						<td><?php echo anchor('admin/backups/accounts_form/'.$row->account_id, lang('backups_edit'), 'class="button"');?> <?php echo anchor('admin/backups/delete_account/'.$row->account_id, lang('backups_delete'), 'class="confirm button" title="'.lang('backups_delete_account_confirm').'"');?></td>
					</tr>

					<tr style="background:#BABABA; color:#fff; display:none; border-top:3px solid #404040; border-bottom: 1px solid #3D3D3D;" class="presets_<?php echo $row->account_id; ?>">
						<td colspan="3">
							<?php if($row->presets == false): ?>
								<i><?php echo lang('backups_accounts_none'); ?></i>
							<?php else: ?>
								<strong><?php echo lang('backups_accounts_presets_using'); ?></strong><br />
								<?php foreach($row->presets as $preset): ?>
									- <?php echo anchor('admin/backups/view/'.$preset->preset_id, $preset->name, 'style="color:#fff"'); ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</td>
						
					</tr>
				<?php endforeach; ?>
					
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</section>
