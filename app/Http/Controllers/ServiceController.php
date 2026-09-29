<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Category;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $serviceService) {}

    public function index(): View
    {
        $services = $this->serviceService->getServices(10);

        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        $categories = Category::get();
        return view('services.create', compact("categories"));
    }

    public function store( StoreServiceRequest $request): RedirectResponse 
    {
        $this->serviceService->create($request->validated());

        return redirect()
            ->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service): View
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        $categories = Category::get(); // Add this line!
        return view('services.edit', compact('service', 'categories'));
    }


    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse 
    {
        $this->serviceService->update($service, $request->validated());

        return redirect()
            ->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->serviceService->delete($service);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function toggleActive(Service $service): RedirectResponse 
    {
        $this->serviceService->toggleActive($service);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service status updated successfully.');
    }
}