<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ImageController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function create(){
        return view("image.create");
    }

    public function save(Request $request){

        //Validando los datos del formulario
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image' => ['required', 'mimes:jpg,jpeg,png,gif']
            
        ]);

        //Obteniendo los datos del formulario
        $description = $request->input("description");
        $image_path = $request->file("image");
        

        //Guardando imagen
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();

            Storage::disk("images")->put($image_path_name, File::get($image_path));
        }

        //Asignando Valores al objeto de Imagen
        $user = \Auth::user();
        $image = new Image();
        $image->description = $description;
        $image->image_path = $image_path_name;
        $image->user_id = $user->id;

        //Guardando los datos en la base de Datos
        $image->save();

        return redirect()->route("postImage")->with(["message"=> "Imagen subida exitosamente"]);

    }

    public function getImage($filename){

        $file = Storage::disk("images")->get($filename);
        return Response($file, 200);
    }

    
    public function detail($id){

        $image = Image::find($id);
      
        return view("image.detail", ["image"=> $image]);
    }

    public function delete($id){
        $image = Image::find($id);
        $likes = Like::where("image_id", $id)->get();
        $comments = Comment::where("image_id", $id)->get();
        $user = \Auth::user();

        if($user && \Auth::user()->id == $image->user_id){
            //Eliminar likes

            foreach($likes as $like){
                $like->delete();
            }

            //Eliminar comments

            foreach($comments as $comment){
                $comment->delete();
            }

            //Eliminar image
            Storage::disk("images")->delete($image->image_path);

            $image->delete();
            
            $message = array("message" => "Post eliminado correctamente");

        }
        else{
            $message = array("message" => "No se pudo eliminar el post");
        }

        return redirect()->route("home")->with($message);
    }

    public function edit($id){
        $image = Image::find($id);

        return view("image.edit", ["image"=> $image]);
    }

    public function editAndSave(Request $request, $id){
        $image = Image::find($id);

        $image->description = $request->input('description');

        $image_path = $request->file("image");

        if($image_path){
            //Guardando nueva imagen
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk("images")->put($image_path_name, File::get($image_path));

            //Eliminando imagen vieja
            Storage::disk("images")->delete($image->image_path);
            $image->image_path = $image_path_name;
        }
        $image->update();

        return redirect()->route("image.detail", ["id"=>$image->id])->with(["message"=>"Post actualizado correctamente"]);
    }
    
}
