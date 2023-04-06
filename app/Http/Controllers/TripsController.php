<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\City;
use App\Models\Seat;
use App\Models\Booking;
use App\Http\Resources\TripResource;

class TripsController extends Controller
{
    //

    public function getTrips(){

        $validated = request()->validate([
            'from' => 'required|exists:cities,name',
            'to' => 'required|exists:cities,name',
        ]);

        $from = City::where('name',request()->from)->first()->id;
        $to = City::where('name',request()->to)->first()->id;
        $trips = Trip::get();

        $graph=[];
        // get a graph for all the paths of each city 
        foreach($trips as $trip){
            if (!array_key_exists($trip->start_city,$graph)){
                $graph[$trip->start_city] =[];
            }
            $graph[$trip->start_city][] = ['city'=>$trip->end_city,'bus'=>$trip->bus_id];

            if (!array_key_exists($trip->end_city,$graph)){
                $graph[$trip->end_city] =[];
            }
        }

        $paths = [];
        
        //preform depth first search on the graph
        $this->depthFirst($from,[['city'=>$from,"bus"=>null]],[$from],$to,$graph,$paths);

        

        // used resource to make json more understandable
        return response()->json(TripResource::collection($paths));




    
    }



    private function depthFirst($current,$path,$visited,$end,$graph, &$paths){

        // if reached destination then path is found and stop search
        if ($current == $end){
            $paths[]=$path;
            return ;
        }

        // dd($graph[$current]);
        foreach($graph[$current] as $next){

            if (!in_array($next['city'],$visited)){
                //if not visited
                //get the count of booked seats
                $booked_seats =  Booking::where('from',$current)->where('to',$next['city'])->where('bus_id',$next['bus'])->count();
                if ($booked_seats < 12){
                    // call search recursive until reaching end destination
                    $this->depthFirst($next['city'],array_merge($path,[$next]),array_merge($visited,[$next['city']]),$end,$graph,$paths);
                }
            }
        }
    }
}
