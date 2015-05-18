<div class="box-office-top">
    <?php
        /** @var $a \Concrete\Core\Area\Area */
        $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
        $a->enableGridContainer();
        $a->display($c);
    ?>
</div>

<div class="quads">
    <div class="quad">
        <?php $a = new Area('Quad 1'); $a->display($c); ?>
    </div>
    <div class="quad">
        <?php $a = new Area('Quad 2'); $a->display($c); ?>
    </div>
    <div class="quad">
        <?php $a = new Area('Quad 3'); $a->display($c); ?>
    </div>
    <div class="quad">
        <?php $a = new Area('Quad 4'); $a->display($c); ?>
    </div>
</div>