<div style='height:218px; overflow:auto; margin-top:5px;background-color: #47A7C7;'>
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div id="lyr1" >
                    <p align="left" style="margin:0px;font-size:16px; line-height:18px; color:#fff; font-family:Arial, Helvetica, sans-serif" ><span style="display:inline-block; height:31px; vertical-align:middle"><img src="<?php echo SITE_URL; ?>/img/pop_up_logo.jpg"></span><small style="font-size:15px; padding:6px 0  0 10px">Job Card Basket</small></p>
                    <?php if ($count == '0') { ?>

                        <table width='100%' cellpadding='5' cellspacing='2' border='0'>
                            <?php for ($k = 1; $k <= 3; $k++) { ?>
                                <tr>
                                    <?php for ($j = 0; $j < 9; $j++) { ?>
                                        <td align="center" style="margin-left:15px;background-image: url('<?php echo SITE_URL; ?>/img/white_box.png'); background-repeat:no-repeat; width:50px; height:54px;background-position: center ;">&nbsp;</span></td>
                                    <?php } ?> 
                                </tr>
                            <?php } ?>

                        </table>
                    <?php } else { ?>
                        <table width='100%' cellpadding='5' cellspacing='2' border='0'>
                            <?php
                            $i = 0;
                            $k = 0;
                            foreach ($cards as $rowfetch) {
                                $k++;
                                if ($i % 9 == 0) { ?>
                                    <tr> <?php  }  $i++; ?>
                                    <td align="center" title="<?php echo $rowfetch['Basket']['company_name']; ?>" style="background-image: url('<?php echo SITE_URL; ?>/img/box_img.png'); background-repeat:no-repeat; cursor:hand; background-position:center; width:50px; height:54px;"><span style="color:#FFF;" title="<?php echo $rowfetch['Basket']['company_name']; ?>"><?php echo $k; ?> <br> <a href="javascript://" onclick="setLink('<?php echo $rowfetch['Basket']['id']; ?>')" style="font-size:9px;color:#fff">Remove</a>
                                        </span></td>
                                    <?php if ($i + 1 % 9 == 0) { ?>  </tr>
                                    <?php
                                }
                            }
                                if ($i % 9 != 0) {
                                    for ($j = $i; $j % 9 != 0; $j++) {
                                        ?>
                                        <td align="center" style="margin-left:15px;background-image: url('<?php echo SITE_URL; ?>/img/white_box.png'); background-repeat:no-repeat; width:50px; height:54px;background-position: center center;">&nbsp;</span></td>
                                    <?php } ?>
                                    </tr>
                                    <?php
                                }
                                if ($i <= 9)
                                    $p = 1;
                                else if ($i <= 18)
                                    $p = 2;
                                else if ($i <= 27)
                                    $p = 3;

                                for ($k = $p; $k <= 2; $k++) {
                                    ?>
                                    <tr>
                                        <?php for ($j = 0; $j < 9; $j++) { ?>
                                            <td align="center" style="margin-left:15px;background-image: url('<?php echo SITE_URL; ?>/img/white_box.png'); background-repeat:no-repeat; width:50px; height:54px;background-position: center center;">&nbsp;</span></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </table>
                        
                    <?php } ?>
                    </div></td></tr></table>

    </div>
    <?php if ($count != '0') { ?>
        <p align="center" style="margin-top:10px;"><span><a href="javascript://" onclick="basketransfer()" class="transfre_card">Transfer to Snagpad</a></span></p>
    <?php }
 ?>
        