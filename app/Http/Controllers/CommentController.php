<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function store(Request $request){
        //Validando datos
        $validate = $this->validate($request, [
            'content' => ['required'],
        ]);
        //Obteniendo datos
        $user = \Auth::user();
        $content = $request->input("content");
        $image_id = $request->input("image_id");

        //Asignando datos al objeto Comment
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        $comment->save();

        return redirect()->route("image.detail", ["id"=>  $image_id])->with("message", "Comentario publicado exitosamente");

    }

    public function delete($id){
        
        $comment = Comment::find($id);
        $image_id = $comment->image_id;
        $user = \Auth::user();

        if($user && $comment->user->id == $user->id || $comment->image->user_id == $user->id){
            $comment->delete();
            return redirect()->route("image.detail", ["id"=>  $image_id])->with("message", "Comentario eliminado exitosamente");

        }

        return redirect()->route("image.detail", ["id"=>  $image_id])->with("message", "Error al eliminar el comentario");

    }
}
