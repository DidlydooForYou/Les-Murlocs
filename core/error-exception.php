<?php
function customErrorHandler($errno, $errstr, $errfile, $errline) {

    error_log(date('Y-m-d H:i') . " [{$errno}] : $errstr (File : {$errfile}, Line : {$errline})" . PHP_EOL, 3, ERROR_LOG_FILE);
    
    if (REDIRECT_ERROR_PAGE) {
        header('Location: '. ERROR_PAGE);
    }
   

}

function customExceptionHandler(Throwable $exception)
{
    $errno = $exception->getCode();
    $errstr = $exception->getMessage();
    $errfile = $exception->getFile();
    $errline = $exception->getLine();

    error_log(date('Y-m-d H:i') . " [{$errno}] : $errstr (File : {$errfile}, Line : {$errline})" . PHP_EOL, 3, ERROR_LOG_FILE);
    
    if (REDIRECT_ERROR_PAGE) {
        header('Location: '. ERROR_PAGE);
    }

}

function handleFatalError() {

    $last_error = error_get_last();

    if ($last_error && ($last_error['type'] === E_ERROR || $last_error['type'] === E_PARSE || $last_error['type'] === E_CORE_ERROR || $last_error['type'] === E_COMPILE_ERROR)) {
        
        $error_message = "Fatal error: {$last_error['message']} in {$last_error['file']} on line {$last_error['line']}";
        
        error_log($error_message, 3, __DIR__ . '/' . ERROR_LOG_FILE);    

        if (REDIRECT_ERROR_PAGE) {
            header('Location: '. ERROR_PAGE);
        }
        
    }
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

ini_set('log_errors', 1);

ini_set('error_reporting', E_ALL);

CONST ERROR_PAGE = '/erreur.html';

CONST ERROR_LOG_FILE = 'error-log.txt';

const IS_PRODUCTION_ENV = false;
const REDIRECT_ERROR_PAGE = false;

if (IS_PRODUCTION_ENV) {

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);

    set_error_handler('customErrorHandler');

    set_exception_handler('customExceptionHandler');

    register_shutdown_function('handleFatalError');

}

