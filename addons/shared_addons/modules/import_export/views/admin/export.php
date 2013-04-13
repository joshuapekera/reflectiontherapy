<section class="title">
	<h4><?php echo lang('ie:site'); ?></h4>
</section>

<section class="item">

	<section class="content">

		<?php echo form_open(); ?>
		<p><?php echo lang('ie:choose_site'); ?></p>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('export'))); ?>
		<?php echo form_close();?>

	</section>

</section>