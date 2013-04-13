<section class="title">
	<h4><?php echo lang('backups_presets_title'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php if(empty($presets)) : ?>
		<div class="no_data"><?php echo lang('backups_no_presets_defined'); ?>
		</div>	
		<?php else : ?>
		<table cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th style="width:25%;"><?php echo lang('backups_preset_name'); ?></th>
					<th style="width:10%;"><?php echo lang('backups_type'); ?></th>
					<th style="width:20%;"><?php echo lang('backups_created'); ?></th>
					<th style="width:15%;"><?php echo lang('backups_last_run'); ?></th>
					<th style="width:35%;"><?php echo lang('backups_actions'); ?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php foreach($presets as $row): ?>
					<tr<?php echo ($row->has_error) ? ' style="background:#FFEBA8;"' : ''; ?>>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->account_type_friendly; ?></td>
						<td><?php echo $row->created_on_friendly ?></td>
						<td><?php echo $row->last_run_friendly; ?></td>
						<td><?php echo anchor('admin/backups/snapshot/'.$row->preset_id, lang('backups_download'), 'class="button"');?>
						<?php if($row->account_id != NULL): ?>
						 <?php echo anchor('admin/backups/run/'.$row->preset_id, lang('backups_run'), 'class="button"');?> <?php endif; ?><?php echo anchor('admin/backups/view/'.$row->preset_id, lang('backups_view'), 'class="button"');?>
						<?php echo anchor('admin/backups/preset/'.$row->preset_id, lang('backups_edit'), 'class="button"');?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
</section>