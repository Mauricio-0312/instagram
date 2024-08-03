<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Image;



class LikeController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function index(){
        $likes = Like::where("user_id", \Auth::user()->id)->orderBy("id", "desc")->paginate(5);

        return view("like.index", [
            "likes" => $likes
        ]);
    }

    public function like($image_id){
        //asignando datos al like
        $like = new Like();
        $like->user_id = \Auth::user()->id;
        $like->image_id = $image_id;
        
        //obteniendo imagen del like
        $image = Image::where("id", $image_id)->first();

     
        //guardando like
            $like->save();
    
           
            return response()->json([
                "like" => $like,
                "message" => "Like saved",
                "likes" => count($image->likes)
            ]);
    }

    public function dislike($image_id){
        //buscado el like en la Database
        $isset_like = Like::where("image_id", $image_id)->where("user_id", \Auth::user()->id)->first();
        
        //obteniendo imagen del like
        $image = Image::where("id", $image_id)->first();

        //eliminando like
        $isset_like->delete();
    
        
    
           
        return response()->json([
            "like" => $isset_like,
            "message" => "Like deleted",
            "likes" => count($image->likes)
        ]);
    }
}
