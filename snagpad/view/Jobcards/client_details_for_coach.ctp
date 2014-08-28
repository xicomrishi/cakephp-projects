<div class="out_wrapper">
 <div class="col_1 center">
    	<label>Client</label>
        <p><?php echo $client['Client']['name'];?></p>
        </div>
        <div class="col_1 center">
        <label>Last Card Move Date</label>
        <p><?php echo show_formatted_datetime($latest_date);?></p>
        </div>
        <div class="col_1 center">
        <label>Job Search Start Date</label>
        <p><?php echo show_formatted_datetime($client['Client']['reg_date']);?></p>
        </div>
       <div class="col_1 center">
        <label>Job A</label>
        <p><?php echo $client['Client']['job_a_title'];?></p>
        </div>

        </div>