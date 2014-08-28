<style>
.sectionTabs span{background-color: #ccc;float: left;line-height: 32px;text-align: center;width: 320px;border-right: 1px solid #FFFFFF; font-size:15px; color:#000; cursor:pointer;}
.sectionTabs span.current{background-color: #9BCDD5;}
.sectionTabs span:hover{background-color: #9BCDD5;}
</style>
<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <div class="tab_detail"> 
   <div class="invite">
   <span style="background-color:#ccc; padding:8px; float:left;"><a href="<?php echo $this->webroot; ?>admin/benchmark/overall_data" style="float:left">View Overall Benchmark Data >></a></span>
   <span>Add Benchmark Data</span><a href="javascript://" onclick="add_bc_data('000');"><img src="<?php echo $this->webroot; ?>img/invite.png" alt=""/></a></div>
     <!--<h3 class="title"><?php echo __('Benchmark Data'); ?></h3>-->
     <div class="sectionTabs">
     	<span class="current" onclick="show_section_data('1');">Admin Data</span>
        <span onclick="show_section_data('2');">System Generated</span>
        <span onclick="show_section_data('3');">Aggregate Data</span>
     </div>
     <div class="nano">
        <div class="inner contentSection">
              <form id="cmsForm" name="cmsForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first"><?php echo __('S.No.'); ?></th>               
                    <th><?php echo __('Company'); ?></th>
                    <th><?php echo __('Date Modified'); ?></th>
                    <th><?php echo __('Hints'); ?></th>
                    <th><?php echo __('Action'); ?></th>                                 	
                  </tr>
                  </thead>
                  <tbody>
                 
                  <?php 
				 
				$i=1;
				  foreach($data as $dat){  ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="data_<?php echo $i; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $dat['Company']['company']; ?></td>
                    <td><?php echo show_formatted_date($dat['BenchmarkComp']['date_modified']); ?></td>
                    <td><?php echo $dat['BenchmarkComp']['last_update']; ?></td>
                    <td><a href="javascript://" onclick="show_comp_data('<?php echo $dat['BenchmarkComp']['id']; ?>');">Manage</a></td>
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                
              </form>
            </div>
        </div>   
    </div>
    <section class="dataSection">
    <?php if(isset($data_exist)){ ?>
    	  <div class="specificData">
              
              <div style="text-align:center; height:100px; margin-top:50px;">Data was not saved since data already exist for selected criteria.</div>  
          </div> 
    <?php } ?>
    </section>
    </section>
    
  </section>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
    $(".nano").nanoScroller({alwaysVisible:true, contentClass:'contentSection',sliderMaxHeight: 70 });
});
function show_comp_data(id)
{
	showLoading('.dataSection');
	$.post('<?php echo $this->webroot; ?>benchmark/get_company_data',{id:id},function(data){
		$('html, body').animate({
			scrollTop: $(".dataSection").offset().top
		}, 500);
		$('.dataSection').html(data);		
	});	
}

function show_filter_data(comp_id,num,section)
{
	role=$('#role_list_inp').val();
	ind=$('#industry_list_inp').val();
	cntry=$('#country_list_inp').val();
	year=$('#year_list_inp').val();
	
	var flag=0;
	var type=null;
	if(cntry==''||cntry==null)
	{
		type='1';	
	}else{
		type='3';	
	}
	
	switch(type)
	{
		case '1': if(ind==''||ind==null)
				  {		flag=1;//alert('Please select Industry');
				  }else{
					  flag=1; }
				 break;
		case '2': type='1';
				  if(role==''||role==null)
				  {	flag=1;//alert('Please select Role');
				  }else{ 
				    flag=1;
				  }
				break;
		case '3': if(role==''||role==null)
				  {		flag=1;//alert('Please select Role');
				  }else if(ind==''||ind==null)
				  {		flag=1;//alert('Please select Industry');
				  }else{ 
				    flag=1; }
				 break;											 	   			
	}
	
	if(flag==1)
	{
		if(num!='2')
		{
			showLoading('.specificData');
			$.post('<?php echo $this->webroot; ?>benchmark/show_specific_data',{type:type,comp_id:comp_id,role:role,ind:ind,cntry:cntry,num:num,year:year,section:section},function(data){
				$('.specificData').html(data);	
			});
		}else{
			y=confirm('Are you sure, you want to delete benchmark data for this company?');	
			if(y)
			{
				showLoading('.specificData');
				$.post('<?php echo $this->webroot; ?>benchmark/show_specific_data',{type:type,comp_id:comp_id,role:role,ind:ind,cntry:cntry,num:num,year:year,section:section},function(data){
					window.location.href='<?php echo $this->webroot; ?>admin/benchmark/index';	
				});	
			}
		}
	}
}

function save_bc_data()
{
	var frm=$('#specDataForm').serialize();
	var valid = $("#specDataForm").validationEngine('validate');
	if(valid)
	{
		$.post('<?php echo $this->webroot; ?>benchmark/update_benchmark_data',frm,function(resp){			
			show_filter_data(resp,0,0);	
		});			
	}else{
		$("#specDataForm").validationEngine({scroll:false,focusFirstField : false});	
	}
	return false;	
}

function add_bc_data(comp_id)
{
	open_lightbox('/benchmark/add_benchmark_data/'+comp_id,'985');	
}

function show_section_data(num)
{
	$('.sectionTabs span').removeClass('current');
	showLoading('.contentSection');	
	$('.dataSection').html('');	
	$('.sectionTabs span').eq(num-1).addClass('current');
	$.post('<?php echo $this->webroot; ?>benchmark/show_section_data',{num:num},function(data){
		$('.contentSection').html(data);
		 $(".nano").nanoScroller({alwaysVisible:true, contentClass:'contentSection',sliderMaxHeight: 70 });	
	});
}
function show_systemComp_data(cid)
{
	showLoading('.dataSection');
	$.post('<?php echo $this->webroot; ?>benchmark/systemCompany_data',{cid:cid},function(data){
		$('html, body').animate({
			scrollTop: $(".dataSection").offset().top
		}, 500);
		$('.dataSection').html(data);		
	});		
}

function show_aggregateComp_data(cid)
{
	showLoading('.dataSection');
	$.post('<?php echo $this->webroot; ?>benchmark/aggregateCompany_data',{cid:cid},function(data){
		$('html, body').animate({
			scrollTop: $(".dataSection").offset().top
		}, 500);
		$('.dataSection').html(data);		
	});	
}

</script>