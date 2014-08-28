<section class="top_section">
        <ul class="left_link">
        <li><?php echo $this->Html->link('Agency',array('controller'=>'super','action'=>'index','prefix'=>'admin'));?></li>
          <li><?php echo $this->Html->link('Coach',array('controller'=>'agency','action'=>'coach','prefix'=>'admin'));?></li>
          <li><?php echo $this->Html->link('Clients',array('controller'=>'agency','action'=>'index','prefix'=>'admin'));?></li>
          <li><?php echo $this->Html->link('CMS',array('controller'=>'info','action'=>'index','prefix'=>'admin'));?></li>
          <li><?php echo $this->Html->link('Mails',array('controller'=>'mails','action'=>'index','prefix'=>'admin'));?></li>
          <li><?php echo $this->Html->link('Subscription',array('controller'=>'info','action'=>'index','prefix'=>'admin'));?></li>
		  <li class="submenu1"><?php echo $this->Html->link('FAQs',array('controller'=>'faqs','action'=>'index','prefix'=>'admin'));?>
                    <ul class="drop_down drop_2">
              <li><?php echo $this->Html->link('FAQ Category',array('controller'=>'jobcards','action'=>'index'));?></li>
              <li><?php echo $this->Html->link('FAQ',array('controller'=>'jobcards','action'=>'index','redirect'));?></li>
            </ul>

          </li>          
          <li><?php echo $this->Html->link('Cards',array('controller'=>'Admincards','action'=>'index','prefix'=>'admin'));?></li>
        </ul>
        
        <ul class="right_link"> 
          <li class="submenu"><a href="#" id="user_name"><?php echo $this->Session->read('Admin.Adminlogin.username');?></a>
          <ul class="drop_down drop_1">
          <li class="active"><?php echo $this->Html->link('SETTINGS',array('controller'=>'agency','action'=>'settings'),array('div'=>false));?></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details"><?php echo $this->Html->link($this->Html->image('inner_logo.png', array('alt' => '', 'border' => '0')), '#', array('escape' => false,'class'=>'inner_logo')); ?>
       
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