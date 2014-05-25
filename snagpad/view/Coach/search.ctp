
          
        </section>
<section class="coach_section">
          <form id="searchForm" name="searchForm" method="post" action="">
          <section class="coach_section">

        <fieldset>
        <div class="search_sec">
		 <label>Search by name:</label>
			<input type="text" class="text" name="keyword"/>
          <input type="checkbox" name="status_chk" value="1" class="check"><label> Filter Clients for</label>
          <input type="radio" name="activity" value="1" class="radio_btn"><label> <?php echo $this->Html->image('red.png',array('escape'=>false,'div'=>false));?></label>
          <input type="radio" name="activity" value="2" class="radio_btn"> <label><?php echo $this->Html->image('yellow.png',array('escape'=>false,'div'=>false));?></label>
          <input type="radio" name="activity" value="3" class="radio_btn"> <label><?php echo $this->Html->image('green.png',array('escape'=>false,'div'=>false));?></label>
	       
<div style="float:left; width:100%; text-align:center; padding:10px 0 0 0" >
          <a href="javascript://" onclick="searchClient()" class="refresh_btn">REFRESH DASHBOARD</a>
		  </div>
          </fieldset>
        <input type="hidden" id="current_page" name="current_page" value=""/>
        <input type="hidden" id="show_per_page" name="show_per_page" value=""/>
<div id="msg"></div>
<section id="search_section">
</section>
        </section>
          </form>
         </section>     