<section class="coach_section">

    <div id="error"></div> 
    <form id="AddAgencyForm" name="AddAgencyForm" method="post" action="" style="width:923px; padding:0 0 0 35px">
        <fieldset>
            <input type="text" id="name" name="name" class="input required" value="Name" onfocus="if(this.value=='Name*') this.value='';" onblur="if(this.value=='') this.value='Name';" />
            <input type="text" id="email" name="email" class="input required email" value="Email"  onfocus="if(this.value=='Email*') this.value='';" onblur="if(this.value=='') this.value='Email';" />
            <input type="hidden" name="usertype" value="3" />
           
            <span class="coach_submit" style="padding:20px 0 0 0">
                <input type="submit" value="SAVE" class="submitbtn" onclick="return save_client();"/>

            </span>
        </fieldset>
    </form>
</section>
<script type="text/javascript">
    function save_client(){
        $('#error').hide();
        $("#AddAgencyForm").validate({
            submitHandler: function(form) { 
                var c_name=$('#name').val();
                if(c_name=='Name*')
                {
                    $('#error').html('Please enter agency name.');
                    $('#error').show();
                    return false;
                }
                $.post("<?php echo SITE_URL; ?>/users/createAgency",$('#AddAgencyForm').serialize(),function(data){	
                    if(data=="")
                    {
                        $("#error").html("Agency added successfully");               
                        document.getElementById('AddAgencyForm').reset();
                    }
                    else
                    {
                        $("#error").html("Agency already exists");
                    }
                    $('#error').show();   
                    //show_add_contact();
                });
                return false;
            }
        });
    }
</script>