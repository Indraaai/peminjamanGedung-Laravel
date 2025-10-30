<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait RespondsWithFlashMessages
{
    /**
     * Respond with success message
     *
     * @param string $message
     * @param string|null $route
     * @param array $routeParams
     * @return RedirectResponse
     */
    protected function respondWithSuccess(
        string $message,
        ?string $route = null,
        array $routeParams = []
    ): RedirectResponse {
        $redirect = $route
            ? redirect()->route($route, $routeParams)
            : back();

        return $redirect->with('flash', [
            'type' => 'success',
            'message' => $message,
            'icon' => '✅'
        ]);
    }

    /**
     * Respond with error message
     *
     * @param string $message
     * @param bool $withInput
     * @param array $errors
     * @return RedirectResponse
     */
    protected function respondWithError(
        string $message,
        bool $withInput = false,
        array $errors = []
    ): RedirectResponse {
        $redirect = back();

        if ($withInput) {
            $redirect = $redirect->withInput();
        }

        if (!empty($errors)) {
            $redirect = $redirect->withErrors($errors);
        }

        return $redirect->with('flash', [
            'type' => 'error',
            'message' => $message,
            'icon' => '❌'
        ]);
    }

    /**
     * Respond with warning message
     *
     * @param string $message
     * @param bool $withInput
     * @return RedirectResponse
     */
    protected function respondWithWarning(
        string $message,
        bool $withInput = false
    ): RedirectResponse {
        $redirect = back();

        if ($withInput) {
            $redirect = $redirect->withInput();
        }

        return $redirect->with('flash', [
            'type' => 'warning',
            'message' => $message,
            'icon' => '⚠️'
        ]);
    }

    /**
     * Respond with info message
     *
     * @param string $message
     * @param string|null $route
     * @param array $routeParams
     * @return RedirectResponse
     */
    protected function respondWithInfo(
        string $message,
        ?string $route = null,
        array $routeParams = []
    ): RedirectResponse {
        $redirect = $route
            ? redirect()->route($route, $routeParams)
            : back();

        return $redirect->with('flash', [
            'type' => 'info',
            'message' => $message,
            'icon' => 'ℹ️'
        ]);
    }

    /**
     * Respond with conflict error (specific for booking conflicts)
     *
     * @param string $message
     * @return RedirectResponse
     */
    protected function respondWithConflict(string $message): RedirectResponse
    {
        return back()
            ->withInput()
            ->withErrors(['conflict' => $message])
            ->with('flash', [
                'type' => 'error',
                'message' => $message,
                'icon' => '🚫'
            ]);
    }

    /**
     * Respond with validation errors
     *
     * @param array $errors
     * @param string $message
     * @return RedirectResponse
     */
    protected function respondWithValidationErrors(
        array $errors,
        string $message = 'Terdapat kesalahan dalam pengisian form.'
    ): RedirectResponse {
        return back()
            ->withInput()
            ->withErrors($errors)
            ->with('flash', [
                'type' => 'error',
                'message' => $message,
                'icon' => '⚠️'
            ]);
    }
}
