<div id="form_section" style="margin:0 0 5px 0; padding:0 1%;">
<span class="select_dele">/ / Contact <strong> Us</strong></span>
<form id="editGPStatusPage" name="editGPStatusPage" method="post" action="" onSubmit="return update_gpstatus_page();">
<input type="hidden" name="ord_id" value="<?php echo $user['GroupGift']['order_id']; ?>"/>
<input type="hidden" name="gp_id" value="<?php echo $user['GroupGift']['id']; ?>"/>
<input type="hidden" id="max_contri_allowed" value="<?php echo $max_contri_allowed; ?>"/>
<div class="comn_box recipient">
            
            <div class="detail_row" style="margin-bottom:50px">
            <p>Want to talk to us?</p>
			
			<span class="contact"><?php echo $this->Html->image('contact.png',array('alt'=>'','escape'=>false,'div'=>false));?>+(91) 85 1000 4444</span>
			<span class="mail"><?php echo $this->Html->image('email.png',array('alt'=>'','escape'=>false,'div'=>false));?><a href="mailto:help@mygyftr.com">help@mygyftr.com</a></span>
			<span class="location"><?php echo $this->Html->image('location.png',array('alt'=>'','escape'=>false,'div'=>false));?>Vouchagram India  Pvt.  Ltd. 2nd Floor, K-17,  Green Park Main New Delhi  110016</span>
			
			<p>But you can always help your self - Frequently Asked Questions</p>
            </div>

			<div class="detail_row last">
			<p>If  you are keen to partner with us as a merchant or want to buy in bulk contact us</p>
			<span class="mail"><?php echo $this->Html->image('email.png',array('alt'=>'','escape'=>false,'div'=>false));?><a href="mailto:arvind@mygyftr.com">arvind@mygyftr.com</a></span>
			<span class="contact"><?php echo $this->Html->image('contact.png',array('alt'=>'','escape'=>false,'div'=>false));?>+(91) 9953080900</span>
			
			</div>
</form>


</div>
