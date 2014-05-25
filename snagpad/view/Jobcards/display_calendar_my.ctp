<style>
   .css-class-to-highlight{
       background-color: #ff0;
	   font-weight:bold;
	   color:#F90;
   }
   .css-class-to-high{
       background-color: #000;
   }
</style>
<span class="date"><input type="hidden" id="mycalender" class="cal_icon"/></span>
          <div class="calender_box">
                 <div class="cal_pop">
                 
            </div>
          </div>
<script type="text/javascript">
var tips  = ['some description','some other description']; 
var dates=null;
$(document).ready(function(e) {
    get_calender();


	
//var dates1 = ['11/22/2012', '11/23/2012'];
//alert(dates1);

//alert(your_dates);
    $('#mycalender').datepicker({
		
			showOn: "button",
			buttonImage: '<?php echo SITE_URL;?>/img/calender_icon.png',
			buttonImageOnly: true,
			 beforeShow: function (textbox, instance) {
            instance.dpDiv.css({
                    marginTop:  '30px',
                    marginLeft: textbox.offsetWidth + 'px'
            });
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

</script>          