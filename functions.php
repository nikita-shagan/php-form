<?php

function get_new_token() {
    $new_token = bin2hex(random_bytes(32));
    return $new_token;
}
