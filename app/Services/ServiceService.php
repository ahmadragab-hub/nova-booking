<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceService
{
    public function getServices(int $perPage = 10): LengthAwarePaginator
    {
        return Service::with('category')
                        ->latest()
                        ->paginate($perPage);
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function update(Service $service, array $data): Service 
    {
        $service->update($data);

        return $service->refresh();
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }

    public function toggleActive(Service $service): Service
    {
        $service->update([
            'active' => ! $service->active,
        ]);

        return $service->refresh();
    }
}