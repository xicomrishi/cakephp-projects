<section class="coach_card">
    <section name="coach_section">
        <div class="inputdiv" style="color:#21527F"> <label>Name:</label><span class="detail"> <?php echo $coach['name']; ?></span></div>
        <div class="inputdiv" style="color:#21527F"> <label>Email: </label><span class="detail"><?php echo $coach['email']; ?></span></div>
        <?php if (isset($agencies)) {
            ?>   
        
            <div class="inputdiv" style="color:#21527F"> <label>Select Agency: </label><span class="detail">
                    <select name='agency_id_<?php echo $coach['id'];?>' id="agency_id_<?php echo $coach['id'];?>" class="text">
                        <option value='0' <?php if ($coach['agency_id'] == 0)
            echo 'selected'; ?>>Not Applicable</option>
                        <?php
                        foreach ($agencies as $agency) {
                            if ($agency['Agency']['account_id'] == $coach['agency_id'])
                                echo "<option value='".$agency['Agency']['account_id']."' selected>".$agency['Agency']['name']."</option>";
                            else
                                echo "<option value='".$agency['Agency']['account_id']."'>".$agency['Agency']['name']."</option>";
                        }
                    
                    ?></select></span></div>
             <div class="inputdiv" style="color:#21527F"> <label> </label><span class="detail"> <a href="javascript://" onclick="updateCoach(<?php echo $coach['id'];?>,$('#agency_id_<?php echo $coach['id'];?>').val(),<?php echo $coach['account_id']?>)" class="submitbtn">Update</a><br /></span></div>
        
        <?php }?>
       
    </section>
</section>