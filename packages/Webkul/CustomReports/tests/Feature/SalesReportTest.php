<?php

use function Pest\Laravel\getJson;

it('should redirect guests away from the sales report', function () {
    $this->get(route('custom-reports.admin.sales.index'))
        ->assertRedirect();
});

it('should return the sales report page for admins', function () {
    $this->loginAsAdmin();

    $this->get(route('custom-reports.admin.sales.index'))
        ->assertOk();
});

it('should return the sales report datagrid records for admins', function () {
    $this->loginAsAdmin();

    getJson(route('custom-reports.admin.sales.index'), ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertOk()
        ->assertJsonStructure([
            'records',
            'meta' => ['total'],
        ]);
});
