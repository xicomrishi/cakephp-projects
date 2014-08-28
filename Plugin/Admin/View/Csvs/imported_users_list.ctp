<?php echo $this->Form->input('users_imported', array(
																	'type'=>'select', 'class' => 'multipleUser multiple_imported_users',
																	'style' => "width: 450px;", 'div'=>false,
																	'options'=>$imported_emails,																	
																	'multiple'=>'checkbox',
																	'title' => 'imported',
																	'label' => false
																)
													);
								
								?>
								

<script type="text/javascript">
	$(document).ready(function(e){
		$('.multiple_imported_users').bind('click',update_is_checked);
	});
	
	
	function update_is_checked()
	{
		var flg = 0;
		$('input:checkbox').each(function(e){
			if($(this).is(':checked'))
			{
				flg = 1;
				return;
			}
		});
		
		if(flg == 1)
		{
			$('#is_checked').val(1);
		}else{
			$('#is_checked').val(0);
		}
		//console.log(123);
	}
</script>