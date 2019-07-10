<?php

namespace App\Http\Middleware;

use App\Helpers\Error;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * Main Auth middleware
 * @package App\Http\Middleware
 */
class Authenticate{

    /**
     * The authentication factory instance.
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth){
        $this->auth = $auth;
    }

    /**
     * Determine if the user is logged in to any of the given guards
     * @param Request $request
     * @param array $guards
     * @return boolean
     */
    protected function authenticate($request, array $guards){
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return true;
            }
        }
        return false;
    }


    /**
     * Helper for the Access denied Error response
     * @param string $message
     * @return ResponseFactory|Response
     */
    private function accessDenied(string $message){
        return response(Error::new($message), 403);
    }


    /**
     * Handle an incoming request
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards){

        // Handle auth error
        if (!$this->authenticate($request, $guards)) {
            return $this->accessDenied('Access denied. Please provide a valid JWT as a Bearer-Token!');
        }
        return $next($request);
    }
}
