<section class="top_sec pad2">
    <section class="left_sec">
        <h3 class="small">Add Client</h3>
    </section>

</section>
<section class="coach_section">

    <div id="error"></div> 
    <form id="AddClientForm" name="AddClientForm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <fieldset>
            <input type="text" id="name" name="name" class="input required" value="Name" onfocus="if(this.value=='Name') this.value='';" onblur="if(this.value=='') this.value='Name';" />
            <input type="text" id="email" name="email" class="input required email" value="Email"  onfocus="if(this.value=='Email') this.value='';" onblur="if(this.value=='') this.value='Email';" />
            <input type="hidden" name="usertype" value="3" />
            <div class="help">When you click the save button an email will be sent to the client providing them with their username and password.</div>
            <span class="coach_submit">
                <input type="submit" value="SAVE" class="submitbtn" onclick="return save_client();"/>

            </span>
        </fieldset>
    </form>
</section>
<script type="text/javascript">
    function save_client(){
        $('#error').hide();
        $("#AddClientForm").validate({
            submitHandler: function(form) { 
                var c_name=$('#name').val();
                if(c_name=='Name')
                {
                    $('#error').html('Please enter client(s) name.');
					$('#error').removeClass('success');
                    $('#error').show();
                    return false;
                }
                $.post("<?php echo SITE_URL; ?>/users/createAccount",$('#AddClientForm').serialize(),function(data){	
                    if(data=="")
                    {
                       show_search();
					    //$('#error').addClass('success');
						//$("#error").html("Client has been added successfully");              
                        //document.getElementById('AddClientForm').reset();
                    }
                    else
                    {
                        $("#error").html("Client already exists");
						$('#error').removeClass('success');
                    }
                    $('#error').show();   
                    //show_add_contact();
                });
                return false;
            }
        });
    }
</script>