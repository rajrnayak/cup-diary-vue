<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $givenPermissions = [];
        $role = Role::find(3);
        $all_permissions = Permission::get('name');
        foreach ($all_permissions as $key => $value) {
            $givenPermissions[$value->name] = $role->hasPermissionTo($value->name);
        }
        $url = url('/');
        return array_merge(parent::share($request), [
            'baseUrl' => $url,
            'givenPermissions'=>$givenPermissions
        ]);
    }
}
