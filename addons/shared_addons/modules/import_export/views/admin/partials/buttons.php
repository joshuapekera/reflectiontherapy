<?php if (isset($buttons) && is_array($buttons)): ?>

	<?php foreach ($buttons as $key => $button)
	{
		switch ($button)
		{
			case 'export':
			case 'import':
			case 'wp_import':
				echo '<button type="submit" name="btnAction" value="'.$button.'" class="btn blue">
					<span>'.lang('ie:' . $button).'</span>
				</button>';
		}
	}
	?>

<?php endif; ?>