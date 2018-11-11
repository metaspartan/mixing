<?php
    $innerText = "Become a partner";
    if ($session["status"] == 3 and $session["data"]["invBalance"] > 0) {
        $innerText = "Invest in BitWhisk";
    }
?>

<div class="footer">
    <div id = "footer-left-block" >
        <div class = "footer-string">
            <a href = "/partner"><?php echo $innerText;?></a>
        </div>
        <div class = "footer-string">
            <a href = "/donation">Donate to us</a>
        </div>
        <div class = "footer-string">
            <a href = "/api/docs">API documentation</a>
        </div>
    </div>
    <div id = "footer-right-block">
        <div class = "footer-string">
            <a href = "https://bitcointalk.org/index.php?topic=3206015.0">Bitcointalk thread</a>
        </div>
        <div class = "footer-string">
            <a href = "http://bitwhiskv7myl5d2.onion">bitwhiskv7myl5d2.onion</a>
        </div>
        <div class = "footer-string">
            <a href = "mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
        </div>
    </div>
    <div id = "footer-center-block" >
        <div class = "footer-string">
            <a href = "/partner"><?php echo $innerText;?></a>
        </div>
        <div class = "footer-string">
            <a href = "/donation">Donate to us</a>
        </div>
        <div class = "footer-string">
            <a href = "/api/docs">API documentation</a>
        </div>
        <div class = "footer-string">
            <a href = "https://bitcointalk.org/index.php?topic=3206015.0">Bitcointalk thread</a>
        </div>
        <div class = "footer-string">
            <a href = "http://bitwhiskv7myl5d2.onion">bitwhiskv7myl5d2.onion</a>
        </div>
        <div class = "footer-string">
            <a href = "mailto:contact@bitwhisk.io">contact@bitwhisk.io</a>
        </div>
    </div>
</div>