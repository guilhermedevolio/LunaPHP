<?php
# Global Functions Must Be Here

use Gui\Mvc\Core\Http\Response;

function response() {
    return (new Response);
}


function dd($val = null) {
    var_dump($val);
    die();
}

