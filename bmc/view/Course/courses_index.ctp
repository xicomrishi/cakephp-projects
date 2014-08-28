<div class="wrapper">   
  <section id="body_container">
  <?php 
  if($this->Session->read('User.type')=='Admin')
  	echo $this->element('menu_admin');
  else		
    echo $this->element('menu_trainer'); ?>
  	
<section class="container">
    
<div class="tab_detail">
<?php if($this->Session->read('User.type')!='Admin'){ ?>
<div class="invite"><span><?php echo __('Create Group'); ?></span><a href="javascript://" onClick="open_lightbox('/course/add_course/<?php echo $trainer_id; ?>',300);"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
<?php } ?>

        <h3 class="title"><?php echo __('Groups'); ?></h3>
        <div class="inner">
              <form id="searchCourseForm" name="searchCourseForm" action="<?php echo $this->webroot; ?>course/index/<?php echo $trainer_id; ?>" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                  <?php if($this->Session->read('User.type')!='Admin'){ ?>
                    <th class="first"><input class="checkbox toggle checkall" type="checkbox"></th>
                  <?php } ?>  
                    <th><?php echo __('Group ID'); //echo $this->Paginator->sort('course_id');?></th>
                    <th><?php echo __('Group Name'); ?></th>
                    <?php if(isset($is_admin)){ ?>
                    <th><?php echo __('Trainer'); ?></th>
                    <?php  } ?>
                    <th><?php echo __('Group Date'); ?></th>
                    <th><?php echo __('Assessment Link'); ?></th>
                    <th><?php echo __('No. of Participants'); ?></th>
                    <th  class="center"><?php echo __('Response Status'); ?></th>
                    <th  class="center"><?php echo __('Report'); ?></th>
                    <th class="last"><?php echo __('Action'); ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
				 
				  $i=1;
				  foreach($courses as $course){ ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="train_<?php echo $i; ?>">
                   <?php if($this->Session->read('User.type')!='Admin'){ ?>
                    <td><input class="course_check checkbox" name="cbox[]" onclick="check(this)" value="<?php echo $course['Course']['id']; ?>" type="checkbox"></td>
                    <?php } ?>
                    <td><?php echo $course['Course']['course_id']; ?></td>
                    <td><?php echo $course['Course']['course_name']; ?></td>
                     <?php if(isset($is_admin)){ ?>
                    <td><?php echo $course['Course']['Trainer']; ?></td>
                    <?php  } ?>
                    <td><?php echo show_formatted_date($course['Course']['start_date']).' - '.show_formatted_date($course['Course']['end_date']); ?></td>
                    <td><?php echo SITE_URL.'/Assessment/'.$course['Course']['course_id']; ?></td>
                    <td><?php echo $course['Course']['participant']; ?></td>
                    <td align="center"><?php echo $course['Course']['response_status'].'%<br>Complete'; ?></td>
                    <td align="center"><?php if($course['Course']['response_status']!=0){ ?><a href="<?php echo $this->webroot; ?>reports/project_management_trainer_report/<?php echo $course['Course']['course_id']; ?>" target="_blank"><?php echo __('Group'); ?><br><?php echo __('Report'); ?></a><?php }else{ echo __('N/A'); } ?></td>
                    <td class="last"><a href="javascript://" onclick="open_lightbox('/course/accountability/<?php echo $course['Course']['id']; ?>',805);"><?php echo __('Participant List'); ?></a> <?php if($this->Session->read('User.type')!='Admin'){ ?> | <a href="javascript://" onclick="open_lightbox('/course/edit_course/<?php echo $course['Course']['id']; ?>',300);"><?php echo __('Edit'); ?></a> | <a href="javascript://" onclick="delete_course('<?php echo $course['Course']['id']; ?>','<?php echo $trainer_id; ?>');"><?php echo __('Delete'); ?></a><?php } ?></td>
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                <div class="actions-bar wat-cf">
                <?php if(!empty($courses)&&$this->Session->read('User.type')!='Admin'){ ?>
                  <div class="actions">
                    <button class="button" type="submit" onclick="delete_course(0,'<?php echo $trainer_id; ?>');">
                      <img src="<?php echo $this->webroot; ?>img/cross.png" alt="Delete"> <?php echo __('Delete'); ?>
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
 		</div>
    
    </section>
  </section>
</div>            
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
        
