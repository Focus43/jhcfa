<?php
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
?>

<style type="text/css">
    #accordionForm .item-pair {position:relative;padding:8px;margin-bottom:12px;background:#f1f1f1;}
    #accordionForm .item-pair input[type="text"]{height:auto;padding:8px;font-size:14px;width:100%;margin-bottom:8px;}
    #accordionForm .item-pair textarea {width:100%;}
    #accordionForm .item-pair [remove] {position:absolute;top:0;right:0;}
    #accordionForm [clonable] {display:none;}
</style>

<div id="accordionForm">
    <div class="accordion-items">
        <?php foreach($dataFields AS $pair): ?>
            <div class="item-pair">
                <input type="text" name="heading[]" placeholder="Section Name" value="<?php echo $pair->heading; ?>" />
                <textarea name="body[]" class="redactor-editor"><?php echo $this->controller->_translateFromEditMode($pair->body); ?></textarea>
                <button remove class="btn btn-danger btn-xs">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button add type="button" class="btn btn-block btn-default">Add Section</button>

    <!-- clonable element -->
    <div class="item-pair" clonable>
        <input type="text" name="heading[]" placeholder="Section Name" />
        <textarea name="body[]" class="redactor-editor"></textarea>
        <button remove type="button" class="btn btn-danger btn-xs">Remove</button>
    </div>
</div>

<script type="text/javascript">
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Loader::helper('validation/token')->generate('editor'); ?>";

    $(function() {
        var $container      = $('#accordionForm'),
            $clonable       = $('.item-pair[clonable]', $container),
            $itemsContainer = $('.accordion-items', $container);

        /**
         * Initialize editors. Looks at the parent '.item-pair' <div> to see
         * if .data('initd') is true, and if NOT, initializes.
         * @private
         */
        function _initEditors(){
            $('.item-pair', $itemsContainer).each(function(index, item){
                var $elem = $(item);
                if( ! $elem.data('initd') ){
                    $('.redactor-editor', $elem).redactor({
                        minHeight: '175',
                        'concrete5': {
                            filemanager: <?=$fp->canAccessFileManager()?>,
                            sitemap: <?=$tp->canAccessSitemap()?>,
                            lightbox: true
                        },
                        'plugins': [
                            'fontcolor', 'concrete5', 'underline'
                        ]
                    });
                    $elem.data('initd', true);
                }
            });
        }

        $container.on('click', '[add]', function(){
            var $clone = $clonable.clone().removeAttr('clonable');
            $itemsContainer.append($clone);
            _initEditors();
        });

        $container.on('click', '[remove]', function(){
            $(this).parent('.item-pair').remove();
        });

        _initEditors();
    });
</script>