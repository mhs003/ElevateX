<?php
function render($template, $data = [])
{
    return Module\Pixie::render($template, $data);
}

function redirect($route)
{
    (ROOT_PATH !== '/') ? (new Header())->Location(ROOT_PATH . $route) : (new Header())->Location($route);
}

function getProjectRoot($index_path)
{
    $index_path = removeRight($index_path, '/public');
    return removeLeft($index_path, $_SERVER['DOCUMENT_ROOT']);
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function endsWith($string, $endString)
{
    $mLen = strlen($string);
    $eLen = strlen($endString);
    return (substr($string, $mLen - $eLen) === $endString);
}

function removeLeft($string, $to_remove)
{
    if (startsWith($string, $to_remove)) {
        return substr($string, strlen($to_remove));
    }
}

function removeRight($string, $to_remove)
{
    if (endsWith($string, $to_remove)) {
        return substr($string, 0, strlen($string) - strlen($to_remove));
    }
}