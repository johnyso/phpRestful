<?php
/**
 * Request class.
 *
 * @package api-framework
 * @author  Martin Bean <martin@martinbean.co.uk>
 */
class Request
{
    /**
     * URL elements.
     *
     * @var array
     */
    public $url_elements = array();
    
    /**
     * The HTTP method used.
     *
     * @var string
     */
    public $method;
    
    /**
     * Any parameters sent with the request.
     *
     * @var array
     */
    public $parameters;

    /**
     * URL Elements with id
     *
     * @var array
     */
    public $elements;

    public static function executeStepper($direction, $degree){
        // make execution
            shell_exec("nodeStepper 5000000 " . $degree . " " . $direction ." 42 41 44 43");
    }
}
