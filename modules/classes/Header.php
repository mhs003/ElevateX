<?php
class Header
{
    public static function sendNotFound()
    {
        header("HTTP/1.0 404 Not Found");
    }

    public static function badMethod()
    {
        header("HTTP/1.0 405 Method Not Allowed");
    }

    public static function forbidden()
    {
        header("HTTP/1.0 403 Forbidden");
    }

    public static function Location($url)
    {
        header("Location: {$url}");
    }

    public static function sendHeader($name)
    {
        header($name);
    }


    // Send Header Content Types
    public static function contentJson()
    {
        header('Content-Type: application/json');
    }

    public static function contentHtml()
    {
        header('Content-Type: text/html');
    }

    public static function contentText()
    {
        header('Content-Type: text/plain');
    }

    public static function contentCss()
    {
        header('Content-Type: text/css');
    }

    public static function contentJs()
    {
        header('Content-Type: application/javascript');
    }
}