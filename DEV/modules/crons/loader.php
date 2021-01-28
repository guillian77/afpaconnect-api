<?php

/**
 * -----------------------------------------------
 * CRON ROUTER
 * -----------------------------------------------
 */

session_start();

/**
 * Define app root
 */
$root = exec('cd ~ && pwd') . "/";

/**
 * Load configuration
 */
require $root . 'web/configuration.php';
$GLOBALS_INI= Configuration::getGlobalsINI();

/**
 * AUTO LOADER
 */
if ( isset($argv[1]) && !empty($argv[1]) )
{
    $path_crons = $GLOBALS_INI["PATH_HOME"] . $GLOBALS_INI["PATH_CLASS"] . "crons/";
    $path_class = $path_crons . $argv[1] . ".php";

    if ( file_exists($path_class) )
    {
        $path_heartbeat = $path_crons . $argv[1] . "_running.txt";

        // Check if process already running
        if ( !file_exists($path_heartbeat) ) {
            /**
             * Create a running file to make an heartbeat status
             */
            $fp = fopen($path_heartbeat,"wb");
            fwrite($fp,"true");
            fclose($fp);

            /**
             * Load and call needed class
             */
            require $path_class;
            $class = ucfirst($argv[1]);

            error_log('----------------');
            error_log('INFO');
            error_log('----------------');
            
            echo '\n';
            echo date('l jS \of F Y h:i:s A');
            echo '\n';
            
            error_log('Load cron class: ' . $class);
            
            new $class();

            /**
             * Delete heartbeat status file
             */
            unlink( $path_heartbeat );

        } else {
            error_log('----------------');
            error_log('WARNING');
            error_log('----------------');
            error_log('Cron process "' . $argv[1] . '" seem to be already running. So do not start it any more.');
        }
    }
    else
    {
        error_log('----------------');
        error_log('ERROR');
        error_log('----------------');
        error_log('404: Can not found cron file "' . $path_class);
    }
}