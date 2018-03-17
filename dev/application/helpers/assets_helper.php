<?php

if (!function_exists('asset_url')) {
    function asset_url($asset_name, $asset_type = null)
    {
        $obj = &get_instance();
        $base_url = $obj->config->item('base_url');
        $asset_root = 'assets/';
        $asset_location = $base_url . $asset_root;
        //endif;
        if (is_array($asset_name)) {
            $cachename = md5(serialize($asset_name));
            $asset_location .= 'cache/' . $cachename . '.' . $asset_type;
            if (!is_file($asset_root . 'cache/' . $cachename . '.' . $asset_type)) {
                $out = fopen($asset_root . 'cache/' . $cachename . '.' . $asset_type, "w");
                foreach ($asset_name as $file) {
                    $file_content = file_get_contents($asset_root . $asset_type . '/' . $file);
                    fwrite($out, $file_content);
                }
                fclose($out);
            }
        } else {
            $asset_location .= $asset_type . '/' . $asset_name;
        }
        return $asset_location;
    }
}
if (!function_exists('css_asset')) {
    function css_asset($asset_name, $attributes = array())
    {
        $attribute_str = _parse_asset_html($attributes);
        return '<link href="' . asset_url($asset_name, 'css') . '" rel="stylesheet" type="text/css"' . $attribute_str . ' />';
    }
}

if (!function_exists('js_asset')) {
    function js_asset($asset_name)
    {
        $js = '';
        if (filter_var($asset_name, FILTER_VALIDATE_URL)) {
            $js .= '<script src="' . $asset_name . '" type="text/javascript"></script>';
        } else {
            $js .= '<script type="text/javascript" src="' . asset_url($asset_name, 'js') . '"></script>';
        }
        return $js;
    }
}

if (!function_exists('image_asset')) {
    function image_asset($asset_name, $module_name = '', $attributes = array())
    {
        $attribute_str = _parse_asset_html($attributes);
        return '<img src="' . asset_url($asset_name, 'img') . '"' . $attribute_str . ' />';
    }
}

if (!function_exists('_parse_asset_html')) {
    function _parse_asset_html($attributes = null)
    {
        if (is_array($attributes)):
            $attribute_str = '';
            foreach ($attributes as $key => $value) {
                $attribute_str .= ' ' . $key . '="' . $value . '"';
            }
            return $attribute_str;
        endif;
        return '';
    }
}