<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\city;

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
            $graph[$trip->start_city][] = $trip->end_city;
        }

        $paths = [];

        // dd($graph);

        $this->depthFirst($from,[$from],[$from],$to,$graph,$paths);

        dd($paths);




    
    }



    private function depthFirst($current,$path,$visited,$end,$graph, &$paths){

        if ($current == $end){
            $paths[]=$path;
            return ;
        }

        // dd($graph[$current]);
        foreach($graph[$current] as $next){

            if (!in_array($next,$visited)){
                //if not visited
                $this->depthFirst($next,array_merge($path,[$next]),array_merge($visited,[$next]),$end,$graph,$paths);
            }
        }
    }
}
