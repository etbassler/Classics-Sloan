
<?php
function google_analytics() { ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128116902-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-128116902-1');
        </script>
    <!-- END Global site tag (gtag.js) - Google Analytics -->
  <?php
  }
  add_action('wp_head', 'google_analytics', 20);
