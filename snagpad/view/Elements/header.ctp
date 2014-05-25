<style>
   .css-class-to-highlight{
       background-color: #ff0;
   }
   .css-class-to-high{
       background-color: #000;
   }
</style>
<style>
   .css-class-to-highlight{
       background-color: #ff0;
   }
   .css-class-to-high{
       background-color: #000;
   }
</style>
<section class="top_section">
        <ul class="left_link">
         <li><?php echo $this->Html->link('FIND JOBS','/jobsearch/index');?></li>
         <?php if($this->Session->read('Client.Client.agency_id')!=0){?>
                  <li><?php echo $this->Html->link('JOB BULLETIN',array('controller'=>'cards','action'=>'job_bulletin'));?></li>
         <?php }?>
          <li class="submenu_1" style="height:38px;"><a href="<?php echo SITE_URL;?>/jobcards/index">JOB CARDS</a>
            <ul class="drop_down drop_0">
              <li><?php echo $this->Html->link('MY PAD','/jobcards/index');?></li>
              <li><?php echo $this->Html->link('CREATE',array('controller'=>'jobcards','action'=>'index','redirect'));?></li>
              <li><?php echo $this->Html->link('EXPIRED','/jobcards/expired_cards');?></li>
              <li><?php echo $this->Html->link('RECYCLE BIN',array('controller'=>'jobcards','action'=>'recycle_bin_index'));?></li>
            </ul>
          </li>
          <li><?php echo $this->Html->link('MY PROFILE',array('controller'=>'jobcards','action'=>'profileView'));?></li>
          </ul>
        <div class="calender"> 
          <span class="date"><input type="text" id="mycalender" class="cal_icon"/></span>
          <div class="calender_box">
                 <div class="cal_pop">
                 
            </div>
          </div>
        </div>
        <ul class="right_link"> 
          <li><a href="<?php echo SITE_URL."/message/index";?>"><span>MESSAGES</span><small class="message_counter"><?php echo $message_count;?></small></a></li>
          <li class="submenu"><a href="#" id="user_name"><?php echo $this->Session->read('Client.Client.name');?></a>
          <ul class="drop_down drop_1">
          <li><?php echo $this->Html->link('SETTINGS',array('controller'=>'clients','action'=>'settings'),array('div'=>false));?></li>
          <?php //if($this->Session->read('Client.Client.linkedin_id')==''){?>
          <li><a href="javascript://" onclick="load_pop('social');">SOCIAL</a></li>
          <?php //} ?>
        <li><a href="javascript://" onclick="load_pop('moodle');">LEARNING</a></li>
          <li><?php echo $this->Html->link('REPORTS','/reports/index');?></li>
          <li><?php echo $this->Html->link('SIGN OUT',array('controller'=>'users','action'=>'logout'),array('div'=>false));?></li>
          </ul>
          </li>
        </ul>
      </section>
      <section class="header_details"><a href="<?php echo SITE_URL;?>/jobcards/index"><?php echo $this->Html->image('inner_logo.png', array('alt' => '', 'border' => '0','escape' => false,'class'=>'inner_logo')); ?></a>
        <section class="report_btn" style="display:none;"><a href="#">CHECK YOUR REPORTS</a> <span class="chart_box"><?php echo $this->Html->image('chart_pic.png',array('escape'=>false,'alt'=>''));?></span></section>
        <section class="searchometer">
          <h3>SEARCHOMETER</h3>
          <ul>
            <li class="first" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'The more check marks you earn by completing \"I need to...\" items within Job Cards will raise your strategic score.  Now you\'re conducting a strategic job search.  Way to go!');">
              <h4>STRATEGIC SCORE</h4>
              <div class="meter_box"><figure class="img_s"><?php echo $this->Html->image('meter_small_bg1.png',array('escape'=>false));?></figure><strong class="speed strat_speed_report">0%</strong></div>
            </li>
            <li class="sec" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'S-A-I represents the columns Snagged Jobs, Applied and Interviews. Managing the ratios of these three columns will help determine how you are doing. Ideally you should have twice as many job cards in Snagged Jobs as you have in the Applied column and 5% of those in the Interview column.');">
              <h4>S-A-I</h4>
              <span class="text" id="SAI_status_header">0-0-0</span></li>
            <li class="third" onmouseout="hideTooltip();" onmouseover="showTooltip(event,'The intensity score is the percentage of challenges completed for the present week. The more challenges you complete, the higher your score.');">
              <h4>INTENSITY SCORE</h4>
              <div class="meter_box"><figure class="img_i"><?php echo $this->Html->image('meter_small_bg1.png',array('escape'=>false));?></figure><strong class="speed strat_speed_intensity">0%</strong></div>
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
            <li><strong><?php echo $this->Html->link('DOCUMENTS','/docs/index');?></strong>
              <ul class="no_border">
                <li><?php echo $this->Html->link($this->Html->image('small_icon1.png', array('alt' => '', 'border' => '0')),array('controller'=>'docs','action'=>'index',1), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link($this->Html->image('small_icon2.png', array('alt' => '', 'border' => '0')), array('controller'=>'docs','action'=>'index',2), array('escape' => false)); ?></li>
              </ul>
            </li>
            <li><strong><?php echo $this->Html->link('CONTACTS','/contacts/index');?></strong>
              <ul class="space">
                <li><?php echo $this->Html->link($this->Html->image('small_icon1.png', array('alt' => '', 'border' => '0')),array('controller'=>'contacts','action'=>'index',1), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link($this->Html->image('small_icon2.png', array('alt' => '', 'border' => '0')), array('controller'=>'contacts','action'=>'index',2), array('escape' => false)); ?></li>
                <li style="border-bottom:none"><a id="count_network"  style=" display:inline-block;min-height:17px; padding:3px 6px 0; color:#fff; text-decoration:none; font-weight:normal;">Supporters</a></li>
                 <li><a id="count_network" href="<?php echo SITE_URL; ?>/contacts/index/3" style=" display:inline-block;min-height:16px; padding:3px 0 0 0; min-width:19px; text-align:center; color:#fff; text-decoration:none;"><?php echo $contact_count; ?></a></li>
              </ul>
            </li>
          </ul>
        </section>
      </section>
<script type="text/javascript">
$(document).ready(function () {
	get_strategy_meter();  
	get_intensity_meter(); 
	//get_message_count();
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

});

var tips  = ['some description','some other description']; 
var dates=null;

   
	
//var dates1 = ['11/22/2012', '11/23/2012'];
//alert(dates1);
 get_calender();
//alert(your_dates);
    $('#mycalender').datepicker({
		
			showOn: "button",
			buttonImage: '<?php echo SITE_URL;?>/img/calender_icon.jpg',
			buttonImageOnly: true,
			beforeShow:function(input, inst){
				$('.calender_box').hide();
				input_id = $(input).attr('id');
				instance_id = $(inst).attr('id');
				
				if(instance_id != input_id){
				$(inst).attr('id', input_id);
				}
				},
			beforeShowDay: highlightDays,
			changeMonth: false,
			changeYear: false,
			//minDate: new Date(to_day.getFullYear(), to_day.getMonth(), to_day.getDate()),
			yearRange: 'c:+1',
			dateFormat: 'yy-mm-dd',
			onSelect:function(dateText,inst)
			{
				get_data(dateText);
				//alert(dateText);	
			}
			
			
		});
		

function highlightDays(date) {
	
        for (var i = 0; i < dates.length; i++) {
            if (new Date(dates[i]).toString() == date.toString()) {  
			       
                return [true, 'css-class-to-highlight', tips[i]];
            }
        }
        return [true, ''];
     } 
	 
	 function get_data(dat)
	 {
		$.post('<?php echo SITE_URL;?>/jobcards/get_date_data',{date:dat},function(data){
				//alert(data);
				$('.cal_pop').html(data);
				$('.calender_box').show();
				
			});
		 
	 }
	 
	 function get_calender()
	 {
		
		$.post('<?php echo SITE_URL;?>/jobcards/get_reminder_dates','',function(data){
			arr=JSON.parse(data);
			dates=arr;
		});	 
	}

function show_calender_ico()
{
	$.post('<?php echo SITE_URL;?>/jobcards/show_calender_ico','',function(data){
			$('.calender').html(data);
		});	
}

function get_strategy_meter()
{
	$.post('<?php echo SITE_URL;?>/reports/getStScore','',function(data){
			var res=data.split('|');
			$('.strat_speed_report').html(res[0]+'%');
			$('.img_s').html("<img src='<?php echo SITE_URL;?>/img/meter_small_bg"+res[1]+".png'>");
			$('#SAI_status_header').html(res[2]);
		});	
}

function get_intensity_meter()
{
	$.post('<?php echo SITE_URL;?>/reports/getItScore','',function(data){
			var res=data.split('|');
			$('.strat_speed_intensity').html(res[0]+'%');
			$('.img_i').html("<img src='<?php echo SITE_URL;?>/img/meter_small_bg"+res[1]+".png'>");			
		});	
}
function check_auto_challenges(clientid)
{
	$.post('<?php echo SITE_URL;?>/Challenges/checkChallenge','clientid='+clientid,function(data){			challenge_id=data;
			if(challenge_id)
			{
				$("#backgroundchallengePopup").fadeIn("slow");
				$("#challengePopup").fadeIn("slow");
				//popupStatus = 1;
				$.post('<?php echo SITE_URL;?>/Challenges/autoCompliteChallenge','client_id='+clientid+'&challenge_id='+challenge_id,function(data){
                      $('#challengePopup').html(data);
                     // centerPopup();
					 var windowWidth = document.documentElement.clientWidth;
					 $("#challengePopup").css({
						"left": windowWidth/2-798/2
						});
						window.scrollTo(0,54);
					get_intensity_meter();
            	})				
			}
		});
}

function get_message_count()
{
	$.post('<?php echo SITE_URL;?>/message/message_count','',function(data){
			$('.message_counter').html(data);
		});		
}

function load_pop(pop_name)
{
	disablePopup();
	setTimeout(function(){ 
	if(pop_name=='social')
		loadPopup('<?php echo SITE_URL;?>/users/social_pop');	
	if(pop_name=='moodle')
		loadPopup('<?php echo SITE_URL;?>/users/moodle_login')
	},1000);	
}
</script>      