<div id="jsb_CardPopup"></div>
<div id="background_CardPopup"></div>
<section class="content_left">
  <ul>
  <li><strong>GOAL</strong><p><?php echo $goal;?></p></li>
  <li><strong>TIP</strong><p><?php echo $description['Config']['value'];?></p></li>
  </ul>
  <?php if($c_col!='J'){ ?>
  <a  href="javascript://"  onclick="save_checklist('<?php echo $card_id;?>','<?php echo $c_col;?>','<?php echo $move_action;?>');" class="blue_btn"><?php echo $this->Html->image('btn_left_curv.png',array('escape'=>false,'div'=>false));?><span><?php echo $move_button_text;?></span><?php echo $this->Html->image('btn_right_curv.png',array('escape'=>false,'div'=>false));?></a> 
  <?php } ?>
  
  </section>
  
  <section class="content_right">
  <h3>Choose your strategies for <strong><?php echo $current_column; ?>:</strong></h3>
 
 
<div class="nano">

  <ul class="strategies_list">
  <?php foreach($checklists as $check) { 
   if($check['CH']['type']!='9') { ?>
   <li><a class="<?php if($check['CCH']['status']=='1'){echo 'done';}?>" <?php if($check['CCH']['status']!='1'){ ?>onclick="show_skills('<?php echo $card['Card']['id'];?>','<?php echo $check['CH']['id'];?>','<?php echo $check['CH']['type'];?>');" <?php } ?>><?php echo $this->Html->image('qus_icon.png',array('escape'=>false,'div'=>false,'class'=>'qus_icon'));?><small><?php echo $check['CH']['title'];?></small><?php echo $this->Html->image('tick.png',array('escape'=>false,'div'=>false,'class'=>'tick'));  ?></a></li>
    <?php } } ?>
   
  </ul>
 </div>

  </section>