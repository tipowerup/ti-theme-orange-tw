<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\View\Components;

use Igniter\Local\Facades\Location;
use Illuminate\View\Component;

final class Fulfillment extends Component
{
    public function __construct(
        public bool $previewMode = false,
    ) {}

    public function render()
    {
        return view('tipowerup-orange-tw::components.fulfillment', [
            'isAsap' => Location::orderTimeIsAsap(),
            'activeOrderType' => Location::getOrderType(),
            'orderDateTime' => Location::orderDateTime(),
        ]);
    }
}
