<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $navPermissions = [];

        if(auth()->check()) {
            $navPermissions = [
                'Interims' => auth()->user()->hasPermission('interims.self') || auth()->user()->hasPermission('interims.admin'),
                'Issues' => auth()->user()->hasPermission('issues.manage'),
                'System' => auth()->user()->hasPermission('sysadmin.dashboard'),
                'SituationalAwareness' => auth()->user()->hasPermission('situation.awareness'),
                'SituationalMonitoring' => auth()->user()->hasPermission('situation.monitoring')
            ];
        }
        return array_merge(parent::share($request), [
            'navPermissions' => $navPermissions
        ]);
    }
}
