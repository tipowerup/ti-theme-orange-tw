<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire\Forms;

use Igniter\User\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class BookingForm extends Form
{
    public ?string $first_name = null;

    public ?string $last_name = null;

    public ?string $email = null;

    public ?string $telephone = null;

    public ?string $comment = null;

    public function validationAttributes(): array
    {
        return [
            'first_name' => lang('igniter.reservation::default.label_first_name'),
            'last_name' => lang('igniter.reservation::default.label_last_name'),
            'email' => lang('igniter.reservation::default.label_email'),
            'telephone' => lang('igniter.reservation::default.label_telephone'),
            'comment' => lang('igniter.reservation::default.label_comment'),
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|between:1,48',
            'last_name' => 'required|between:1,48',
            'email' => ['sometimes', 'required', 'email:filter', 'max:96', Rule::unique('customers', 'email')->ignore(Auth::customer()?->getKey(), 'customer_id')],
            'telephone' => 'sometimes|nullable|regex:/^([0-9\s\-\+\(\)]*)$/i',
            'comment' => 'max:500',
        ];
    }
}
