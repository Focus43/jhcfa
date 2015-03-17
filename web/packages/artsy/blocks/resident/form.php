<?php
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
$form = Loader::helper('form');
?>
<div id="residentForm">
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label>Email</label>
                    <input name="email" type="text" class="form-control" placeholder="" value="<?php echo $email; ?>" />
                </div>
                <div class="form-group col-sm-12">
                    <label>Phone Number</label>
                    <input name="phone" type="text" class="form-control" placeholder="" value="<?php echo $phone; ?>" />
                </div>
                <div class="form-group col-sm-12">
                    <label>Site Url</label>
                    <input name="url" type="text" class="form-control" placeholder="" value="<?php echo $url; ?>" />
                </div>
            </div>
        </div>
        <div class="form-group col-sm-4">
            <label>Logo</label>
            <?php
            $al = Loader::helper('concrete/asset_library');
            $f = File::getByID((int)$logoFileID);
            echo $al->image('logoFileID', 'logoFileID', t('Select an image'), $f);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            <label>Address</label>
<!--            <textarea id="address" rows="4" name="mailingAddress" type="text" class="form-control" placeholder="" value="--><?php //echo $mailingAddress; ?><!--" />-->
            <?php echo $form->textarea("mailingAddress", $mailingAddress, array('rows' => '4')); ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(function() {
        $('#mailingAddress').redactor({
            minHeight: '125',
            'concrete5': {
                filemanager: <?=$fp->canAccessFileManager()?>,
                sitemap: <?=$tp->canAccessSitemap()?>,
                lightbox: true
            },
            'plugins': [
                'fontcolor', 'concrete5', 'underline'
            ]
        });
    });
</script>