<section class="top_section">
        <ul class="left_link">
           <li><?php echo $this->Html->link('Coach',array('controller'=>'agency','action'=>'coach'));?></li>         
          <li><?php echo $this->Html->link('Clients','/agency/index');?></li>
          <li><?php echo $this->Html->link('Agency Cards','/cards/index');?></li>
           <li><?php echo $this->Html->link('Employer Cards','/cards/employer');?></li>
        </ul>
        
        <ul class="right_link"> 
          <li class="submenu"><a href="#" id="user_name"><?php echo $this->Session->read('Agency.Agency.name');?></a>
          <ul class="drop_down drop_1">
          <li class=""><?php echo $this->Html->link('SETTINGS',array('controller'=>'agency','action'=>'settings'),array('div'=>false));?></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details"><?php echo $this->Html->link($this->Html->image('inner_logo.png', array('alt' => '', 'border' => '0')), SITE_URL."/agency/coach", array('escape' => false,'class'=>'inner_logo')); ?>
       
      </section>
<script type="text/javascript">
$(document).ready(function () {
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
</script>      