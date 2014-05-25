<table  border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
        <div class="main_heading">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        <th width="100">Client Name</th>
        <th width="119">Job A</th>
        <th width="100">Employed Job A</th>
        <th width="119">Job B</th>
        <th width="100">Employed Job B</th>
        <th width="100">Average Days</th>
        <th width="100">Client SAI</th>
        <th width="120">Movement of Cards</th>
        <th width="100">Last Card Movement</th>
        </tr>
        </table>
        </div>
        </td>
    </tr>
    <?php $i=0; foreach ($rows as $row) {
        if($i==0){
        ?>
<tr>

        <td>
        <div class="sub_heading">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="100" align="center"><?php echo $row['name']; ?></td>
            <td width="119" align="center"><?php if(!empty($row['job_a']))echo $row['job_a'];else echo'NA'; ?></td>
            <td width="100" align="center"><?php echo $row['job_countA']; ?></td>
            <td width="119" align="center"><?php echo $row['job_b'];?></td>
            <td width="100" align="center"><?php echo $row['job_countB'];?></td>
            <td width="100" align="center"><?php echo $row['avg'];?></td>
            <td width="100" align="center"><?php echo $row['OAI'];?></td>
            <td width="120" align="center"><?php echo $row['movement'];?></td>
            <td width="100" align="center"><?php echo show_formatted_date($row['latest_card_mov_date']);?></td>
            </tr>
            </table>
            </div>
            </td>
            
        </tr>    
    <?php }else{?>
        <tr>
        <td>
        <div class="com_rows">
            <span  class="col1"><?php echo $row['name']; ?></span>
            <span  class="col2"><?php echo $row['job_a']; ?></span>
            <span  class="col3"><?php echo $row['job_countA']; ?></span>
            <span  class="col4"><?php echo $row['job_b'];?></span>
            <span  class="col5"><?php echo $row['job_countB'];?></span>
            <span  class="col6"><?php if(!empty($row['avg']))echo $row['avg'];else echo'NA'; ?></span>
            <span  class="col7"><?php echo $row['OAI'];?></span>
            <span  class="col8"><?php echo $row['movement'];?></span>
            <span  class="col9"><?php echo show_formatted_date($row['latest_card_mov_date']);?></span>
            </div>
            </td>
        </tr>    


<?php  } $i++;}?>
</table>