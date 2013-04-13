<div class="one_full">
	<section class="title">
		<h4><?php echo lang('backups_view_preset'); ?></h4>
	</section>
	<section class="item">
		<div class="content">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_preset_name'); ?></td>
					<td><?php echo $preset->name; ?></td>
				</tr>
				
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_description'); ?></td>
					<td><?php echo $preset->description; ?></td>
				</tr>
				
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_created'); ?></td>
					<td><?php echo $preset->created_on_friendly; ?></td>
				</tr>
				
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_last_run'); ?></td>
					<td><?php echo $preset->last_run_friendly; ?></td>
				</tr>
				
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_tables'); ?></td>
					<td><?php echo $preset->tables_friendly; ?></td>
				</tr>
				
				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_status'); ?></td>
					<td><?php echo ($preset->has_error) ? image('warning.png', 'backups').' '.$preset->last_run_error_message : lang('backups_no_errors'); ?></td>
				</tr>

				<tr>
					<td style="width:10%; font-weight: bold;"><?php echo lang('backups_public_url'); ?></td>
					<td><?php echo anchor($preset->url, $preset->url); ?></td>
				</tr>

			</table>
			<p> </p>
			<?php if($preset->account_id != NULL): ?>
				<?php echo anchor('admin/backups/run/'.$preset->preset_id, lang('backups_run_preset'), 'class="btn green" rel="1"'); ?>
				<?php endif; ?>
				<?php echo anchor('admin/backups/snapshot/'.$preset->preset_id, lang('backups_download'), 'class="btn green"'); ?>
				<?php echo anchor('admin/backups/preset/'.$preset->preset_id, lang('backups_edit_preset'), 'class="btn orange"'); ?>
				
				<?php echo anchor('admin/backups/delete/'.$preset->preset_id, lang('backups_delete_preset'), 'class="confirm btn red" title="'.lang('backups_delete_preset_confirm').'"'); ?>

			</div>
	</section>
</div>

<div class="one_full">
	<section class="title">
		<h4><?php echo lang('backups_account_details'); ?></h4>
	</section>
	<section class="item">
		<div class="content">
			<?php if($preset->account_id != NULL): ?>
				<table cellpadding="0" cellspacing="0">
					<?php echo $preset_account; ?>
				</table>
				<p> </p>
					<?php echo anchor('admin/backups/accounts_form/'.$preset->account_id, 'Edit Account', 'class="btn orange"'); ?>
					
					<?php echo anchor('admin/backups/delete_account/'.$preset->preset_id, 'Delete', 'class="confirm btn red" title="'.lang('backups_delete_account_confirm').'"'); ?>
					
			<?php else: ?>
				<div class="no_data"><?php echo lang('backups_no_account_linked'); ?></div>	
			<?php endif; ?>
		</div>
	</section>
</div>


<div class="one_full">
<section class="title">
	<h4><?php echo lang('backups_cron_jobs'); ?></h4>
</section>
<section class="item">
	<div class="content">
	<p>
		<?php if($preset->account_id != NULL): ?>
			<strong>Cron Job Builder</strong>
				
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td style="vertical-align:top;">
							<strong><?php echo lang('backups_cron_minute'); ?></strong>:<br />
							<select style="padding: 2px 3px; height: 125px;" multiple="true" class="cron" id="cron_minute">
							
									<option value="every"><?php echo lang('backups_cron_minute_every'); ?></option>
								<?php for($i=0; $i<60; $i++): ?>
									<option value="<?php echo $i; ?>"><?php echo ($i<10) ? '0'.$i : $i; ?></option>
								<?php endfor; ?>
							</select>
						</td>
						
						<td style="vertical-align:top;">
							<strong><?php echo lang('backups_cron_hour'); ?>:</strong><br />
							<select style="padding: 2px 3px" multiple="true" class="cron" id="cron_hour">
								<option value="every"><?php echo lang('backups_cron_hour_every'); ?></option>
								<?php for($i=0; $i<24; $i++): ?>
									<option value="<?php echo $i; ?>"><?php echo ($i<10) ? '0'.$i : $i; ?></option>
								<?php endfor; ?>
							</select>
						</td>
						
						<td style="vertical-align:top;">
							<strong><?php echo lang('backups_cron_day'); ?>:</strong><br />
							<select style="padding: 2px 3px; height: 125px;" multiple="true" class="cron" id="cron_day">
								<option value="every"><?php echo lang('backups_cron_day_every'); ?></option>
								<?php for($i=1; $i<32; $i++): ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php endfor; ?>
							</select>
						</td>
						
						
					</tr>

					<tr>
						<td style="vertical-align:top;">
							<strong><?php echo lang('backups_cron_month'); ?>:</strong><br />
							<select style="padding: 2px 3px; height: 125px;" multiple="true" class="cron" id="cron_month">
								<option value="every"><?php echo lang('backups_cron_month_every'); ?></option>
								<?php for($i=1; $i<13; $i++): ?>
									<option value="<?php echo $i; ?>"><?php echo date("F", mktime(0, 0, 0, $i)); ?></option>
								<?php endfor; ?>
							</select>
						</td>
						
						<td style="vertical-align:top;">
							<strong><?php echo lang('backups_cron_weekday'); ?>:</strong><br />
							<select style="padding: 2px 3px; height: 125px;" multiple="true" class="cron" id="cron_weekday">
								<option value="every"><?php echo lang('backups_cron_weekday_every'); ?></option>
								<?php 
								$first_monday = strtotime('first sunday this month');
								for($i=0; $i<7; $i++): ?>
									<option value="<?php echo $i; ?>"><?php echo date("l", $first_monday + (86400 * $i)); ?></option>
								<?php endfor; ?>
							</select>
						</td>
						<td></td>
					</tr>
				</table>
				
			</p>
			
			<p>
			<strong><?php echo lang('backups_cron_using_curl'); ?></strong><br />
			<span style="font-family:Courier">
				<span class="cron_minute">* </span> 
				<span class="cron_hour">* </span> 
				<span class="cron_day">* </span> 
				<span class="cron_month">* </span> 
				<span class="cron_weekday">* </span> 
				curl --silent --compressed "<?php echo $preset->url; ?>"</span>
			<br /><br />
			
			<strong><?php echo lang('backups_cron_using_wget'); ?></strong><br />
			<span style="font-family:Courier">
				<span class="cron_minute">* </span> 
				<span class="cron_hour">* </span> 
				<span class="cron_day">* </span> 
				<span class="cron_month">* </span> 
				<span class="cron_weekday">* </span> 
				wget "<?php echo $preset->url; ?>" > /dev/null</span>
			<br/><br />
			<span class="text-small1"><?php printf(lang('backups_cron_crontab_edit'), 'crontab -e', 'http://unixgeeks.org/security/newbie/unix/cron-1.html'); ?></span>		
		
		<?php else: ?>
		<div class="no_data"><?php echo lang('backups_no_account_linked_cron');?>
		</div>	
		<?php endif; ?>		
		</p>
	</div>
</section>
</div>