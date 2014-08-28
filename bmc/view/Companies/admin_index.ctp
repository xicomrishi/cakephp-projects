<?php echo $this->Html->script(array('jsapi','canvg','rgbcolor')); ?> 
<style>
.table th a{  color: #000000;text-decoration: none;}
</style>
<style>
table.view_spec_table td{ background-color:#e8e8e8 !important; }
#chart_img_line{margin:45px 0 0 0}
#chart_img_bar{margin:45px 0 0 0}
</style>

<div class="wrapper">   
  <section id="body_container">
  	<?php echo $this->element('menu_admin'); ?>
    <section class="container">
    
    <div class="tab_detail"> 
   
     <h3 class="title">Companies</h3>
        <div class="inner">
              <form id="searchCompanyForm" name="searchCompanyForm" action="" method="post" class="form">
                <table class="table">
                  <thead>
                  <tr>
                    <th class="first">S.No.</th>
                    <th><?php echo $this->Paginator->sort('company','Company Name');?></th>
                    <th>Added by</th>
                    <!--<th class="last">Report</th>-->
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
				 
				  $i=1;
				  foreach($companies as $comp){ ?>
                  <tr class="<?php if($i%2==0) echo 'even'; else echo 'odd'; ?>" id="train_<?php echo $i; ?>">
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript://" onclick="open_lightbox('/companies/get_company_courses/<?php echo $comp['Company']['id']; ?>',805);"><?php echo $comp['Company']['company']; ?></a></td>
                    <td><?php echo $comp['User']['first_name'].' '.$comp['User']['last_name']; ?> | <a href="javascript://" onclick="show_graph_data('<?php echo $comp['Company']['id']; ?>');">View Aggregate Data</a></td>
                    <!--<td class="last"><a href="javascript://">N/A</a></td>-->
                  </tr>
                  <tr id="chart_tr_<?php echo $comp['Company']['id']; ?>" class="chart_tr" style="display:none;">
                  	<td colspan="3">
                    	<div id="comp_chart_<?php echo $comp['Company']['id']; ?>"></div>
                        <div id="comp_chart_<?php echo $comp['Company']['id']; ?>"></div>
                    </td>
                  </tr>
                  <?php $i++; } ?>
                  
                </tbody>
                </table>
                <div class="actions-bar wat-cf">
               <div class="pagination">
     <?php echo $this->Paginator->prev('<< ' . __('previous', true), null, null, array('class'=>'disabled'));?>
	 <?php echo $this->Paginator->numbers(array('separator'=>'','currentTag'=>'','tag'=>'span','rel'=>'next'));?>
 	 <?php echo $this->Paginator->next(__('next', true) . ' >>', null, null, array('class' => 'disabled'));?>
                  </div>
                </div>
              </form>
            </div>
    </div>
    
    </section>
  </section>
</div>

<script type="text/javascript">

 $(function () {
    $('.checkall').click(function () {
        $(this).parents('section:eq(1)').find(':checkbox').attr('checked', this.checked);
    });
});

function check(el){
	if(el.checked==false)
		$('.checkall').attr('checked',false); 
}

function show_graph_data(comp_id){
	
	$('.chart_tr').html('<td colspan="3"></td>');
	$('.chart_tr').css('border','none');
	
	$.post('<?php echo $this->webroot; ?>benchmark/get_company_specific_data',{company_id:comp_id},function(data){
		$('#chart_tr_'+comp_id).html(data);
		$('#chart_tr_'+comp_id).css('border','2px solid #000');
		$('#chart_tr_'+comp_id).slideDown(200);
		});	
}
</script> 