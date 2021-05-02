<?php
namespace Kus\Url;

class UrlHelper{
    public static function getBaseUrl(){
        return rtrim(
                sprintf(
                "%s://%s%s",
                isset($_SERVER['HTTPS']) && 
                $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['SERVER_NAME'],
                str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']) 
                ),
             '?');
    }
    
}
