
<section class="coach_section">
          <form id="searchForm" name="searchForm" method="post" action="">
		  <?php if(isset($employer)) echo "<input type='hidden' name='employer' value='1'>";?>
          <section class="coach_section">

        <fieldset>
        <div class="search_sec">
                <label  style="min-width:200px">Search by Company Name:</label>
<input id="search_id" type="text" class="text" value="Company Name" name="search_company" onblur="if(this.value=='')this.value='Company Name'" onFocus="if(this.value=='Company Name')this.value=''"/><br><br>
<div style="float:left; width:100%;">
<br>
                <label style="min-width:200px">Search by Position Available:</label>
<input id="search_id1" type="text" class="text" value="Position Available" name="search_position" onblur="if(this.value=='')this.value='Position Available'" onFocus="if(this.value=='Position Available')this.value=''"/>
</div>
<div style="float:left; width:100%; text-align:center">
          <a href="javascript://" onclick="searchCard()" class="refresh_btn" style="float:none; margin:10px 0 0 0px">Search</a>
</div>		  
          </fieldset>

<section id="search_section">
</section>
        </section>
          </form>
         </section>     