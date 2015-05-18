<style type="text/css">
    .grid4max {font-size:0;line-height:0;}
    .grid4max .item {display:inline-block;width:48%;margin:1% 1%;padding-bottom:20%;background-repeat:no-repeat;background-size:contain;background-position:50% 50%;}

    @media screen and (min-width:800px){
        .grid4max .item {width:23%;margin:1% 1%;padding-bottom:20%;}
    }
</style>

<div class="grid4max">
    <?php foreach((array)$fileListResults AS $fileObj){ if( is_object($fileObj) ){ ?>
        <div class="item" style="background-image:url('<?php echo $fileObj->getThumbnailURL('file_manager_detail'); ?>');"></div>
    <?php } } ?>
</div>
