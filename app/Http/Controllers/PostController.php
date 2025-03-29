<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
    public function index(Request $request)
    {
        //検索ワード
        $keyword = $request->input('keyword');

        // tabのデフォルトをall_postsに指定
        $tab = $request->query('tab', 'all_posts');

        $all_listing_data = match ($tab) {
            'following_posts' => $this->post
                              ->whereIn('user_id', Auth::user()->followings()->pluck('followee_id'))
                              ->with(['elements', 'likes'])
                              ->when($keyword, function ($query, $keyword) {
                                    $query->whereHas('elements', function ($q) use ($keyword) {
                                        $q->where('content', 'like', "%{$keyword}%");
                                    });
                                })
                              ->withCount('likes')
                              ->latest()
                              ->paginate(10),

            default => $this->post
                    ->with('elements', 'likes')
                    ->when($keyword, function ($query, $keyword) {
                        $query->whereHas('elements', function ($q) use ($keyword) {
                            $q->where('content', 'like', "%{$keyword}%");
                        });
                    })
                    ->withCount('likes')    //likeの数も取得
                    ->latest()
                    ->paginate(10),
        };

        //ログインユーザーがLikeしてあるポスト一覧のpost_idだけをArray形式で取得
        $liked_post_ids = Like::where('user_id', Auth::user()->id)
            ->pluck('post_id')
            ->toArray();

        return view('posts.index', compact('all_listing_data', 'tab', 'liked_post_ids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //心技体のconditionをデフォルトですべて1(true)が選択されるよう配列で渡す
        $conditions = [1, 1, 1];

        // 既に投稿済みの日付と、そのpost idを取得
        $existingPosts = $this->getExistingPosts();

        return view('posts.create', compact('conditions', 'existingPosts'));
    }

    //ログインユーザーの投稿済みの日付を取得（「投稿済み」モーダルの表示判定のため）
    private function getExistingPosts()
    {
        $existingPosts = $this->post
            ->where('user_id', Auth::id())
            ->get(['id', 'date'])
            ->map(function ($post) {
                return [
                    'date' => $post->date,
                    'id' => $post->id,
                ];
            })
            ->toArray();

        return $existingPosts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'date'            => 'required|date',
            'heart_condition' => 'required|boolean',
            'heart_content'   => 'required|string|max:500',
            'skill_condition' => 'required|boolean',
            'skill_content'   => 'required|string|max:500',
            'body_condition'  => 'required|boolean',
            'body_content'    => 'required|string|max:500'
        ]);

        //postsテーブルへの投稿
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'date' => $validated['date'],
        ]);

        //post_elementsテーブルへの投稿
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

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($post_id)
    {
        $post = $this->post
            ->with([
                'user',
                'elements',
                'comments' =>function($query){
                    $query->latest();
                }])
            ->withCount('likes')
            ->findOrFail($post_id);

        //Likeハートマークの表示判定のため、ログインユーザーがLikeした投稿のIDを配列で取得
        $liked_post_ids = Like::where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->pluck('post_id')
            ->toArray();

        return view('posts.show', compact('post', 'liked_post_ids'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($post_id)
    {
        $post = $this->post
            ->with(['elements'])
            ->findOrFail($post_id);

        //  投稿の所有者かチェック(AppServicePrividerから)
        if (Gate::denies('isOwner', $post)) {
            return redirect()->route('post.index');
        }

        //文章とコンディションを取得
        $heart = $post->elements->firstWhere('category', '心');
        $skill = $post->elements->firstWhere('category', '技');
        $body  = $post->elements->firstWhere('category', '体');
        $conditions = [
            0 => $heart->condition, // 1 is Sun(True), 0 is Moon(False)
            1 => $skill->condition,
            2 => $body->condition
        ];

        // 既に投稿済みの日付と、そのpost idを取得
        $existingPosts = $existingPosts = $this->getExistingPosts();

        return view('posts.edit', compact('post', 'heart', 'skill', 'body', 'conditions', 'existingPosts'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $post_id)
    {
        $validated = $request->validate([
            'date'            => 'required|date',
            'heart_condition' => 'required|boolean',
            'heart_content'   => 'required|string|max:500',
            'skill_condition' => 'required|boolean',
            'skill_content'   => 'required|string|max:500',
            'body_condition'  => 'required|boolean',
            'body_content'    => 'required|string|max:500'
        ]);

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
        return redirect()->route('post.show', $post_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id)
    {
        $post = $this->post->findOrFail($post_id);

        //  投稿の所有者かチェック(AppServicePrividerから)
        if (Gate::denies('isOwner', $post)) {
            return redirect()->route('post.index');
        }

        $post->delete();

        return redirect()->route('post.index');
    }
}
