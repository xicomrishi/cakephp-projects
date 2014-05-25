<div class="comon_row">
        <span class="column1 colour1 bold"><small><?php echo $contact['Contact']['contact_name'];?></small></span>
        <span class="column2 colour2"><a href="mailto:<?php echo $contact['Contact']['email'];?>"><?php echo $contact['Contact']['email'];?></a></span>
        <span class="column3 colour3"><?php echo show_formatted_datetime($contact['Contact']['date_added']); ?></span>
        <span class="column4 colour3"><?php echo show_formatted_datetime($contact['Contact']['date_modified']); ?></span>
</div>