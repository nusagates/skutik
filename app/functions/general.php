<?php
if(!function_exists('get_title')){
    function get_title($title=''){
        if(empty($title))return config('app.name');
        return $title." - ".config('app.name');
    }
}
