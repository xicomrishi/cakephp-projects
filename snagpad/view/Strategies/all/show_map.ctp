<script type="text/javascript">
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;

  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var centerMap = new google.maps.LatLng(60,-95);
    var myOptions = {
      zoom:3,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: centerMap
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    directionsDisplay.setMap(map);
 }
  
  function calcRoute() {
    var start = document.getElementById("start").value;
    var end = document.getElementById("end").value;
    var request = {
        origin:start, 
        destination:end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }
</script>
<div class="submit_left">
<h4><?php echo $popTitle;?></h4>
  <p><?php echo $check['Checklist']['description'];?></p>
  </div>
  <div class="submit_right">
  <div id="strat_error" class="error1"></div>
  <form id="strat_mapForm" name="strat_mapForm" method="post" action="">
  <div class="detail_row">
  <input type="hidden" name="card_id" value="<?php echo $card_id;?>"/>
  <input type="hidden" id="check_id" name="check_id" value="<?php echo $check['Checklist']['id'];?>"/>
   <input type='hidden' name='interview_location' id="interview_location" value='' />
	<label style="width:auto !important; margin:0 10px 0 0; display:inline">Your address</label>
    <input type="text"  id="start" name="TR_start" class="text" value="<?php if(isset($int_location[0])){ echo $int_location[0];}?>"  <?php echo $disabled;?> />
    <label style="width:auto !important; margin:0 10px 0 0;display:inline">Destination address</label>
     <input type="text"  id="end" name="TR_end" class="text" value="<?php if(isset($int_location[1])){ echo $int_location[1];}?>"  <?php echo $disabled;?>  />
       <?php if($disabled==""){?>
      <input  type="button" value="Find Route" onclick="calcRoute()" class="ml_button" />
      <?php }?>
  </div>
  <?php if($disabled==""){?>
  <div class="submit_row">
 
  <a href="javascript://" onclick="submit_mapForm();" class="save_btn">SAVE</a>
  </div>
  <?php }?>
  </form>
  <div  style="position:relative; z-index:9999999; width:100%; height:130px; margin-top:29px;">
            <div id="map_canvas" style="float:left;width:100%;height:100%"></div></div>
  </div>
<script type="text/javascript">  

window.onload=initialize() ;
function submit_mapForm()
{
	v=$('#start').val()+" || "+$('#end').val();
	$('#interview_location').val(v);
	var check_id=$('#check_id').val();
		var frm1=$('#strat_mapForm').serialize();
	$('.submit_right').html('<div align="center" id="loading" style="height:50px;padding-top:80px;width:625px;text-align:center;"><?php echo $this->Html->image("loading.gif", array('alt' => 'Loading', 'border' => '0','align'=>'middle'));?></div>');	
	$.post('<?php echo SITE_URL;?>/strategies/save_interview_location',frm1,function(data){
			disablePopup();
			$('#li_a_'+check_id).addClass('done');
			get_strategy_meter();
			get_bar_meter_percent();
		});
}
</script>
  