jQuery(function($){
function check_if_preset_has_tables(){
	if(jQuery('#tables_select').val() == "specific")
	{
		jQuery('.tables_prefix').fadeOut();	
		jQuery('.tables_list').fadeIn();
	} 
	else if (jQuery('#tables_select').val() == "prefix")
	{
		jQuery('.tables_list').fadeOut();	
		jQuery('.tables_prefix').fadeIn();
	}
	else
	{
		jQuery('.tables_list, #tables_flag, .tables_prefix').fadeOut();	
	}
	
}

function change_backup_type_fields(){
	var backup_method = jQuery('#backup_method').val();
	jQuery('.'+backup_method).slideDown();
	jQuery('.backup_choice').not('.'+backup_method).slideUp();
}

	check_if_preset_has_tables();
	$('select#tables_select').change(function (){
		check_if_preset_has_tables();
	});
	
	change_backup_type_fields();
	$('#backup_method').change(function (){
		change_backup_type_fields();
	});
	
	$('a.tables_select_all').click(function() {
		$('.tables_checkbox').attr('checked', 'checked');
	});
	
	$('a.tables_select_none').click(function() {
		$('.tables_checkbox').removeAttr('checked');
	});
	
	$('.cron').change(function() {
		var element_id = $(this).attr('id');
		
		if($(this).val() == 'every' || $(this).val()[0] == 'every')
		{
			$('span.' + element_id).html('* ');
		}
		else 
		{
			$('span.' + element_id).html($(this).val().toString());
		}
		
	});

	$('.account_row').click(function() {
		var account_id = $(this).attr('id');
		$('.presets_' + account_id).fadeToggle('slow');
	});
	
});