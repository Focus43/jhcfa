<?php

$ephemeralStashCacheDriver = array(
    'class' => '\Stash\Driver\Ephemeral',
    'options' => array()
);

$redisStashCacheDriver = array(
    'class' => '\Stash\Driver\Redis',
    'options' => array(
        'servers' => array(
            array(
                'server' => $_SERVER['CACHE1_HOST'],
                'port'   => $_SERVER['CACHE1_PORT']
            )
        )
    )
);

$trackingCode = <<<EOT
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-21129410-1', 'auto');
  ga('send', 'pageview');
</script>
EOT;

return array(
    'maintenance_mode' => false,
    'site' => 'Center for the Arts',
    'seo' => array(
        'url_rewriting' => true,
        'url_rewriting_all' => true,
        'tracking' => array(
            'code' => $trackingCode
        )
    ),
    'sitemap_xml' => array(
        'file' => 'application/files/sitemap.xml',
        'frequency' => 'weekly',
        'priority' => 0.5,
        'base_url' => BASE_URL
    ),
    'permissions' => array(
        'model' => 'advanced'
    ),
    'marketplace' => array(
        'enabled' => false
    ),
    'external' => array(
        'intelligent_search_help' => false,
        'news_overlay' => false,
        'news' => false
    ),
    'misc'  => array(
        'seen_introduction' => true
    ),
    'debug' => array(
        'detail' => 'message' // debug|message
    )
    ,'cache' => array(
        'pages' => 'all',
        'levels' => array(
            'expensive' => array(
                'drivers' => array(
                    $ephemeralStashCacheDriver,
                    (defined('EPHEMERAL_ONLY_DURING_INSTALL') ? $ephemeralStashCacheDriver : $redisStashCacheDriver)
                )
            ),
            'object' => array(
                'drivers' => array(
                    $ephemeralStashCacheDriver
                )
            )
        )
    )
);