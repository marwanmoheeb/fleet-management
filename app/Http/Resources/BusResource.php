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
        $trips = [];
        foreach($this->resource as $stop){

            if ($path ==""){
                $path = City::find($stop['city'])->name;
            }else{
                $path =$path.'->'.City::find($stop['city'])->name;
            }

            array_push($trips,$stop['trip']);
        }

        // dd($trips);
        $bus =  $this->resource->first()['bus'];


        // get the unbooked seats during the trips that the user is going on 
        $seats = Seat::whereDoesntHave('booking',function($q) use ($trips,$bus){
            $q->whereIn('trip_id',$trips);
        })->where('bus_id',$bus)->get()->pluck('name');

        return [
            'bus' =>$bus,// bus id 
            'path' => $path,// show the path the bus is taking 
            'available_seats'=>$seats // list of available seats
        ];
    }
}
