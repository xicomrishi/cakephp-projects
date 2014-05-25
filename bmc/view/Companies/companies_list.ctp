<table class="table none1">
        <thead>
        <tr>
        <th class="center"><?php echo __('S.No.'); ?></th>
        <th class="center"><?php echo __('Company Name'); ?></th>
        <th class="center"><?php echo __('# of Participant'); ?></th>

        </tr>
        </thead>        
            <tbody>
            <?php $i=1; foreach($companies as $comp){ ?>
                <tr class="<?php if($i%2==0) echo ' even'; else echo ' odd'; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $comp['company_name']; ?></td>
                    <td><?php echo count($comp['user']); ?></td>
                </tr> 
            <?php $i++; } ?>        
            </tbody>
        </table>