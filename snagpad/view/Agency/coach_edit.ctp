<section class="top_sec pad2">
    <section class="left_sec">
        <h3 class="small">Add Coach</h3>
    </section>

</section>
<section class="coach_section">

    <div id="msg1" class="success" style="display:none">Coach Added Successfully.</div> 
    <div id="err1" class="error" style="display:none">Coach already exists.</div>
    <form id="AddClientForm" name="AddClientForm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <fieldset>
            <input type="text" id="name" name="name" class="input required" value="Name" onfocus="if(this.value=='Name') this.value='';" onblur="if(this.value=='') this.value='Name';" />
            <input type="text" id="email" name="email" class="input required email" value="Email"  onfocus="if(this.value=='Email') this.value='';" onblur="if(this.value=='') this.value='Email';" />
            <input type="hidden" name="usertype" value="2" />
            <span class="txt">When you click the save button an email will be sent to the coach providing them with their username and password.</span>
            <span class="coach_submit">
                <input type="submit" value="SAVE" class="submitbtn" onclick="return save_coach();"/>

            </span>
        </fieldset>
    </form>
</section>
<script type="text/javascript">
    function save_coach(){
        $('#msg1').hide();
		$('#err1').hide()
        $("#AddClientForm").validate({
            submitHandler: function(form) { 
                var c_name=$('#name').val();
                if(c_name=='Name')
                {
                    $('#err1').html('Please enter coach\'s name.');
                    $('#err1').show();
                    return false;
                }
                $.post("<?php echo SITE_URL; ?>/users/createAccount/2",$('#AddClientForm').serialize(),function(data){	
                    if(data=="" || data=="1")
                    {
                        $("#msg1").show();
                        show_search();
                    }
                    else
                    {
						$('#err1').show();
                    }

                });
                return false;
            }
        });
    }
</script>