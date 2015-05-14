<div accordion data-speed="0.25">
    <?php foreach($dataFields AS $index => $pair): ?>
        <div class="group <?php echo ($index === 0) ? 'active' : ''; ?>">
            <div class="accordion-header"><?php echo $pair->heading; ?></div>
            <div class="accordion-body">
                <?php echo $this->controller->_translateFrom($pair->body); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>