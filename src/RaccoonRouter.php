<?php

namespace App;

use App\Exception\NotFoundException;
use Closure;

final class RaccoonRouter
{
    protected array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(string $method, string $url, closure $target): void
    {
        $this->routes[strtoupper(trim($method))][trim($url)] = $target; // GET|POST|UPDATE|DELETE,...
    }

    /**
     * @throws NotFoundException
     */
    public function matchRoute(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Use named sub-patterns in the regular expression pattern to capture each parameter value separately
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);

                /**
                 * The regular expression pattern /\/:([^\/]+)/ matches a substring in the route URL that starts with a forward slash (/) followed by a colon (:),
                 * and captures the characters after the colon until the next forward slash (/).
                 *
                 * The preg_replace() function then replaces all occurrences of this pattern in the route URL with a new string, /(?P<$1>[^/]+).
                 *
                 * (?P<$1>[^/]+) captures one or more characters that are not a forward slash, as before, but uses a named subpattern to give the captured substring a name.
                 * The <$1> syntax specifies the name of the subpattern, which is the same as the name of the capturing group in the original pattern.
                 *
                 * Note that we have used named sub-patterns. This means you need to write the correct parameter name to retrieve the URL.
                 * For example, if you use the parameter name :blogID, you cannot use $id as a parameter. You need to pass $blogID as it is typed in the URL.
                 */
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    // Pass the captured parameter values as named arguments to the target function
                    $params = array_filter($matches, callback: 'is_string', mode: ARRAY_FILTER_USE_KEY); // Only keep named subpattern matches
                    call_user_func_array($target, $params);
                    return;
                }
            }
        }

        throw new NotFoundException();
    }
}