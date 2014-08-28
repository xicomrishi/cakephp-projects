<?php
$this->Paginator->options(array(
    'url' => $this->data,
    'update' => '#search_section',
    'evalScripts' => true,
));



if (is_array($rows) && count($rows) > 0) {
    ?>
    <input type="hidden" name="release" value="" id="release" />
    <section class="heading_row">

        <span class="mail" style="width:400px"><?php echo $this->Paginator->sort('Content.title', 'Title'); ?></span>
        <span class="coln4"><?php echo $this->Paginator->sort('Content.date_modified', 'Date Modified'); ?></span>

    </section>

    <?php foreach ($rows as $row) { ?>
        <section class="cmn_row">
            <span class="mail" style="width:400px"><a href="javascript://" onclick="show_add(<?php echo $row['Content']['id']; ?>)"><?php echo $row['Content']['title']; ?></a></span>
            <span class="coln4 color"><?php echo show_formatted_date($row['Content']['date_modified']); ?></span>
        </section>
    <?php } ?>
    <div class="paging">
        <?php
        echo $this->Paginator->numbers(array('separator' => ''));
        ?>
    </div>

<?php } else { ?>
    <div style="text-align: center; width:100%; padding:30px 0 0 0; float:left; font-size:18px; line-height:20px; color:#757575;font-family:'onduititc'; font-weight:normal">No record found</div>
<?php } ?>
<?php echo $this->Js->writeBuffer(); ?>       
