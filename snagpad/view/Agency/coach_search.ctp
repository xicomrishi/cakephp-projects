
    <section class="coach_section">
          <form id="searchForm" name="searchForm" method="post" action="" onSubmit="return searchCoach();">
          <section class="coach_section">

        <fieldset>
        <div class="search_sec">
<div style="float:left; width:100%;"><br />
                <label>Search by name/email:</label>
<input type="text" class="text" name="keyword" id="search_id" value="Name/Email" onblur="if(this.value=='')this.value='Name/Email'" onFocus="if(this.value=='Name/Email')this.value=''"/>
          <a href="javascript://" onclick="searchCoach()" class="refresh_btn" style="margin:0 0 0 13px !important">SEARCH</a>
		  </div>
          </fieldset>
<div id="msg" class="success"></div>
<section id="search_section">
</section>
        </section>
          </form>
         </section>     