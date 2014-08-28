<?php $current=$this->Session->read('Client.profile_step'); ?>
<li class="<?php if($current=='1'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('1')">1</a></li>
<li class="<?php if($current=='2'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('2')">2</a></li>
<li class="<?php if($current=='3'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('3')">3</a></li>
<li class="<?php if($current=='4'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('4')">4</a></li>
<li class="<?php if($current=='5'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('5')">5</a></li>
<li class="<?php if($current=='6'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('6')">6</a></li>
<li class="<?php if($current=='7'){ echo 'active'; } ?>"><a href="javascript://" onclick="step('7')">7</a></li>