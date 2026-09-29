<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\StaffProfile;
use App\Services\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(
        private StaffService $staffService
    ) {
    }

    public function index(): View
    {
        $staff = StaffProfile::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('staff.create');
    }

    public function store(
        StoreStaffRequest $request
    ): RedirectResponse {
        $this->staffService->create(
            $request->validated()
        );

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function show(
        StaffProfile $staff
    ): View {
        $staff->load([
            'user',
            'services',
        ]);

        return view('staff.show', compact('staff'));
    }

    public function edit(
        StaffProfile $staff
    ): View {
        $staff->load('user');

        return view('staff.edit', compact('staff'));
    }

    public function update(
        UpdateStaffRequest $request,
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->update(
            $staff,
            $request->validated()
        );

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->delete($staff);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    public function toggleActive(
        StaffProfile $staff
    ): RedirectResponse {
        $this->staffService->toggleActive($staff);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff status updated successfully.');
    }
}