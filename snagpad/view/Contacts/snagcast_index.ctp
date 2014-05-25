<h3 style="display:inline">SnagCast your Job Search Activity</h3>
<!--span class="delete_btn" style="float:right; width:auto"><a  href="<?php echo SITE_URL.'/img/Sample_Weekly_Contact_Email.png'; ?>" target="_blank" style="width:164px;;">Sample Email</a></span-->
<span class="delete_btn" style="float:right; width:auto"><a  href="javascript://" onClick="loadPopup('<?php echo SITE_URL;?>/contacts/snagcast_info');" style="width:164px;;">What is SnagCast ?</a></span>

<div class="social_links">
<!--<a href="javascript://" onclick="show_facebook_contacts();">Facebook</a>
<a href="javascript://" onclick="show_linkedin_contacts();">Linkedin</a>-->
<a href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oauth_token; ?>">Gmail</a>
<a href="<?php echo $auth_url; ?>">Yahoo</a>
<a href="<?php echo SITE_URL;?>/contacts/hotmail">Hotmail</a>
<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/contacts/send_invite');">Invite Contacts By Email</a>
<a href="javascript://" onclick="loadPopup('<?php echo SITE_URL;?>/contacts/invite_by_bulk_email');">Upload bulk invitees</a>
</div>

<script type="text/javascript">
function show_facebook_contacts()
{
	$('.facebook').show();
	$('.linkedin').hide();
		
}
function show_linkedin_contacts()
{
	$('.linkedin').show();
	$('.facebook').hide();
		
}
</script>