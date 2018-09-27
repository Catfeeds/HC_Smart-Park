<?php
return array(
    'app_init' =>
        array(),
    'app_begin' =>
        array(
            0 => 'app\\common\\behavior\\Header',
        ),
    'module_init' =>
        array(
            0 => 'app\\common\\behavior\\WebLog',
            1 => 'app\\api\\behavior\\ApiLog',
        ),
    'action_begin' =>
        array(),
    'view_filter' =>
        array(),
    'log_write' =>
        array(),
    'app_end' =>
        array(
            0 => 'app\\admin\\behavior\\Cron',
            1 => 'app\\common\\behavior\\Header',
        ),
);