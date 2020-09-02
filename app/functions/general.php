<?php
if(!function_exists('set_title')){
    function set_title($title=''){
        if(empty($title))return config('app.name');
        return $title." - ".config('app.name');
    }
}
