<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {
    }

    public function index(): View
    {
        $customers = Customer::query()
            ->latest()
            ->paginate(10);

        return view(
            'customers.index',
            compact('customers')
        );
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(
        StoreCustomerRequest $request
    ): RedirectResponse {
        $customer = $this->customerService->create(
            $request->validated()
        );

        return redirect()
            ->route('customers.show', $customer)
            ->with(
                'success',
                'Customer created successfully.'
            );
    }

    public function show(
        Customer $customer
    ): View {
        $customer->load([
            'bookings.service',
            'bookings.staffProfile.user',
        ]);

        return view(
            'customers.show',
            compact('customer')
        );
    }

    public function edit(
        Customer $customer
    ): View {
        return view(
            'customers.edit',
            compact('customer')
        );
    }

    public function update(
        UpdateCustomerRequest $request,
        Customer $customer
    ): RedirectResponse {
        $this->customerService->update(
            $customer,
            $request->validated()
        );

        return redirect()
            ->route('customers.show', $customer)
            ->with(
                'success',
                'Customer updated successfully.'
            );
    }

    public function destroy(
        Customer $customer
    ): RedirectResponse {
        $this->customerService->delete($customer);

        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                'Customer deleted successfully.'
            );
    }
}