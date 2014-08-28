<section class="tabing_container">

    <section class="top_sec pad2">
        <section class="left_sec"><h3> Share Agency Card</h3>
        </section>

    </section>
    <section class="coach_card">
        <div id="msg"></div>
        <form action="<?php echo SITE_URL."/Agencycards/shareCard/".$card['id']."/".$usertype;?>" id="frmCard" name="frmCard" method="post"><fieldset>
                <section name="coach_section">
                    <div class="inputdiv" style="color:#21527F"> <label>Company Name:</label> <?php echo $card['company_name'];?></div>
                    <div class="inputdiv" style="color:#21527F"> <label>Position Available: </label><?php echo $card['position_available'];?></div>
                    <div class="inputdiv" style="color:#21527F"><label>Application Deadline:</label> <?php echo show_formatted_date($card['application_deadline']);?></div>                        <div class="inputdiv"><label><?php if($usertype=="3") echo "Clients"; else echo "Coach";?></label>
                   
                    <?php if (is_array($rows) && count($rows) > 0) { ?>
                          <div style="float:left">
                     		<div class="" style="color:#21527F;  padding:0 0 10px 0">
                                <span class="coln1"><input type="checkbox" id="all_check" onclick="select_all_check();"/></span>
                                <span class="coln2 color">Select all</span>
                              </div> 
                        <?php foreach ($rows as $row) { ?>
                        
                            <div class="" style="color:#21527F;  padding:0 0 10px 0">
                                <span class="coln1"><input type="checkbox" name="cbox[]" class="card_check" onclick="objDelChecked(this); uncheck();" value="<?php echo $row['C']['account_id']; ?>"></span>
                                <span class="coln2 color"><?php echo $row['C']['name'] . "[" . $row['C']['email'] . "]"; ?></span>
                            </div>
                        <?php } ?>
                        </div>
                        <div style="float:left;margin-top:10px;margin-left:400px;text-align:center">
                            <a href="javascript://" onclick="shareCard(<?php echo $card['id'];?>,<?php echo $usertype;?>)" class="submitbtn">Share</a><br />
                                        
                        </div>  
                        <div id="page_navigation">
                        </div>
                    <?php }else { ?>
                        <div style="text-align: center; width:100%">Card already shared with all the <?php if($usertype=='2'){ echo 'coach(es)'; }else if($usertype=='3'){ echo 'client(s)' ; }?></div>
                    <?php } ?>
                    </div>                        
                </section>
                </section>
                </section>

                <script type="text/javascript">
                    var iDelTotalChecked=0;
                    function objDelChecked(chk)
                    {
                        if(chk.checked==true)
                            iDelTotalChecked=iDelTotalChecked+1
                        else
                            iDelTotalChecked=iDelTotalChecked-1
                    }
                    function shareCard(id,usertype)
                    {
                        if(iDelTotalChecked==0)
                            alert("Please select user to share card");
                        else
                            {
                                document.frmCard.submit();
                            }
                    }
					function select_all_check()
{
	if($('#all_check').attr('checked'))
	{
		$('.card_check').each(function(index, element) {
         $(this).attr('checked',true);
		objDelChecked(this);
		
     });
	 
	}else{
	$('.card_check').each(function(index, element) {
        
		$(this).attr('checked',false);
		objDelChecked(this);
		
    });
	}
}
function uncheck()
{
	if($('#all_check').attr('checked'))
	{
		$('#all_check').attr('checked',false);
	}	
}
                </script>

