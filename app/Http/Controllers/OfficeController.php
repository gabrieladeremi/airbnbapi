<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use App\Services\OfficeServices;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfficeController
{
    public function index(): AnonymousResourceCollection
    {
//        $offices = OfficeServices::getOffice($request);

        $offices = Office::query()
                        ->where('approval_status', Office::APPROVAL_APPROVED)
                        ->where('hidden', false)
                        ->when(request('host_id'), fn ($builder) =>
                        $builder->whereUserId(request('host_id'))
                        )
                        ->latest('id')
                        ->paginate(20);

        return OfficeResource::collection(
            $offices
        );
    }
}
