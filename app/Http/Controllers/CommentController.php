<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $blogId=$request->input('blog');
        return view('comment.create', ['blogId'=>$blogId,]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $form = $request->validate([
           
            'comment' => 'required',
        ]);
        $user = Auth::user();
        $form['user_id']=$user->id;
        $form['blog_id'] = $request->input('blog_id'); // blog Id poslat preko forme kroz sakriven input //pre toga je uhvacen u show delu
        //dd($form);
        //kreiranje
        Comment::create($form);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno ste komentarisali');

        // return redirect()->back();
        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
       
        return view('comment.edit',['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
        $form = $request->validate([
           
            'comment' => 'required',
        ]);
        $user = Auth::user();
        $form['user_id']=$user->id;

        //dd($form);
        //kreiranje
        $comment->update($form);
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno ste izmenili komentar');

        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //kada se obrise komentar da stoji komentar je obrisan u comment
            $comment = Comment::findOrFail($id);
            $comment->comment = 'Komentar je obrisan';
            $comment->save();
           
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno ste obrisali komentar');

        return redirect()->route('blog.index');
    }
}
