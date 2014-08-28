
<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <div class="tab_detail"> 
   <div class="invite"><span>Add Page</span><a href="<?php echo $this->webroot; ?>cms/add_page"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
     <h3 class="title"><?php echo __('CMS'); ?></h3>
        <div class="inner">
              <form id="cmsForm" name="cmsForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first"><?php echo __('S.No.'); ?></th>
                    <th><?php echo __('Page Title'); ?></th>
                    <th><?php echo __('Language'); ?></th>
                    <th><?php echo __('Content'); ?></th>
                    <th><?php echo __('Last Modified'); ?></th>
                    <th><?php echo __('Action'); ?></th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
				 
				  $i=1;
				  foreach($cms as $cont){ ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="cms_<?php echo $i; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $cont['Cms']['page_title']; ?></td>
                    <td><?php echo $cont['Language']['name']; ?></td>
                    <td><?php  $c_pos_len=strlen($cont['Cms']['content']); if($c_pos_len>200){ $c_pos=substr($cont['Cms']['content'], 0, 200); echo $c_pos."...";}else{ echo $cont['Cms']['content'];} ?></td>
                    <td><?php echo $cont['Cms']['modified']; ?></td>
                    <td><a href="<?php echo $this->webroot; ?>cms/edit_cms_page/<?php echo $cont['Cms']['id']; ?>" class="action">Edit</a> <!--| <a href="<?php echo $this->webroot; ?>cms/delete_cms_page/<?php echo $cont['Cms']['id']; ?>" class="action">Delete</a>--></td>
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                <div class="actions-bar wat-cf">
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