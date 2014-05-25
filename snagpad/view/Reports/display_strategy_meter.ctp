<?php echo $this->Html->script(array('jsDialGauge'));?>
<div id="meter_strat" style="width: 150px; height: 100px; "></div>

<script type="text/javascript">
var chart;
$(document).ready(function(e) {
    
	//var placeholder43 = $("#meter_strat");
                     var options = {
                    				face_type: "open",
				                   
                    };
                    var placeholder12 = $("#meter_strat");
                    $.jsDialGauge(placeholder12,"invertedround",7,"Demo 12",
                    		0,100,
                			270,options);
	
});


</script>

