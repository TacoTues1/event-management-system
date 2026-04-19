<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error('Unhandled exception: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        $this->renderable(function (QueryException $e, $request) {
            Log::error('Database error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['error' => 'A database error occurred. Please try again.'], 500);
            }
            return back()->with('error', 'A database error occurred. Please try again later.');
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'The requested record was not found.'], 404);
            }
            return back()->with('error', 'The requested record was not found.');
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Page not found.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        $this->renderable(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'You are not authorized to perform this action.'], 403);
                }
                return back()->with('error', 'You are not authorized to perform this action.');
            }
        });
    }
}
