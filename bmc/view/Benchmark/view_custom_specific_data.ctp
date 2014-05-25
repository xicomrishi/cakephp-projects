<?php if(isset($section_chart)){ 
	echo $this->Html->script(array('jsapi','canvg','rgbcolor'));?>
<?php } ?>   
 
<style>
table.view_spec_table td{ background-color:#e8e8e8 !important; }
#chart_img_line{margin:45px 0 0 0}
#chart_img_bar{margin:45px 0 0 0}
</style>


<div class="data_tables" style="float:left">
 <?php if(!empty($data)){ ?>
 <?php $p=0; for($i=1;$i<7;$i++){   ?> 
 
              	<div class="comn_row">
                <div class="title"><?php if($i==1) echo __('Planning'); else if($i==2) echo __('Organizing &amp; Staffing'); else if($i==3) echo __('Directing &amp; Leading'); else if($i==4) echo __('Controlling'); else if($i==5) echo __('Reporting'); else if($i==6) echo __('Risk Management'); ?></div>
                <table width="50%" class="view_spec_table">               
                	<thead>
                    	<th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>                       
                    </thead>
                    <tbody>                    	
                    	<tr>
                        	<td><?php if(isset($data[$i]['1'])) echo $data[$i]['1']; else echo 0;  ?></td>
                            <td><?php if(isset($data[$i]['2'])) echo $data[$i]['2']; else echo 0;  ?></td>
                            <td><?php if(isset($data[$i]['3'])) echo $data[$i]['3']; else echo 0;  ?></td>
                            <td><?php if(isset($data[$i]['4'])) echo $data[$i]['4']; else echo 0;  ?></td>
                            <td><?php if(isset($data[$i]['5'])) echo $data[$i]['5']; else echo 0;  ?></td>                            
                        </tr>
                    </tbody>
                </table>
                </div>
                <?php } ?>
                

             <?php }else{ ?>
          		 <div style="text-align:center; height:100px; margin-top:50px;">No Data available for selected criteria.</div>
             <?php } ?>  
            
      </div>
 
  <?php if(isset($section_chart)){ ?> 
      <div class="chartSection">
      <div style="height:50px; text-align:center; margin-top:30px;" class="loader_div"><img src="<?php echo $this->webroot; ?>img/hourglass.gif" alt="Please wait..."/></div>
      <div id="visualization_bar" style="height:500px; width:100%; float:left;"></div>
       <div class="fancybox_div">
       <a href="javascript://" class="chart_anchors download_bar" onclick="saveAsImg(document.getElementById('visualization_bar'),'bar');" style="display:none;">Download</a>
       <a href="javascript://" class="chart_anchors" onclick="show_graph(1,0);" style="display:none;">View</a>
       <a href="javascript://" class="chart_anchors" onclick="show_graph(1,1);" style="display:none;">Print</a>
       <div id="chart_img_bar" style="display:none;"></div>  
       </div>
       <div id="visualization_line" style="height:500px; width:100%; float:left;"></div>
       <div class="fancybox_div">
       
       <a href="javascript://" class="chart_anchors download_line" onclick="saveAsImg(document.getElementById('visualization_line'),'line');" style="display:none;">Download</a>
       <a href="javascript://" class="chart_anchors" onclick="show_graph(2,0);" style="display:none;">View</a>
       <a href="javascript://" class="chart_anchors" onclick="show_graph(2,1);" style="display:none;">Print</a>
       <div id="chart_img_line"  style="display:none;">></div>
       </div>
   </div>
 <script type="text/javascript">
 
  google.load('visualization', '1', {packages: ['corechart'], callback:function(){ drawChart(); drawlinechart();}});
      function drawChart() {
        var data = google.visualization.arrayToDataTable([<?php echo $section_chart; ?>]);  
		 var options = {
          title: '<?php if(isset($role_text)) echo $role_text; ?>',
		  legend: { position: 'right', maxLines: 3 }
		  
        };    
        new google.visualization.ColumnChart(document.getElementById('visualization_bar')).
            draw(data,options);
			$('.loader_div').hide();
			
      }  
	  
	  function drawlinechart() {
		 
        var data = google.visualization.arrayToDataTable([<?php echo $section_chart; ?>]);
		 var options = {
          title: '<?php if(isset($role_text)) echo $role_text; ?>',
		  legend: { position: 'right', maxLines: 3 },
		  pointSize: 3
        };
       new google.visualization.LineChart(document.getElementById('visualization_line')).
        draw(data,options);
		$('.chart_anchors').show();
		$('.loader_div').hide();
      }
	  
	  function getImgData(chartContainer) {
        var chartArea = chartContainer.getElementsByTagName('svg')[0].parentNode;
        var svg = chartArea.innerHTML;
        var doc = chartContainer.ownerDocument;
        var canvas = doc.createElement('canvas');
        canvas.setAttribute('width', chartArea.offsetWidth);
        canvas.setAttribute('height', chartArea.offsetHeight);
        
        
        canvas.setAttribute(
            'style',
            'position: absolute; ' +
            'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
            'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
        doc.body.appendChild(canvas);
        canvg(canvas, svg);
        var imgData = canvas.toDataURL('image/png');
        canvas.parentNode.removeChild(canvas);
        return imgData;
      }
	  
	  function toImg(chartContainer, imgContainer) { 
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
        }
        imgContainer.appendChild(img);
      }
	  
	   function saveAsImg(chartContainer,typ) {
        var imgData = getImgData(chartContainer);
       	$('.download_'+typ).attr('href',imgData).attr("download", "chart.png");
	    setTimeout(function(){ $('.download_'+typ).trigger('click'); },100);
		//window.location = imgData.replace('image/png', 'image/octet-stream');
      } 
	  
	  function show_graph(num,type)
	  {
		if(num==1)
		{	var divid='bar';
			var destid='bar'; 
		}else if(num==2)
		{
			var divid='line';
			var destid='line';
		}
		toImg(document.getElementById('visualization_'+divid),document.getElementById('chart_img_'+destid));
		if(type=='0')
		{
			setTimeout(function(){ 
				$.fancybox.open({
					'href'   : '#chart_img_'+destid,
					'titleShow'  : false
				 });
			},100);
		 }else{
				setTimeout(function(){ PrintElem('#chart_img_'+destid); },100);	
			}
		 }
	  
	  function PrintElem(elem)
		{
			Popup($(elem).html());
		}
	  
	  function Popup(data) 
		{
			var mywindow = window.open('', '', 'height=400,width=600');
			mywindow.document.write('<html><head><title>Graphical Representation</title>');
			/*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
			mywindow.document.write('</head><body >');
			mywindow.document.write(data);
			mywindow.document.write('</body></html>');
	
			mywindow.print();
			mywindow.close();
	
			return true;
		}
    </script>     
 <?php } ?>