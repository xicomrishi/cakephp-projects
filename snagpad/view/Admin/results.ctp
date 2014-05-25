	<section class="title_row">
             <span class="column1"><input type="checkbox" onclick="select_all_check();"/>
            <small>TITLE</small></span>
            <span class="column2 text_indent">NAME</span>
            <span class="column3">EMAIL</span>
            <span class="column4">DATE ADDED</span>
        </section>
        <?php foreach($agency as $ag){ ?>
         <section class="comon_row">
          <span class="column1 colour1"><input type="checkbox" name="cbox[]" class="contact_check" onclick="objDelChecked(this)" value="<?php echo $ag['Agency']['id']; ?>"><small><a href="javascript://"><?php echo $ag['Agency']['name']; ?></a></small></span>
        <span class="column2 colour2"><a href="mailto:<?php echo $ag['Agency']['email']; ?>"><?php echo $ag['Agency']['email']; ?></a></span>
        <span class="column3 colour3"><?php echo show_formatted_datetime($ag['Agency']['reg_date']); ?></span>
       
        </section>
        <?php } ?>