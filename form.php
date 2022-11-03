<?php

$root_dir = parse_url(get_home_url())['path'];
if (empty($root_dir))
    $root_dir = '/';

$email = $_POST['email'];

$capturaDominio = preg_replace('!^.+?([^@]+)$!', '$1', $email);

if ($capturaDominio === '456.com') {
    setcookie("ItaipuEnter", 1, time() + 3600, $root_dir);

    if (is_null($_POST['redirect_to'])) {
        redireciona($query = false, get_home_url(null, '?' . md5(rand())));
    } else {
        redireciona($query = false, base64_decode($_POST['redirect_to']));
    }

    redireciona($query = false, base64_decode($_POST['redirect_to']));
} else {
    redireciona(array(
        'msg' => 'Email inválido para acesso', 'redirect_to' => $_POST['redirect_to']
    ));
}

function redireciona($query_arr = array(), $destino = '')
{
    if ($query_arr and count($query_arr) > 0)
        $query = '?' . http_build_query($query_arr);

    header('Cache-Control: no-cache, must-revalidate'); //HTTP 1.1
    header('Pragma: no-cache'); //HTTP 1.0
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Location: ' . $destino . $query);
    die();
}
