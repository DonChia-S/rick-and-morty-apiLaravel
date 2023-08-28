<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function index(Request $request){

        if($this->validateToken($request)){

            $pagination = DB::table($request->entity)->paginate(20);

            $results = array();

            foreach($pagination->items() as $data){
                foreach($data as $key => $value)
                {
                    $data->{$key} = $this->isJson($value);
                }

                array_push($results, $data);
            }

            $reponse = [
                "info" => [
                    "count" => $pagination->total(),
                    "pages" => $pagination->lastPage()
                ],
                "results" => $results
            ];

            return $reponse;
        }

        return ["message" => "Error token"];
    }

    public function show(Request $request){
        $register = DB::table($request->entity)->where('id', $request->id)->get();
        [$register] = $register;

        foreach($register as $key => $value)
        {
            $register->{$key} = $this->isJson($value);
        }

        return $register;
    }

    public function store(Request $request){
        if($this->validateToken($request)){
            $id = $request->query("id");

            $newRegister = DB::table($request->entity)->insert($request->all());

            return json_encode([
                "message" => "successful register",
                "data" => $request->all()
            ]);
        }

        return ["message" => "Error token"];
    }

    public function update(Request $request){
        if($this->validateToken($request)){
            $id = $request->query("id");
            $editRegister = DB::table($request->entity)
            ->where('id', $id)
            ->update($request->all());


            return json_encode([
                "message" => "successful register was edited",
                "data" => $editRegister
            ]);
        }

        return ["message" => "Error token"];
    }

    public function destroy(Request $request){
        if($this->validateToken($request)){
            $id = $request->query("id");
            $register = DB::table($request->entity)->where('id', $id);

            if($register->first()->id == $id){
                $register->delete();
                return json_encode([
                    "message" => "Personaje Eliminado correctamente"
                ]);
            }

            return json_encode([
                "message" => "Personaje no encontrado"
            ]);
        }

        return ["message" => "Error token"];
    }

    public function migrate(Request $request){
        $count = DB::table($request->word)->count();
        if($count < 1){
            $response = $this->apiRick(0, $request->word);
            $numPages = $response->info->pages;

            for($i = 1; $i <= $numPages; $i++){
                $responsePage = $this->apiRick($i, $request->word);;
                $results = $responsePage->results;

                foreach($results as $data){
                    foreach($data as $key => $value){
                        $data->{$key} = gettype($value) == "array" || gettype($value) == "object" ? json_encode($value) : $value;
                    }
                    DB::table($request->word)->insert((array) $data);
                }
            }


            return ["message" => "migrated successful",];
        }

        return [
            "message" => "this table have data"
        ];
    }

    private function isJson($value) {
        $test = json_decode($value);
        if(json_last_error() === JSON_ERROR_NONE){
            return json_decode($value);
        }
        return $value;
    }

    private function apiRick($page = 0, $word){
        $ch = curl_init();
        if($page == 0){
            curl_setopt($ch, CURLOPT_URL, env('API_BASE_URL') . $word);
        }else{
            curl_setopt($ch, CURLOPT_URL, env('API_BASE_URL') . $word . "?page=" . $page);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    private function validateToken(Request $request){
        $header = $request->header('token');

        return $header == "#TOKEN12345==";
    }
}
