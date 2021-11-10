<?php
    $conn = pg_connect('localhost', 'root', '', 'atn')
            or die ("Can not connect database".pg_connect_error());
?>