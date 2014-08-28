<?php if(!isset($is_rendered)){ ?>
<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <div class="tab_detail"> 
<?php } ?>    
     
       <div class="invite"><span>Add Trainer</span><a href="javascript://" onClick="open_lightbox('/trainer/add_trainer',985);"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
        <h3 class="title">Trainers</h3>
        <div class="inner">
              <form id="searchTrainerForm" name="searchTrainerForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first"><input class="checkbox toggle checkall" type="checkbox"></th>
                    <th><?php echo 'Trainer ID'; //echo $this->Paginator->sort('trainer_id','Trainer ID');?></th>
                    <th>Name</th>
                    <th>Groups</th>
                    <th  class="center">Added</th>
                    <th class="last">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
				 
				  $i=1;
				  foreach($trainers as $train){ ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="train_<?php echo $i; ?>">
                    <td><input class="trainer_check checkbox" name="cbox[]" onclick="check(this)" value="<?php echo $train['Trainer']['id']; ?>" type="checkbox"></td>
                    <td><?php echo $train['Trainer']['trainer_id']; ?></td>
                    <td><?php echo $train['User']['last_name'].' '.$train['User']['first_name']; ?></td>
                    <td><?php echo $train['Trainer']['courses']; ?></td>
                    <td align="center"><?php echo show_formatted_datetime($train['Trainer']['created']); ?></td>
                    <td class="last"><a href="javascript://" onclick="open_lightbox('/trainer/view_trainer/<?php echo $train['Trainer']['id']; ?>',985);">View</a> | <a href="javascript://" onclick="open_lightbox('/trainer/edit_trainer/<?php echo $train['Trainer']['id']; ?>',985);">Edit</a> | <?php if($train['Trainer']['status']==0){ ?><a href="javascript://" id="anchor_<?php echo $i; ?>" onclick="change_status('<?php echo $train['Trainer']['id']; ?>','<?php echo 'anchor_'.$i; ?>','trainer','1');">Activate</a><?php }else{ ?><a href="javascript://" id="anchor_<?php echo $i; ?>" onclick="change_status('<?php echo $train['Trainer']['id']; ?>','<?php echo 'anchor_'.$i; ?>','trainer','0');">Deactivate</a><?php } ?></td>
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                <div class="actions-bar wat-cf">
                <?php if(!empty($trainers)){ ?>
                  <div class="actions">
                    <button class="button" type="submit" onclick="return delete_trainer();">
                      <img src="<?php echo $this->webroot; ?>img/cross.png" alt="Delete"> Delete
                    </button>
                  </div>
                  <?php } ?>
                 <div class="pagination">
     <?php echo $this->Paginator->prev('<< ' . __('previous', true), null, null, array('class'=>'disabled'));?>
	 <?php echo $this->Paginator->numbers(array('separator'=>'','currentTag'=>'','tag'=>'span','rel'=>'next'));?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', null, null, array('class' => 'disabled'));?>
                  </div>
                </div>
              </form>
            </div>
<?php if(!isset($is_rendered)){ ?>            
    </div>
    
    </section>
  </section>
</div>
<?php } ?>
<script type="text/javascript">

 $(function () {
    $('.checkall').click(function () {
        $(this).parents('section:eq(1)').find(':checkbox').attr('checked', this.checked);
    });
});

function check(el){
	if(el.checked==false)
		$('.checkall').attr('checked',false); 
}
</script> 