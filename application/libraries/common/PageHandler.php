<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageHandler
{
    const WEBPAGE_COOKIE = 'PAGE_URI';
    const COOKIE = 'cookie';

    public static function redirectToPreviousPageIfNotEmpty()
    {
        $the_url = self::getPreviousPage();
        $current_url = uri_string();
        if (!empty($the_url) && !empty($current_url) && ($current_url != $the_url)) {
            self::setCurrentPage();
            redirect(base_url($the_url));
        }
    }

    public static function setCurrentPage()
    {
        $CI = get_instance();
        $CI->load->helper(self::COOKIE);
        $cookie = array(
            'name'   => self::WEBPAGE_COOKIE,
            'value'  => uri_string(),
            'expire' => '3600',
            'domain' => '[::1]',
            'path'   => '',
            'secure' => false
        );
        $CI->input->set_cookie($cookie);
    }

    public static function getPreviousPage() : string
    {
        $CI = get_instance();
        $CI->load->helper('cookie');
        $page = $CI->input->cookie(self::WEBPAGE_COOKIE,true);
        $page = empty($page) || !is_string($page) ? BLANK : $page;
        return $page;
    }
}
