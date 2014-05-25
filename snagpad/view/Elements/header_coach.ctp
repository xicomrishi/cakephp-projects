<section class="top_section">
        <ul class="left_link">
          
          <li><?php echo $this->Html->link('Clients','/coach/index');?></li>
                   <?php if($this->Session->read('Coach.Coach.agency_id')!=0){?>
                  <li><?php echo $this->Html->link('JOB BULLETIN',array('controller'=>'cards','action'=>'job_bulletin'));?></li>
         <?php }?>

          <li><?php echo $this->Html->link('Coach CARDS','/Coachcards/index');?></li>
          <li><?php echo $this->Html->link('Find jobs','/jobsearch/index');?></li>
        </ul>
        
        <ul class="right_link"> 
          <li><a href="<?php echo SITE_URL."/message/index";?>"><span>MESSAGES</span><small class="message_counter"><?php echo $message_count;?></small></a></li>
          <li class="submenu"><a href="#" id="user_name"><?php echo $this->Session->read('Coach.Coach.name');?></a>
          <ul class="drop_down drop_1">
          <li><?php echo $this->Html->link('SETTINGS',array('controller'=>'coach','action'=>'settings'),array('div'=>false));?></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details" style="min-height:100px;"><a href="<?php echo SITE_URL;?>/coach/index"><?php echo $this->Html->image('inner_logo.png',array('alt'=>'','border'=>'0','escape'=>false,'class'=>'inner_logo'));?></a>
       
        <section class="right_header">
          <ul>
            <li><strong><?php echo $this->Html->link('CONTACTS','/contacts/index');?></strong>
              <ul class="space">
                <li><?php echo $this->Html->link($this->Html->image('small_icon1.png', array('alt' => '', 'border' => '0')),array('controller'=>'contacts','action'=>'index',1), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link($this->Html->image('small_icon2.png', array('alt' => '', 'border' => '0')), array('controller'=>'contacts','action'=>'index',2), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link($this->Html->image('small_icon3.png', array('alt' => '', 'border' => '0')),array('controller'=>'contacts','action'=>'export'), array('escape' => false)); ?></li>
              </ul>
            </li>
          </ul>
        </section>
      </section>
<script type="text/javascript">
$(document).ready(function () {
	//get_message_count();
    $(".submenu").hover(
  function () {
     $('ul.drop_down.drop_1').show();
  },
  function () {
     $('ul.drop_down.drop_1').hide();
  }
);
$(".submenu1").hover(
  function () {
     $('ul.drop_down.drop_2').show();
  },
  function () {
     $('ul.drop_down.drop_2').hide();
  }
);

     $(".drop_1 li").hover(
  function () {
	  $('ul.drop_down.drop_1').show();
    // $(this).children("ul").slideDown('medium');
  },
  function () {
	   $('ul.drop_down.drop_1').hide();
   // $(this).children("ul").slideUp('medium');
  }
);
});

function get_message_count()
{
	$.post('<?php echo SITE_URL;?>/message/message_count','',function(data){
			$('.message_counter').html(data);
		});		
}
</script>      