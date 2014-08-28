<section class="tabing_container">
        <section class="tabing">
          <ul class="tab">
           
            <li id="search_doc_li" class="active last">MAIL COMPOSE</li>
            
          </ul>
        </section>
       
        <section class="top_sec">
           <section class="left_sec">
            <h3 class="small">MAIL COMPOSE</h3>
          </section>
        </section>
     	
        <section class="contact_section">
        <label>Select Clients*</label>
        <select id="client_list">
        	<?php foreach($clients as $client){ ?>
            	<option value="<?php echo $client['0']['C']['email'];?>"><?php echo $client['0']['C']['name'];?></option>
            <?php } ?>
        </select>
        
        <label>Subject</label>
        <input type="text" name="subject"/> 
       
      	</section>
        
      </section>