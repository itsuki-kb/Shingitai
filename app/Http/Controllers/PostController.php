<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        //心技体のconditionをデフォルトですべて1(true)が選択されるよう配列で渡す
        $conditions = [1, 1, 1];

        return view('posts.create')
            ->with('conditions', $conditions);
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
    public function show($post_id)
    {
        $post = $this->post
            ->with(['user', 'elements'])
            ->findOrFail($post_id);

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($post_id)
    {
        $post = $this->post
            ->with(['elements'])
            ->findOrFail($post_id);

            $heart = $post->elements->firstWhere('category', '心');
            $skill = $post->elements->firstWhere('category', '技');
            $body  = $post->elements->firstWhere('category', '体');
            $conditions = [
                0 => $heart->condition, // 1 is Sun(True), 0 is Moon(False)
                1 => $skill->condition,
                2 => $body->condition
            ];

        return view('posts.edit', compact('post', 'heart', 'skill', 'body', 'conditions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $post_id)
    {
        $validated = $request->validate([
            'date'            => 'required',
            'heart_condition' => 'required|in:true,false',
            'heart_content'   => 'required|string|max:500',
            'skill_condition' => 'required|in:true,false',
            'skill_content'   => 'required|string|max:500',
            'body_condition'  => 'required|in:true,false',
            'body_content'    => 'required|string|max:500'
        ]);

        // 文字列 "true"/"false" → 数値 1/0 に変換
        $validated['heart_condition'] = $validated['heart_condition'] === 'true' ? 1 : 0;
        $validated['skill_condition'] = $validated['skill_condition'] === 'true' ? 1 : 0;
        $validated['body_condition'] = $validated['body_condition'] === 'true' ? 1 : 0;

        //postsテーブルを更新
        $post = $this->post->findOrFail($post_id);
        $post->date = $validated['date'];
        $post->save();

        //post_elementsテーブルを更新
        DB::transaction(function () use ($post, $validated) {
            $categories = ['心' => 'heart', '技' => 'skill', '体' => 'body'];

            foreach ($categories as $category => $prefix) {
                $element = $post->elements->firstWhere('category', $category);

                if ($element) {
                    $element->update([
                        'content' => $validated["{$prefix}_content"],
                        'condition' => $validated["{$prefix}_condition"]
                    ]);
                }
            }
        });
        return redirect()->route('post.show', $post_id)->with('success', '編集が完了しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id)
    {
        $post = $this->post->findOrFail($post_id);

        $post->delete();

        return redirect()->route('post.index');
    }
}
