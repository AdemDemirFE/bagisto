<?php

use Webkul\Customer\Models\Customer;

use function Pest\Laravel\getJson;

it('should redirect guests away from the loyalty api', function () {
    getJson(route('custom-customer.api.loyalty'))
        ->assertUnauthorized();
});

it('should return the loyalty summary for the customer', function () {
    $customer = Customer::query()->where('email', 'emre.koc@example.com')->firstOrFail();

    $this->loginAsCustomer($customer);

    getJson(route('custom-customer.api.loyalty'))
        ->assertOk()
        ->assertJsonPath('data.customer_id', $customer->id)
        ->assertJsonPath('data.tier', 'bronz')
        ->assertJsonPath('data.orders', 1);
});

it('should render the loyalty widget on the admin customer view', function () {
    $this->loginAsAdmin();

    $customer = Customer::query()->where('email', 'emre.koc@example.com')->firstOrFail();

    $this->get(route('admin.customers.customers.view', $customer->id))
        ->assertOk()
        ->assertSee('Sadakat Segmenti')
        ->assertSee('Bronz');
});
