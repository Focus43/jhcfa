<?php $instanceId = mt_rand(); ?>

<div id="staff-images-<?php echo $instanceId; ?>" class="staff-list">
    <?php foreach((array)$fileListResults AS $fileObj): ?>
        <?php $altPhoto = $fileObj->getAttribute('alt_photo'); $altPhotoPath = is_object($altPhoto) ? $altPhoto->getThumbnailURL('event_thumb') : ""; ?>
        <div class="staff-member" style="background-image:url('<?php echo $fileObj->getThumbnailURL('event_thumb'); ?>');"<?php echo ($altPhotoPath != "") ? 'data-alt-photo="'.$altPhotoPath.'"' : ''; ?>>
            <span class="details">
                <span class="name"><?php echo $fileObj->getTitle(); ?></span>
                <span class="descr"><?php echo $fileObj->getDescription(); ?></span>
            </span>
            <?php
                $email = $fileObj->getAttribute('email_address');
                if( !empty($email) ){ ?>
                    <a class="mail" href="mailto:<?php echo $email; ?>"><i class="icon-mail2"></i></a>
            <?php } ?>
        </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
  (function() { // wrap in an IIFE to reduce conflicts with global scope
    var $parentNode = document.querySelector('#staff-images-<?php echo $instanceId; ?>');
    var $altPhotos  = $parentNode.querySelectorAll('[data-alt-photo]');
    var iterable = Array.prototype.slice.call($altPhotos);
    iterable.forEach(bindRollover);

    function bindRollover(node) {
      var origSrc = node.style.backgroundImage;
      var rollSrc = node.getAttribute('data-alt-photo');
      node.addEventListener('mouseenter', function() {
        node.style.backgroundImage = 'url("' + rollSrc + '")';
      });
      node.addEventListener('mouseleave', function() {
        node.style.backgroundImage = origSrc;
      });
      // preload the image so the rollovers are, hopefully, ready at interaction
      (new Image()).src = rollSrc;
    }
  })();
</script>