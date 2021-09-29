<?php

namespace App\Services;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeServices
{
    public static function getOffice($request):array
    {
          return [
              Office::query()
                ->where('approval_status', Office::APPROVAL_APPROVED)
                ->where('hidden', false)
                ->when($request('host_id'), fn ($builder) =>
                                $builder->whereUserId($request('host_id'))
                )
                   ->latest('id')
                ->paginate(20)
          ];
    }

}
