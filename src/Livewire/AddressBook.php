<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Livewire;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\System\Models\Country;
use Igniter\User\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use TiPowerUp\OrangeTw\Livewire\Forms\AddressBookForm;

class AddressBook extends Component
{
    use ConfigurableComponent;
    use WithPagination;

    public AddressBookForm $form;

    public ?int $addressId = null;

    public ?int $defaultAddressId = null;

    public bool $showModal = false;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public static function componentMeta(): array
    {
        return [
            'code' => 'tipowerup-orange-tw::address-book',
            'name' => 'Address Book',
            'description' => 'Allows customers to manage their addresses',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of addresses to display per page.',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
            ],
        ];
    }

    public function mount(): void
    {
        $this->defaultAddressId = Auth::customer()?->address_id;
        $this->form->country_id = Country::getDefaultKey();
    }

    public function updated($property, $value): void
    {
        if ($property === 'addressId') {
            $this->showModal = ! empty($value);
            $this->form->reset();
            $this->resetErrorBag();
        }
    }

    public function create(): void
    {
        $this->showModal = true;
        $this->addressId = null;
        $this->form->reset();
        $this->form->country_id = Country::getDefaultKey();
        $this->resetErrorBag();
    }

    public function edit($id): void
    {
        $this->addressId = $id;
        $this->showModal = true;
    }

    public function save(): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $this->form->validate();

        if ($this->addressId) {
            throw_unless($address = $this->getAddress($this->addressId), new ApplicationException('Address not found'));
            $address->fill($this->form->except('address_id'));
            $address->save();
        } else {
            $address = $customer->addresses()->create($this->form->except('address_id'));
        }

        if ($this->form->is_default) {
            $customer->address_id = $address->address_id;
            $customer->saveQuietly();
            $this->defaultAddressId = $address->address_id;
        }

        flash()->success(lang('igniter.user::default.account.alert_updated_success'))->now();

        $this->addressId = null;
        $this->showModal = false;
        $this->resetPage();
    }

    public function delete($id): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $customer->deleteCustomerAddress($id);

        flash()->success(lang('igniter.user::default.account.alert_deleted_success'))->now();

        $this->addressId = null;
        $this->showModal = false;
        $this->resetPage();
    }

    public function setDefault($id): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $customer->saveDefaultAddress($id);

        $this->defaultAddressId = (int) $id;
    }

    protected function getAddress(?int $addressId)
    {
        return $addressId ? Auth::customer()?->addresses()->find($addressId) : null;
    }

    protected function loadAddresses()
    {
        if (! $customer = Auth::customer()) {
            return [];
        }

        return $customer->addresses()->listFrontEnd([
            'page' => $this->getPage(),
            'pageLimit' => $this->itemsPerPage,
            'sort' => $this->sortOrder,
        ]);
    }

    public function render()
    {
        $selectAddress = null;
        if ($address = $this->getAddress($this->addressId)) {
            $this->form->fillFrom($address, Auth::customer()->address_id);
            $selectAddress = $address;
        }

        return view('tipowerup-orange-tw::livewire.address-book', [
            'addresses' => $this->loadAddresses(),
            'selectAddress' => $selectAddress,
        ]);
    }
}
