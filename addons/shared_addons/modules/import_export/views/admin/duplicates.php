<section class="title">
	<h4><?php echo lang('ie:import_duplicates'); ?></h4>
</section>

<section class="item">

	<?php echo form_open(base_url().'admin/'.$this->module_details['slug'].'/parse/'.$this->uri->segment(4)); ?>
		
		<p><?php echo lang('ie:duplicates');?></p>      
        <ul>
		<?php
		foreach($items as $key => $item) {
			echo '<li>'.$item.'</li>';
		}
		?>
        </ul>
		<hr />
		<div class="buttons">
            <button type="submit" name="btnAction" value="save" class="btn orange"><span><?php echo lang('ie:try_again');?></span></button>
			<a href="<?php echo base_url().'admin/'.$this->module_details['slug'];?>" class="btn gray cancel"><?php echo lang('ie:cancel');?></a>
		</div>
		
	<?php echo form_close(); ?>

</section>