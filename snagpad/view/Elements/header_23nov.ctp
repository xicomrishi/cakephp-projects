<section class="top_section">
        <ul class="left_link">
         <li><?php echo $this->Html->link('FIND JOBS',array('controller'=>'jobsearch','action'=>'index'));?></li>
          <li class="submenu_1" style="height:38px;"><a>JOB CARDS</a>
            <ul class="drop_down drop_0">
              <li><?php echo $this->Html->link('BROWSE',array('controller'=>'jobcards','action'=>'index'));?></li>
              <li><a href="javascript://" onclick="show_add_jobcard();">CREATE</a></li>
              <li><a href="#">EXPIRED</a></li>
              <li><?php echo $this->Html->link('RECYCLE BIN',array('controller'=>'jobcards','action'=>'recycle_bin_index'));?></li>
            </ul>
          </li>
          <li><?php echo $this->Html->link('MY PROFILE',array('controller'=>'jobcards','action'=>'profileView'));?></li>
          </ul>
        <div class="calender"> 
          
        </div>
        <ul class="right_link"> 
          <li><a href="#"><span>MESSAGES</span><small>3</small></a></li>
          <li class="submenu"><a href="#" id="user_name"><?php echo $this->Session->read('Client.Client.name');?></a>
          <ul class="drop_down drop_1">
          <li><?php echo $this->Html->link('SETTINGS',array('controller'=>'clients','action'=>'settings'),array('div'=>false));?></li>
         <!-- <li><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/users/social')">SOCIAL SETTING</a></li>-->
          <li><?php echo $this->Html->link('REPORTS',array('controller'=>'reports','action'=>'index'));?></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details"><?php echo $this->Html->link($this->Html->image('inner_logo.png', array('alt' => '', 'border' => '0')), SITE_URL, array('escape' => false,'class'=>'inner_logo')); ?>
        <section class="report_btn" style="display:none;"><a href="#">CHECK YOUR REPORTS</a> <span class="chart_box"><?php echo $this->Html->image('chart_pic.png',array('escape'=>false,'alt'=>''));?></span></section>
        <section class="searchometer">
          <h3>SEARCHOMETER</h3>
          <ul>
            <li class="first">
              <h4>STRATEGIC SCORE</h4>
              <div class="meter_box"><strong class="speed">29%</strong><span class="line"><?php echo $this->Html->image('line.png',array('escape'=>false,'alt'=>''));?></span></div>
            </li>
            <li class="sec">
              <h4>O-A-I</h4>
              <span class="text">22-12-3</span></li>
            <li class="third">
              <h4>INTENSITY SCORE</h4>
              <div class="meter_box"><strong class="speed">72%</strong><span class="line"><?php echo $this->Html->image('line.png',array('escape'=>false,'alt'=>''));?></span></div>
            </li>
          </ul>
        </section>
        <section class="report_box" style="display:none">
          <ul>
            <li>
              <div class="bar"><span class="orange_bar"></span></div>
            </li>
            <li>
              <div class="bar"><span class="blue_bar"></span></div>
            </li>
          </ul>
         <a href="#" class="report">reports</a> </section>
        <section class="right_header">
          <ul>
            <li><strong><?php echo $this->Html->link('DOCUMENTS',array('controller'=>'docs','action'=>'index'));?></strong>
              <ul class="no_border">
                <li><?php echo $this->Html->link($this->Html->image('small_icon1.png', array('alt' => '', 'border' => '0')),array('controller'=>'docs','action'=>'index',1), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link($this->Html->image('small_icon2.png', array('alt' => '', 'border' => '0')), array('controller'=>'docs','action'=>'index',2), array('escape' => false)); ?></li>
              </ul>
            </li>
            <li><strong><?php echo $this->Html->link('CONTACTS',array('controller'=>'contacts','action'=>'index'));?></strong>
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
    $(".submenu").hover(
  function () {
     $('ul.drop_down.drop_1').show();
  },
  function () {
     $('ul.drop_down.drop_1').hide();
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

 $(".submenu_1").hover(
  function () {
     $('ul.drop_down.drop_0').show();
  },
  function () {
     $('ul.drop_down.drop_0').hide();
  }
);

     $(".drop_0 li").hover(
  function () {
	  $('ul.drop_down.drop_0').show();
    // $(this).children("ul").slideDown('medium');
  },
  function () {
	   $('ul.drop_down.drop_0').hide();
   // $(this).children("ul").slideUp('medium');
  }
);
show_calender_ico();


});

function show_calender_ico()
{
	$.post('<?php echo SITE_URL;?>/jobcards/show_calender_ico','',function(data){
			$('.calender').html(data);
		});	
}
/*
function display_show_add_jobcard()
{
	var path=window.location.pathname.split('/');
	if(path[2]!=='jobcards')
	{
		window.location='<?php echo SITE_URL;?>/jobcards';	
		show_add_jobcard();
	}
	alert(path[2]);	
}*/

</script>      