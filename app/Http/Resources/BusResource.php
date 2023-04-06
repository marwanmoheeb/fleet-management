<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City;
use App\Models\Seat;

class BusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $path = "";
        foreach($this->resource as $stop){

            if ($path ==""){
                $path = City::find($stop['city'])->name;
            }else{
                $path =$path.'->'.City::find($stop['city'])->name;
            }
        }
        $bus =  $this->resource->first()['bus'];


        // get the unbooked seats
        $seats = Seat::whereDoesntHave('booking')->where('bus_id',$bus)->get()->pluck('name');

        return [
            'bus' =>$bus,// bus id 
            'path' => $path,// show the path the bus is taking 
            'available_seats'=>$seats // list of available seats
        ];
    }
}
