<?php
class Router {
    protected $base_path;
    protected $request_uri;
    protected $requst_method;
    protected $http_methods = array('get', 'post', 'put', 'patch', 'delete');
    protected $wild_cards = array('int' => '/^[0-9]+$/', 'any' => '/^[0-9A-Za-z]+$/');

    function __construct($base_path = '') {
        $this->base_path = $base_path;

        // Remove Query string and trim trailing slash
        $this->request_uri = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        $this->requst_method = $this->_determine_http_method();
    }

    private function _determine_http_method() {
        $method = strtolower($_SERVER['REQUEST_URI']);

        if (in_array($method, $this->http_methods)) return $method;
        return 'get';
    }

    public function respond($method, $route, $callable) {
        $method = strtolower($method);
        
        if ($route == '/') $route = $this->base_path;
        else $route = $this->base_path . $route;

        $matches = $this->_match_wild_cards($route);

        if (is_array($matches) && $method == $this->requst_method) {
            call_user_func_array($callable, $matches);
        }
    }

    private function _match_wild_cards($route) {
        $variables = array();
        
        $exp_request = explode('/', $this->request_uri);
        $exp_route = explode('/', $route);

        if (count($exp_request) == count($exp_route)) {
            foreach ($exp_route as $key => $value) {
                if ($value == $exp_request[$key]) {
                    continue; // Routes matching so far.
                } elseif ($value[0] == '(' && substr($value, -1) == ')') {
                    $strip = str_replace(array('(', ')'), '', $value);
                    $exp = explode(':', $strip);

                    if (array_key_exists($exp[0], $this->wild_cards)) {
                        $pattern = $this->wild_cards[$exp[0]];

                        if (preg_match($pattern, $exp_request[$key])) {
                            if (isset($exp[1])) {
                                $variables[$exp[1]] = $exp_request[$key];
                            }

                            continue; // We have a matching pattern
                        }
                    }
                }
                return false; // There is a mis-match
            }
            return $variables; // ALL segments match
        }
        return false; // Catch anything else
    }
}