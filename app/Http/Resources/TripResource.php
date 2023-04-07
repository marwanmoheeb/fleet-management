<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = collect($this->resource);
        $intial = $collection->where('bus',"")->first();
        return [
            'start' => City::find($intial['city'])->name, // starting city
            'path' => BusResource::collection($collection->where('bus',"!=","")->groupBy('bus')) // buses that are needed to reach destination
        ];
    }
}
