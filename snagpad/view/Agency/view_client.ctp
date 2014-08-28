<section class="coach_card">
    <section name="coach_section">
        <div class="inputdiv" style="color:#21527F"> <label>Name:</label><span class="detail"> <?php echo $client['name']; ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Email: </label><span class="detail"><?php echo $client['email']; ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Job A Title: </label><span class="detail"><?php if(!empty($client['job_a_title'])){ echo $client['job_a_title']; }else{ echo 'NA';} ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Job A Skills: </label><span class="detail"><?php if(!empty($client['job_a_skills'])){ echo substr(str_replace("|", ", ", $client['job_a_skills']), 0, -2);}else{ echo 'NA'; } ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Job B Criteria: </label><span class="detail"><?php if(!empty($client['job_b_criteria'])){ echo substr(str_replace("|", ", ", $client['job_b_criteria']), 0, -2);}else{ echo 'NA';} ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Registered Date: </label><span class="detail"><?php echo show_formatted_datetime($client['reg_date']); ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Latest Card Movement Date: </label><span class="detail"><?php echo show_formatted_datetime($client['latest_card_mov_date']); ?></span></div>

        <?php if (isset($coaches)) {
            ?>   
        
            <div class="inputdiv" style="color:#21527F"> <label style="padding:11px 0 0 0">Select Coach: </label><span class="detail">
                    <select name='coach_id_<?php echo $client['id'];?>' id="coach_id_<?php echo $client['id'];?>" class="text">
                        <option value='0' <?php if ($client['coach_id'] == 0)
            echo 'selected'; ?>>Select Coach</option>
                        <?php
                        foreach ($coaches as $coach) {
                            if ($coach['Coach']['account_id'] == $client['coach_id'])
                                echo "<option value='".$coach['Coach']['account_id']."' selected>".$coach['Coach']['name']."</option>";
                            else
                                echo "<option value='".$coach['Coach']['account_id']."'>".$coach['Coach']['name']."</option>";
                        }
                    
                    ?></select></span></div>
             <div class="inputdiv" style="color:#21527F"> <label> </label><span class="detail"> <a href="javascript://" onclick="updateClient(<?php echo $client['id'];?>,$('#coach_id_<?php echo $client['id'];?>').val(),<?php echo $client['account_id'];?>)" class="submitbtn" style="margin:-57px 0 0 0 !important">Update</a><br /></span></div>
        
        <?php }?>
       
    </section>
</section>