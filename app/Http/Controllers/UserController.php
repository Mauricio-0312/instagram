<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
    }

    public function config(){
        return view('user.config');
        
    }

    public function updateUser(Request $request){
        /*
        DB::table("users")->where("email", Auth::user()->email)->update(array(
            "name" => $request->input("name"),
            "surname" => $request->input("surname"),
            "nick" => $request->input("nick"),
            "email" => $request->input("email")
        ));
      */

   

            $user = \Auth::user();
             $id = \Auth::user()->id;
     
             //Validando los datos del formulario
            $validate = $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            ]);
            //Obteniendo los Valores del formulario
           

            $name = $request->input("name");
            $surname = $request->input("surname");
            $nick = $request->input("nick");
            $email = $request->input("email");

            //Asignando nuevos valores al objeto de usuario
            $user->name =$name;
            $user->surname =$surname;
            $user->nick =$nick;
            $user->email =$email;


            $image_path = $request->file("image");
            if($image_path){
                $image_path_name = time().$image_path->getClientOriginalName();

                Storage::disk("users")->put($image_path_name, File::get($image_path));

                $user->image = $image_path_name;
            }

            //Actualizando el usuario
            $user->update();

           

        

        return redirect()->route("config")->with(["message"=> "Usuario actualizado exitosamente"]);
    }

    public function getImage($filename){
        $file = Storage::disk("users")->get($filename);
        return Response($file, 200);
    }

    public function profile($user_id){
        $user = User::find($user_id);

        return view("user.profile", [
            "user" => $user
        ]);
    }

    public function people($search = null){
        if(!empty($search)){
            $users = User::where("nick", "like", "%".$search."%")
                            ->orWhere("name", "like", "%".$search."%")
                            ->orWhere("surname", "like", "%".$search."%")
                            ->orderBy("id", "desc")->paginate(5);

        }
        else{
            $users = User::orderBy("id", "desc")->paginate(5);
        }

        return view("user.people", ["users" => $users]);
    }
}
