<?php $current=$this->Session->read('Client.profile_step');
$firstTime=$this->Session->read('Client.firstTime'); 
$profile=$this->Session->read('Client.profile_validate');?>
<li class="<?php if($current=='1'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?> onclick="step('1')" <?php } ?>>1</a></li>
<li class="<?php if($current=='2'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?>onclick="step('2')"<?php } ?>>2</a></li>
<li class="<?php if($current=='3'){ echo 'active'; } ?>"><a href="javascript://"<?php if($firstTime!='1' && $profile!='0' ) { ?> onclick="step('3')"<?php } ?>>3</a></li>
<li class="<?php if($current=='4'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?>onclick="step('4')"<?php } ?>>4</a></li>
<li class="<?php if($current=='5'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?>onclick="step('5')"<?php } ?>>5</a></li>
<li class="<?php if($current=='6'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?>onclick="step('6')"<?php } ?>>6</a></li>
<li class="<?php if($current=='7'){ echo 'active'; } ?>"><a href="javascript://" <?php if($firstTime!='1' && $profile!='0' ) { ?>onclick="step('7')"<?php } ?>>7</a></li>