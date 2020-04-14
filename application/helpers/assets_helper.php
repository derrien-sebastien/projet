<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
if ( ! function_exists('css_url'))
{
    function css_url($nom)
    {
        return base_url() . 'assets/css/' . $nom . '.css';
    }
}

if ( ! function_exists('distcss_url'))
{
    function distcss_url($nom)
    {
        return base_url() . 'assets/dist/' . $nom . '.css';
    }
}

if ( ! function_exists('distjs_url'))
{
    function distjs_url($nom)
    {
        return base_url() . 'assets/dist/' . $nom . '.js';
    }
}
  
if ( ! function_exists('js_url'))
{
    function js_url($nom)
    {
        return base_url() . 'assets/javascript/' . $nom . '.js';
    }
}
  
if ( ! function_exists('img_url'))
{
    function img_url($nom)
    {
        return base_url() . 'assets/images/' . $nom;
    }
}
  
if ( ! function_exists('img'))
{
    function img($nom, $alt = '')
    {
        return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
    }
}