
    <section class="coach_section">
          <form id="searchForm" name="searchForm" method="post" action="">
          <section class="coach_section">

        <fieldset>
        <div class="search_sec">
<?php if(isset($coaches)){?>
       <label>Search by Coach:</label>
<select name="coach_id" class="text">
<option value=''>Select Coach</option>
<option value='0'>Not Applicable</option>
<?php foreach($coaches as $coach)
    echo "<option value='".$coach['Coach']['account_id']."'>".$coach['Coach']['name']."</option>";
?>
</select><br /><br />
<?php }?>
<div style="float:left; width:100%;"><br />
                <label>Search by name:</label>
<input type="text" class="text" name="keyword" style="width:300px; margin-bottom:10px"/>
</div>
<div style="float:left; width:100%; text-align:center" >
          <a href="javascript://" onclick="searchClient()" class="refresh_btn">SEARCH</a>
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