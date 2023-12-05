<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        $blog=Blog::all();
        return view('blog.index', ['blog'=>$blog, 'user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $user = Auth::user();

    $form = $request->validate([
        'title' => 'required|regex:/^[\pL\s]*\??[\pL\s]*$/u',// dozvoljava razmake i samo jedan znak ?, moze a ne mora da ih ima
        'coverImage.*' => 'required|image|between:1,2560|max:2560',
        'descriptionSrb' => 'required',
        'descriptionEng' => 'required',
        'titleEng' => 'required'
    ]);

    $form['user_id'] = $user->id;


   
    $blog = Blog::create([
        'title' => $form['title'],
        'descriptionSrb' => $form['descriptionSrb'],
        'descriptionEng' => $form['descriptionEng'],
        'user_id' => $form['user_id'], // Dodajemo user_id ovde 
        'titleEng'=> $form['titleEng']
    ]);
     //dd($blog);
    //da bi blog imao vise slika, formirana tabela images i njen modle gde je uradjena relacija.

    if ($request->hasFile('coverImage')) {
        foreach ($request->file('coverImage') as $image) {
            $path = $image->store('blog', 'public');
            Image::create([
                'path' => $path,
                'blog_id' => $blog->id, // Povezuje sliku sa blog postom
            ]);
        }
    }

    session()->flash('alertType', 'success');
    session()->flash('alertMsg', 'Uspesno ste kreirali blog');

    return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
       
        $blogId = $blog->id;
        $comment = Comment::where('blog_id',  $blogId)->get();
        $images=Image::where('blog_id',  $blogId)->get();
        return view('blog.show', [
            'blog' => $blog, 'comment'=>$comment, 'images'=>$images]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog )
    {

     if (
        !auth()->user()->roles->firstWhere('type', 1) &&
        $blog->user_id != auth()->id()
    ) {
        abort(403, 'Unauthorized Action');
    }

        $bloglId = $blog->id;
        $images = Image::where('blog_id',  $bloglId)->get();
        return view('blog.edit', [
            'blog' => $blog, 'images'=>$images
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
   
        $form = $request->validate([
            'title' => 'required|regex:/^[\pL\s]*\??[\pL\s]*$/u',// dozvoljava razmake i samo jedan znak ?, moze a ne mora da ih ima
            'coverImage.*' => 'image|between:1,2560|max:2560',
            'descriptionSrb' => 'required',
            'descriptionEng' => 'required',
            'titleEng' => 'required'
        ]);
       
        //dd($form);
        $blog->update($request->only('title', 'descriptionSrb', 'descriptionEng', 'titleEng'));

       
        if ($request->has('keep_old_images')) {
            // Ako je korisnik označio opciju "Zadrži stare slike", nema potrebe za brisanjem starih slika.
            if ($request->hasFile('coverImage')) {
                foreach ($request->file('coverImage') as $image) {
                    $path = $image->store('blog', 'public');
                    Image::create([
                        'path' => $path,
                        'blog_id' => $blog->id, // Povezuje sliku sa blog postom
                    ]);
                }
            }
        } else {
            // Ako korisnik nije označio opciju "Zadrži stare slike", obrišite sve stare slike.
            $blog->images()->delete();
            if ($request->hasFile('coverImage')) {
                foreach ($request->file('coverImage') as $image) {
                    $path = $image->store('blog', 'public');
                    Image::create([
                        'path' => $path,
                        'blog_id' => $blog->id, 
                    ]);
                }
            }
        }

        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno izmenjen blog!');
        return redirect()->route('blog.index');
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (
            !auth()->user()->roles->firstWhere('type', 1) &&
            $blog->user_id != auth()->id()
        ) {
            abort(403, 'Unauthorized Action');
        }
        $blog->delete();
        session()->flash('alertType', 'success');
        session()->flash('alertMsg', 'Uspesno ste obrisali blog');
        return redirect()->route('blog.index');
    }


    
    public function myBlog() {
        return view('blog.myBlog', ['blog'=> auth()->user()->blogs()->get()]);
    }


    //svi blogovi, vide samo admini i mogu da brisu
    public function allBlog() {
        $blog=Blog::all();
        return view('blog.allBlog', ['blog'=>$blog]);
    }
}
