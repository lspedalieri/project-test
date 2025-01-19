<?php

namespace App\Domain\Order\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class NotAuthorizedException extends AuthorizationException
{
    protected $route;

    public function render() : JsonResponse{
        return new JsonResponse([
            'message' => $this->message,
            'status' => "error",
        ], $this->code);        
    }

    public function redirectTo($route) {
        $this->route = $route;
    
        abort(Redirect::to($route));
    }
    
    public function route() {
        return $this->route;
    }
}
