<?php
$link = 'https://www.onekingslane.comp/4325152-12-light-lotus-flower-chandelier?sales_event_id=63336';
$link = preg_replace('@^$domain@i', '$domain/', $link);
$link = preg_replace('@^$domain//@i', '$domain/', $link);
echo $link;
?>