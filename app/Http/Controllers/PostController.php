<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Review;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Post $post)
    {
        return view('posts.index')->with(['posts' => $post->get()]);
    }
    
    public function create(Tag $tag, Category $category)
    {
        return view('posts.create')->with([
            'tags' => $tag->get(),
            'categories' => $category->get(),
        ]);
    }
    
    public function mypage(Post $post, Tag $tag, Review $review)
    {
        //ログインしているユーザの投稿を表示
        $post = Post::where('user_id','=',Auth::id())->get();
        
        return view('posts.mypage')->with([
            'posts' => $post,
        ]);
    }
    
    public function edit(Post $post, Tag $tag, Category $category)
    {
        return view('posts.edit')->with([
            'post' => $post,
            'tag' => $tag->get(),
            'categories' => $category->get(),
        ]);
    }
    
    public function store(Request $request, Post $post, Tag $tag)
    {
        $input_post = $request['post'];
        $input_tags = $request->tags_array;
        //$meal_image_url = Cloudinary::upload($request->file('meal_image_url')->getRealPath())->getSecurePath();
        //$input_post += ['meal_image_url' => $meal_image_url];
        $input_post += ['user_id' => $request->user()->id];
        $post->fill($input_post)->save();
        $post->tags()->attach($input_tags);
        return redirect('/');
    }
    public function update(Request $request, Post $post, Tag $tag)
    {
        $input_post = $request['post'];
        $input_tags = $request->tags_array;
        //$meal_image_url = Cloudinary::upload($request->file('meal_image_url')->getRealPath())->getSecurePath();
        //$input_post += ['meal_image_url' => $meal_image_url];
        $input_post += ['user_id' => $request->user()->id];
        $post->fill($input_post)->save();
        $post->tags()->sync($input_tags);
        return redirect('/');
    }
    
    public function show(Post $post, Review $review, Tag $tag)
    {
        $reviews = Review::where('post_id','=',$post->id)->get();
        return view('posts.show',compact('post','reviews'));
    }
    
    public function review_create(Request $request, Review $review)
    {
        $input = $request['review'];
        $review->fill($input)->save();
        return redirect('/posts/' . $review->posts_id);
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/mypage');
    }
    //引数IDに紐づく投稿にいいねする
    public function like($id){
        Like::create([
            'user_id'=>Auth::id(),
            'post_id'=>$id,
            ]);
            return redirect()->back();
    }
    //引数IDに紐づく投稿のいいねをはずす
    public function unlike($id){
        $like=Like::where('post_id',$id)->where('user_id',Auth::id())->first();
        $like->delete();
        return redirect()->back();
    }
}
