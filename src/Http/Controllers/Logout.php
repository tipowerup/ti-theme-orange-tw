<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Http\Controllers;

use Igniter\Cart\Facades\Cart;
use Igniter\User\Actions\LogoutCustomer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        Cart::keepSession(function (): void {
            resolve(LogoutCustomer::class)->handle();
        });

        return Redirect::to('/');
    }
}
