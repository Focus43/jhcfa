<style type="text/css">
    .isotoper {}
    .isotoper [isotope-grid] {width:100%;}
    .isotoper .grid-sizer {width:25%;height:120px;}
    .isotoper .isotope-node {width:25%;height:120px;text-align:center;padding:15px;float:left;display:block;overflow:hidden;}
    .isotoper .isotope-node img {margin:0;padding:0;max-width:100%;max-height:120px;-webkit-filter:grayscale(100%);filter:grayscale(100%);}
</style>

<div class="isotoper" isotope="fitRows"><!-- cellsByColumn -->
    <div isotope-grid>
        <div class="grid-sizer"></div>
        <?php foreach((array)$fileListResults AS $fileObj): ?>
            <a class="isotope-node" href="<?php echo 'test'; ?>">
                <span class="tabular">
                    <span class="cellular">
                        <!-- @todo: remove abs url! -->
                        <img src="<?php echo $fileObj->getRelativePath(); ?>" />
                    </span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

