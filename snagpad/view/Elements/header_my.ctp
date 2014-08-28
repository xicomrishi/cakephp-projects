<section class="top_section">
        <ul class="left_link">
         <!-- <li><?php echo $this->Html->link('FIND JOBS',array('controller'=>'jobsearch','action'=>'index'));?></li>-->
         <li><a>FIND JOBS</a></li>
          <li><?php echo $this->Html->link('JOB CARDS',array('controller'=>'jobcards','action'=>'index'));?>
            <ul class="drop_down">
              <li><a href="#">BROWSE</a></li>
              <li><a href="#">CREATE</a></li>
              <li><a href="#">EXPIRED</a></li>
              <li><a href="#">RECYCLE BIN</a></li>
            </ul>
          </li>
          <li><?php echo $this->Html->link('MY PROFILE',array('controller'=>'jobcards','action'=>'profileWizard'));?></li>
          </ul>
        <div class="calender"> <span class="date"><a href="#">31</a></span>
          <div class="calender_box">
            <div class="month_row"><a href="#" class="left_arrow"></a><span class="month">AUGUST 2012</span><a href="#" class="right_arrow"></a></div>
            <ul class="day_row">
              <li>M</li>
              <li>T</li>
              <li>w</li>
              <li>t</li>
              <li>f</li>
              <li>s</li>
              <li class="last">s</li>
            </ul>
            <div class="date_row">
              <ul>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li class="leave"><a href="#">5</a></li>
                <li><a href="#">6</a></li>
                <li><a href="#">7</a></li>
                <li><a href="#">8</a></li>
                <li class="orange"><a href="#">9</a></li>
                <li><a href="#">10</a></li>
                <li><a href="#">11</a></li>
                <li class="leave"><a href="#">12</a></li>
                <li><a href="#">13</a></li>
                <li><a href="#">14</a></li>
                <li><a href="#">15</a></li>
                <li><a href="#">16</a></li>
                <li class="orange"><a href="#">17</a></li>
                <li><a href="#">18</a></li>
                <li class="leave"><a href="#">19</a></li>
                <li><a href="#">20</a></li>
                <li class="orange"><a href="#">21</a></li>
                <li><a href="#">22</a></li>
                <li class="orange"><a href="#">23</a></li>
                <li><a href="#">24</a></li>
                <li><a href="#">25</a></li>
                <li class="leave"><a href="#">26</a></li>
                <li><a href="#">27</a></li>
                <li><a href="#">28</a></li>
                <li><a href="#">29</a></li>
                <li><a href="#">30</a></li>
                <li><a href="#">31</a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="right_link"> 
          <li><a href="#"><span>MESSAGES</span><small>3</small></a></li>
          <li class="submenu"><a href="#"><?php echo $this->Session->read('Client.Client.name');?></a>
          <ul class="drop_down drop_1">
          <li class="active"><?php echo $this->Html->link('SETTINGS',array('controller'=>'clients','action'=>'settings'),array('div'=>false));?></li>
         <!-- <li><a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/users/social')">SOCIAL SETTING</a></li>-->
          <li><a href="#">REPORTS</a></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details"><?php echo $this->Html->link($this->Html->image('inner_logo.png', array('alt' => '', 'border' => '0')), '#', array('escape' => false,'class'=>'inner_logo')); ?>
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
});
</script>      