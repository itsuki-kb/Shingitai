<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // elements()も同時にEager Loadingで取得
        $all_posts = $this->post->with('elements')->latest()->paginate(10);

        return view('posts.index')
            ->with('all_posts', $all_posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         *postsテーブルに日付を保管して、post_idを生成する
         *post_contentsテーブルに心技体の内容を補完するFunctionを呼び出す
         *post_contentsテーブルに内容を補完する
         *indexにリダイレクトする
         *あとでつくる：同じ日付のそのユーザーの投稿があれば、編集に限定する
         *　　　　　　　（日付選択時にJavascriptでメッセージ表示）
         */

         $validated = $request->validate([
            'date'            => 'required',
            'heart_condition' => 'required|in:true,false',
            'heart_content'   => 'required|string',
            'skill_condition' => 'required|in:true,false',
            'skill_content'   => 'required|string',
            'body_condition'  => 'required|in:true,false',
            'body_content'    => 'required|string'
        ]);

        // 文字列 "true"/"false" → 数値 1/0 に変換
        $validated['heart_condition'] = $validated['heart_condition'] === 'true' ? 1 : 0;
        $validated['skill_condition'] = $validated['skill_condition'] === 'true' ? 1 : 0;
        $validated['body_condition'] = $validated['body_condition'] === 'true' ? 1 : 0;

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'date' => $validated['date'],
        ]);

        $post->elements()->createMany([
            [
                'category' => '心',
                'content' => $validated['heart_content'],
                'condition' => $validated['heart_condition'],
            ],
            [
                'category' => '技',
                'content' => $validated['skill_content'],
                'condition' => $validated['skill_condition'],
            ],
            [
                'category' => '体',
                'content' => $validated['body_content'],
                'condition' => $validated['body_condition'],
            ]
        ]);

        return redirect()->route('post.index')->with('success', '投稿が完了しました！');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
