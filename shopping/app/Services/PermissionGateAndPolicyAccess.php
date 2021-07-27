<?php

namespace App\Services;

use App\Product;
use Illuminate\Support\Facades\Gate;

class PermissionGateAndPolicyAccess
{

    public function setGateAndPolicyAccess()
    {
        $this->defineGateCategory();
        $this->defineGateProduct();
        $this->defineGateMenu();
        $this->defineGateSlider();
        $this->defineGateSetting();
        $this->defineGateUser();
        $this->defineGatePermission();
        $this->defineGateRole();
    }

    private function defineGateCategory()
    {
        Gate::define('category-list', 'App\Policies\CategoryPolicy@view');
        Gate::define('category-add', 'App\Policies\CategoryPolicy@create');
        Gate::define('category-edit', 'App\Policies\CategoryPolicy@update');
        Gate::define('category-delete', 'App\Policies\CategoryPolicy@delete');
    }

    private function defineGateProduct()
    {
        Gate::define('product-list', function ($user) {
            return $user->checkPermissionAccess('product_list');
        });

        Gate::define('product-add', function ($user) {
            return $user->checkPermissionAccess('product_add');
        });


        Gate::define('product-edit', function ($user, $id) {
            $product = Product::find($id);
            if ($user->checkPermissionAccess('product_edit' && $product->user_id === $user->id)) {
                return true;
            }
            return false;

        });

        Gate::define('product-delete', function ($user) {
            return $user->checkPermissionAccess('product_delete');
        });
    }

    private function defineGateMenu()
    {
        Gate::define('menu-list', function ($user) {
            return $user->checkPermissionAccess('menu_list');
        });

        Gate::define('menu-add', function ($user) {
            return $user->checkPermissionAccess('menu_add');
        });

        Gate::define('menu-edit', function ($user) {
            return $user->checkPermissionAccess('menu_edit');
        });

        Gate::define('menu-delete', function ($user) {
            return $user->checkPermissionAccess('menu_delete');
        });
    }

    private function defineGateSlider()
    {
        Gate::define('slider-list', function ($user) {
            return $user->checkPermissionAccess('slider_list');
        });

        Gate::define('slider-add', function ($user) {
            return $user->checkPermissionAccess('slider_add');
        });

        Gate::define('slider-edit', function ($user) {
            return $user->checkPermissionAccess('slider_edit');
        });

        Gate::define('slider-delete', function ($user) {
            return $user->checkPermissionAccess('slider_delete');
        });
    }

    private function defineGateSetting()
    {
        Gate::define('setting-list', function ($user) {
            return $user->checkPermissionAccess('setting_list');
        });

        Gate::define('setting-add', function ($user) {
            return $user->checkPermissionAccess('setting_add');
        });

        Gate::define('setting-edit', function ($user) {
            return $user->checkPermissionAccess('setting_edit');
        });

        Gate::define('setting-delete', function ($user) {
            return $user->checkPermissionAccess('setting_delete');
        });
    }

    private function defineGateUser()
    {
        Gate::define('user-list', function ($user) {
            return $user->checkPermissionAccess('user_list');
        });

        Gate::define('user-add', function ($user) {
            return $user->checkPermissionAccess('user_add');
        });

        Gate::define('user-edit', function ($user) {
            return $user->checkPermissionAccess('user_edit');
        });

        Gate::define('user-delete', function ($user) {
            return $user->checkPermissionAccess('user_delete');
        });
    }

    private function defineGateRole()
    {
            Gate::define('role-list', function ($user) {
            return $user->checkPermissionAccess('role_list');
        });

        Gate::define('role-add', function ($user) {
            return $user->checkPermissionAccess('role_add');
        });

        Gate::define('role-edit', function ($user) {
            return $user->checkPermissionAccess('role_edit');
        });

        Gate::define('role-delete', function ($user) {
            return $user->checkPermissionAccess('role_delete');
        });
    }

    private function defineGatePermission()
    {
        Gate::define('permission-list', function ($user) {
            return $user->checkPermissionAccess('permission_list');
        });
    }
}
