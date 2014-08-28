<html>
    <head>
    <?php echo $this->Html->css('plugin');?>
        
        <?php echo $this->Html->script(array('jquery', 'jquery.validate.min', 'dw_event', 'dw_scroll', 'dw_scrollbar', 'scroll_controls')); ?>

        <script type='text/javascript'>
            //<![CDATA[
            var oldheight = window.innerHeight;
            $(document).ready(function(){
                $('#submitbutton').click(function(){
                    console.log('clicked add');
                    $('.bookmarklet_wrapper').fadeOut(500, function(){
                        $('.done').fadeIn(500);
                    });
                    window.parent.postMessage("JobAdded", "*");
        
                });
            });
            //]]>
        </script>
    </script>
</head>
<body onResize="if(window.innerHeight != oldheight){oldheight = window.innerHeight;sub = document.getElementById('submitbutton');sub.className = (sub.className == 'lower' ? '' : 'lower'); console.log(sub)}" >
    <div align="center" class="bookmarklet_wrapper">
        <form method="post" name="_jsbadd" id="_jsbadd">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr><td class="header">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td class="logo"><?php echo $this->Html->image("logo.png", array('alt' => 'Snagpad', 'border' => '0', 'align' => 'middle', 'title' => 'Sngapad')); ?></td>
                                <td><p class="text"><strong><i>Review fields and click Add to Job Card Basket. When done searching click Transfer to SnagPad.</i></strong></p>
                                </td>
                                <td><p class="text" id="logout"><?php if ($this->Session->read('Client.Client.id')) { ?><a href="javascript://" onClick="Logout();" style="color:#134E68;text-decoration:none"><strong>Logout</strong></a> (<?php echo $this->Session->read('Client.Client.name'); ?>)<?php } ?></p></td>
                            </tr></table>
                    </td></tr>
                <tr><td class="mid" align="center" height="292" id='snag_main'>  
                        <?php echo $this->fetch('content'); ?> 

                    </td></tr><tr><td class="footer"> 
                        <input type="hidden" name="usertype" value="3" />

                        <input type="hidden" name="act" value="add_basket" />
                        <input type="hidden" name="escaped_content" value="<?php echo $_POST['escaped_content']; ?>" />
                        <input type="hidden" name="job_url" value="<?php echo $_POST['url']; ?>" />
                        <input type="hidden" name="url" value="<?php echo $_POST['url']; ?>" />
                    </td></tr></table></form></div> 

    <script type="text/javascript">
        site_url="<?php echo SITE_URL; ?>";
        function submitDescription()
        {
            var title = document.getElementById('job_title').value;
            var company = document.getElementById('company_name').value;
            if(title == "Data not found. Enter manually." || company == "Data not found. Enter manually.") {
                alert('Company name and Job Title must not be empty');
            }
            else
            {
                $('#progressImg').show();
                frmval=$('#_jsbadd').serialize();
                $.post('<?php echo SITE_URL; ?>/Snagplugin/add_card/',frmval,function(p){
                    fillBasket();
                    $('#job_title').val('Data not found. Enter manually.');$('#company_name').val('Data not found. Enter manually.');$('#description').val('Data not found. Enter manually.');$('#notes').val('Enter your notes about the job opportunity here');$('#contact_email').val('Data not found. Enter manually.');
                });

            }
        }

        function setLink(id)
        {
            $('#msg').html('');
            var a=confirm("Are you sure to delete this card from your basket?");
            if(a)
            {
                $('#progressImg').show();
                $.post('<?php echo SITE_URL; ?>/Snagplugin/delete_card/'+id,'',function(p){				
                    $('#msg').html('Card has been deleted successfully from your basket');
                    fillBasket();
                });
			
            }
        }	
        function basketransfer() {
            jsb_token=$('#token').val();
            $('#progressImg').show();$('#msg').html('');
            $.post('<?php echo SITE_URL; ?>/Snagplugin/transfer','',function(p){
                fillBasket();
                window.open("<?php echo SITE_URL; ?>/Jobcards/index");
            });

        }
<?php if (isset($arr['job_detail']) && $arr['job_detail'] == '') { ?>
            window.frames['jsb_content_iframe'].document.location.href='<?php echo $url; ?>';
            $(window).load(function(){
                $('#jsb_content_iframe').contents().find('a').click(function(event) {
                    event.preventDefault();
                }); 
            });
<?php } ?>
        function Logout()
        {
            $.post('<?php echo SITE_URL; ?>/users/logout','act=logout',function(data){		
                $('#logout').html("");
            });
        }
    </script>
</body>
</html>