<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        
        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valido i campi del form con una funzione
        $request->validate($this->getValidationRules());

        //Se non ci sono errori di validazione, salvo i dati in $form_data
        $form_data = $request->all();

        //Creo un nuovo post
        $new_post = new Post();
        $new_post->fill($form_data);

        $new_post->slug = $this->getFreeSlugFromTitle($new_post->title);

        $new_post->save();

        //Salvato il nuovo post devo collegargli i tag
        if (isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        }

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post
        ];

        return view('admin.posts.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validazione dati
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        //Aggiornare il post da modificare con ->update()
        $post_to_update = Post::findOrFail($id);

        //Aggiungere all'array associativo dei nuovi dati lo slug
        //Ricalcoliamo lo slug solo se è diverso dal vecchio
        if($form_data ['title'] !== $post_to_update->title) {
            $form_data['slug'] = $this->getFreeSlugFromTitle($form_data ['title']);

        }else {
            $form_data['slug'] = $post_to_update->slug;
        }

        $post_to_update->update($form_data);

        //Aggiorniamo anche i tag
        if (isset($form_data['tags'])) {
            $post_to_update->tags()->sync($form_data['tags']);
        }else {
            $post_to_update->tags()->sync([]);
        }

        return redirect()->route('admin.posts.show', ['post' => $post_to_update->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_to_delete = Post::findOrFail($id);
        $post_to_delete->tags()->sync([]);
        $post_to_delete->delete();

        return redirect()->route('admin.posts.index');
    }

    protected function getFreeSlugFromTitle($title) {
        //Assegnare lo slug
        $slug_to_save = Str::slug( $title, '-');
        $slug_base = $slug_to_save;
        //Verifico se questo slug esiste nel db
        $existing_slug_post = Post::where('slug', '=', $slug_to_save)->first();

        //Finchè non trovo uno slug libero, appendo un numero allo slug base
        $counter = 1;
        while ($existing_slug_post) {
            //Creiamo un nuovo slug con $counter
            $slug_to_save = $slug_base . '-' . $counter;

            //Verifico se questo slug esiste già
            $existing_slug_post = Post::where('slug', '=', $slug_to_save)->first();

            $counter++;
        }

        return $slug_to_save;
    }

    protected function getValidationRules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:60000',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ];
    }
}
