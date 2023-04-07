<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\City;
use App\Models\Seat;
use App\Models\Booking;
use App\Http\Resources\TripResource;
use Illuminate\Support\Facades\Log;


class TripsController extends Controller
{
    //

    public function getTrips(){

        $validated = request()->validate([
            'from' => 'required|exists:cities,name',
            'to' => 'required|exists:cities,name',
        ]);

        //get all possible paths
       $paths = $this->get(request()->from,request()->to);

        // used resource to organize data 
        return response()->json(TripResource::collection($paths));

    }

    public function create(){
        $validated = request()->validate([
            'from' => 'required|exists:cities,name',
            'to' => 'required|exists:cities,name',
            'customer' => 'required',
            'bus'=> 'required', // user choose bus in case there are more than one path going to same location
            'seat' => 'exists:seats,name'
        ]);

        // get all the paths to make sure bus exists
        $paths = collect($this->get(request()->from,request()->to));
        if (!$paths->first()){
            return response()->json('this route is not available, please check listing again',422);

        }
        $bus_id = request()->bus;
        $found = 0;
        $bus = $paths->first(function($array) use($bus_id,$found){
            foreach($array as $a){
                if ($found ==1){
                    break;
                }
                if ($a['bus'] == $bus_id){
                    $found = 1;
                    return $array;
                }
            }
        });

        if (!$bus){
            return response()->json('bus not avaiable for that route please check list again',422);
        }

        $path = "";
        $trips = [];
        foreach($bus as $stop){

            if ($path ==""){
                $path = City::find($stop['city'])->name;
            }else{
                $path =$path.'->'.City::find($stop['city'])->name;
            }

            array_push($trips,$stop['trip']);
        }


        $bookings = [];// trips to be booked
        $seats = Seat::whereDoesntHave('booking',function($q) use ($trips,$bus_id){
            $q->whereIn('trip_id',$trips);
        })->where('bus_id',$bus_id)->get();

        if (isset(request()->seat)){
            $seat =$seats->where('name',request()->seat)->first();
            if ( $seat== null){
                return response()->json('seat is not available choose another seat or leave empty to get any seat',422);
            }
        }else{
            $seat = $seats->first();
        }

        foreach($bus as $b ){
            if ($b['trip']== null){
                continue;
            }
            $bookings[]=array('name'=>request()->customer,'seat_id'=>$seat->id,'trip_id'=>$b['trip']);
        }

        try{
            Booking::insert($bookings);

            return response()->json(array('seat'=>$seat->name,'path'=>$path,'bus'=>$bus_id),200);

        }catch(Exception $e){
            Log::error('error inserting bookings');
            Log::error($e);
            return response()->json('error please try again',500);

        }

    }


    private function get($from,$to){
        $from = City::where('name',$from)->first()->id;
        $to = City::where('name',$to)->first()->id;
        $trips = Trip::get();

        $graph=[];
        // get a graph for all the paths of each city 
        foreach($trips as $trip){
            if (!array_key_exists($trip->start_city,$graph)){
                $graph[$trip->start_city] =[];
            }
            $graph[$trip->start_city][] = ['city'=>$trip->end_city,'bus'=>$trip->bus_id , 'trip' => $trip->id];

            if (!array_key_exists($trip->end_city,$graph)){
                $graph[$trip->end_city] =[];
            }
        }
        $paths = [];
        
        //preform depth first search on the graph
        $this->depthFirst($from,[['city'=>$from,"bus"=>null ,'trip'=>null]],[$from],$to,$graph,$paths);

        return $paths;
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
                $booked_seats =  Booking::where('trip_id',$next['trip'])->count();
                if ($booked_seats < 12){
                    // call search recursive until reaching end destination
                    $this->depthFirst($next['city'],array_merge($path,[$next]),array_merge($visited,[$next['city']]),$end,$graph,$paths);
                }
            }
        }
    }
}
