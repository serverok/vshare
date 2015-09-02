<?php

require '../include/classes/User.php';

for ($i=1;$i<10;$i++) {
    echo User::makeSalt() . "\n";
}


