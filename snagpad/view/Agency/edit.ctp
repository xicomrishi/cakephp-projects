<section class="top_sec pad2">
    <section class="left_sec">
        <h3 class="small">Add Client</h3>
    </section>

</section>
<section class="coach_section">

    <div id="error"></div> 
    <form id="AddClientForm" name="AddClientForm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <fieldset>
            <input type="text" id="name" name="name" class="input" value="Name" onfocus="if(this.value=='Name') this.value='';" onblur="if(this.value=='') this.value='Name';" />
            <input type="text" id="email" name="email" class="input required email" value="Email"  onfocus="if(this.value=='Email') this.value='';" onblur="if(this.value=='') this.value='Email';" />
            <input type="hidden" name="usertype" value="3" />
            <div class="help">If you want to connect the client's account to the Facebook app, use the same email as the client uses for their Facebook account.</div>
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
                    $('#error').html('Please enter name.');
					$("#error").removeClass('success');
                    $('#error').show();
                    return false;
                }
                $.post("<?php echo SITE_URL; ?>/users/createAccount",$('#AddClientForm').serialize(),function(data){	
                    if(data=="")
                    {
                        $("#error").html("Client has been added successfully"); 
						$("#error").addClass('success');              
						show_search();
                       // document.getElementById('AddClientForm').reset();
                    }
                    else
                    {   
					    $("#error").removeClass('success');
                        $("#error").html("Client already exists");
                    }
                    $('#error').show();   
                    //show_add_contact();
                });
                return false;
            }
        });
    }
</script>