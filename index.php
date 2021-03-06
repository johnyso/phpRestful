<?php
/**
 * 
 * @package phpRestful
 * @author  Jonathan Sommer
 */

/**
 * autoLoader for added classes
 * 
 * @param string $class_name
 */
function autoload_class($class_name) {
    $directories = array(
        'classes/',
        'classes/controllers/',
        'classes/models/'
    );
    foreach ($directories as $directory) {
        $filename = $directory . $class_name . '.php';
        if (is_file($filename)) {
            require($filename);
            break;
        }
    }
}

/**
 * Register autoloader functions.
 */
spl_autoload_register('autoload_class');

/**
 * Parse the incoming request.
 */
$request = new Request();
if (isset($_SERVER['PATH_INFO'])) {
    $request->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    foreach ($request->url_elements as $key => $element){
        $request->elements[$key] = explode('-', trim($element, '-'));
    }
}

$request->method = strtoupper($_SERVER['REQUEST_METHOD']);
switch ($request->method) {
    case 'GET':
        $request->parameters = $_GET;
    break;
    case 'POST':
        $request->parameters = $_POST;
    break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $request->parameters);
    break;
}

/**
 * Route the request.
 */
if (!empty($request->elements)) {

    foreach ($request->elements as $key => $element) {
        $controller_name = ucfirst($element[0]) . 'Controller';
        if (! class_exists($controller_name)) {
            header('HTTP/1.1 404 Not Found');
            $response_str = 'Unknown request: ' . $element[0];
        }
        $countElements = $key;
    }
    $controller_name = ucfirst($request->elements[0][0]) . 'Controller';
    if (class_exists($controller_name)) {
        $controller = new $controller_name;
        $action_name = strtolower($request->method);
        $response_str = call_user_func_array(array($controller, $action_name), array($request));
    }
}
else {
    $response_str = 'Unknown request';
}

/**
 * Send the response to the client.
 */
$response_obj = Response::create($response_str, $_SERVER['HTTP_ACCEPT']);
echo $response_obj->render();