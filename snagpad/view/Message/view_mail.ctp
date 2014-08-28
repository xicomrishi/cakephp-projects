<section class="coach_card border">

                <section name="coach_section">
                    <div class="inputdiv" style="color:#21527F"> <label><?php if($type==0) echo "From"; else echo "To";?>:</label><span class="detail"> <?php echo $mail['0']['name'];?></span></div>
                                        <div class="inputdiv" style="color:#21527F"><label>Sent Date:</label><span class="detail"><?php echo show_formatted_datetime($mail['M']['send_date']);?></span></div>
                    <div class="inputdiv" style="color:#21527F"> <label>Subject: </label><span class="detail"><?php echo $mail['M']['subject'];?></span></div>
            
                    <div class="inputdiv" style="color:#21527F; width:100%"> <label>Message: </label><span class="detail"><?php echo nl2br($mail['M']['message']);?></span></div>
                    <?php if($mail['M']['file']!=''){ ?>
                    <div class="inputdiv" style="color:#21527F"> <label>Attachment: </label><span class="detail"><a href="<?php echo SITE_URL."/attachments/".$mail['M']['filename'];?>" target="_blank"><?php echo $mail['M']['file'];?></a></span></div>
                    <?php }
					if($type==0){?>
                         
                    
                    <?php }
					?>
                </section>
                </section>