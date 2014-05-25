
<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <div class="tab_detail"> 
   <div class="invite"><span>Add Question Set</span><a href="<?php echo $this->webroot; ?>questions/add_cms_questions"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
     <h3 class="title"><?php echo __('Question Set List'); ?></h3>
        <div class="inner">
              <form id="cmsForm" name="cmsForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first"><?php echo __('S.No.'); ?></th>
                    <th><?php echo __('Role'); ?></th>
                    <th><?php echo __('Question Language'); ?></th>
                    
                    <th><?php echo __('Action'); ?></th>                   
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
				  
				  $i=1;
				  foreach($ques_set as $qset){ ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="qset_<?php echo $i; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php if($qset['Question']['role_id']=='3') echo 'Project Manager'; else if($qset['Question']['role_id']=='4') echo 'Team Member'; else if($qset['Question']['role_id']=='5') echo 'Manager of Project Managers'; ?></td> 
                    <td><?php echo $qset['Language']['name']; ?></td>              
                    <td><a href="<?php echo $this->webroot; ?>questions/edit_cms_questions/<?php echo $qset['Language']['id']; ?>/<?php echo $qset['Question']['role_id']; ?>" class="action">Edit</a> 
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                
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