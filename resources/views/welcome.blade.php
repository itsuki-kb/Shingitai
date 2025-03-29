<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- 和風で読みやすいフォント（Noto Sans JP） --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap">
    {{-- タイトル用フォント --}}
    <link href="https://fonts.googleapis.com/css2?family=Nico+Moji&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine JS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-stone-100 text-stone-800 bg-[url('/public/images/washi-white.jpg')] bg-cover bg-center">
    <div class="min-h-screen flex flex-col sm:justify-center items-center">
        {{-- サイトタイトル --}}
        <header class="w-full lg:max-w-4xl text-sm mb-6 flex-col pt-16">
            <div class="flex justify-center mt-2">
                <h1 class="text-7xl" style="font-family: 'Nico Moji', serif">心技体</h1>
                <x-application-logo class="w-20 h-20 fill-current" />
            </div>
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        {{-- メイン --}}
        <main class="w-full max-w-7xl min-w-[640px] mx-auto flex flex-col ">
            {{-- 🔸心技体とは --}}
            <section class="snap-start flex bg-stone-100 bg-opacity-20 rounded-2xl shadow-lg p-8 my-8">
                <div class="w-1/4 flex ">
                    <x-application-logo class="block w-100 w-auto fill-current text-red-800" />
                </div>
                <div class="w-3/4 p-8 flex flex-col content-center">
                    <h2 class="text-2xl font-bold mb-4">心技体とは</h2>

                    <h3 class="text-xl py-4">心技体は、日々少しずつ良い方向に人生を進めるための、生活記録共有サービスです。</h3>

                    <p class="text-sm leading-loose pb-2">
                        私たちは誰しも、幸せな人生を送りたいと考えています。しかし、幸せとは何なのか...。使い古されたこの質問に、絶対的な答えは見つかっていません。
                        楽しい時間を過ごすこと？学び、働き、お金を稼ぎ、世の為人の為に貢献すること？健康な老後を迎えること？
                        どれも大切ではありますが、何かに偏って別の何かを犠牲にすることは、できれば避けたいところではないでしょうか。
                        「そこそこに、満遍なく、満たされた生活を送ること」。心技体は、この実現をサポートするために生まれました。<br>
                    </p>

                    <p class="text-sm leading-loose pb-2">
                        さて、「満遍なく」と言っても、何から手をつければ良いでしょうか。
                        ただでさえ私たちは昨今の情報社会において、「あれをしろ、これをしろ」と果てしない広告、周囲の目、世間体に疲れ果てています。
                        こうした外的要因に判断基準を委ねることは危険です。ひとつ達成すれば、また新たな「やることリスト」が束になって襲ってきます。<br>
                    </p>

                    <p class="text-sm leading-loose pb-2">
                        そこで思い出したのが、柔道家・道長伯が述べたという「心技体」という言葉です。
                        私たちの人生観は様々ですが、<br>
                        <ul>
                            <li class="text-sm leading-loose">心：日々ちょっとした喜びを感じ、</li>
                            <li class="text-sm leading-loose">技：日々僅かな成長を続け、</li>
                            <li class="text-sm leading-loose pb-2">体：日々少しだけ健康に気を遣って、</li>
                        </ul>
                        <span  class="text-sm leading-loose">
                            そんな生活を続けられれば、長期的により「満遍ない」幸せに近付いていけるのではないでしょうか。
                            心技体とともに日々の「心技体」を記録し、振り返ることで、私たちがより良い人生を歩めることを願っています。
                        </span>
                    </p>

                </div>
            </section>

            {{-- このアプリの使い方 --}}
            <section class="snap-start flex bg-stone-100 bg-opacity-20 rounded-2xl shadow-lg p-8 my-8">
                <div class="w-1/4 flex ">
                    <x-application-logo class="block w-100 w-auto fill-current text-blue-800" />
                </div>
                <div class="w-3/4 p-8">
                    <h2 class="text-2xl font-bold mb-4">心技体の使い方</h2>

                    <h3 class="text-xl py-4">毎日の「心技体」を記録し、振り返り、継続を目指しましょう。</h3>

                    <ul>
                        <li class="text-sm leading-loose">・日付を選択し、その日の「心技体」の状態と記録を入力します。</li>
                        <li class="text-sm leading-loose">・状態は「太陽マーク☀️」「月マーク🌙」から選択します。その日の自分に満足していれば太陽を、そうでなければ月を選択してください。</li>
                        <li class="text-sm leading-loose">・記録には、あなたの気持ち、行動、目標などを自由に記入してください。</li>
                        <li class="text-sm leading-loose">・「心技体」の分類は自由です。例えば「お昼にサバ味噌を食べた」場合でも、以下のようなパターンが考えられます。
                            <ul>
                                <li class="text-sm leading-loose ms-4">- あなたの好物がサバ味噌で、心を満たされたなら「心」に</li>
                                <li class="text-sm leading-loose ms-4">- レシピを検索して、作り方を覚えたなら「技」に</li>
                                <li class="text-sm leading-loose ms-4">- タンパク質を摂って健康的な気分になったなら「体」に</li>
                            </ul>
                        </li>
                        <li class="text-sm leading-loose">・各ユーザーの投稿は、投稿一覧に共有されます。</li>
                        <li class="text-sm leading-loose">・各ユーザーの投稿は、投稿一覧に共有されます。見習いたい投稿や、応援したい投稿などには、ハートボタンを押してLikeしてください。</li>
                        <li class="text-sm leading-loose">・マイページでは、直近1週間の「心技体」の状態を一覧できるカレンダー機能があります。太陽マークが続くことを目指し、月マークが続いていれば自分を労わってあげてください。</li>
                    </ul>
                </div>
            </section>

            {{-- ロゴについて --}}
            <section class="snap-start flex bg-stone-100 bg-opacity-20 rounded-2xl shadow-lg p-8 my-8">
                <div class="w-1/4 flex ">
                    <x-application-logo class="block w-100 w-auto fill-current text-green-800" />
                </div>
                <div class="w-3/4 p-8">
                    <h2 class="text-2xl font-bold mb-4">ロゴについて</h2>

                    <h3 class="text-xl py-4">江戸時代の禅僧・仙厓義梵の絵画『蕪画讃』をイメージした丸いカブです。</h3>

                    <p class="text-sm leading-loose pb-2">
                        きっかけは製作者が「心技体」という言葉から連想した、仙厓義梵の絵画『○△◻︎』です。
                        『○△◻︎』の正しい解釈はわかりませんが、丸い心と伸ばした技、安定した体という心技体のイメージに近しいものを感じました。
                        そこでまずは『○△◻︎』をモチーフとしたロゴをを検討しましたが、少し抽象的すぎるように感じ、
                        より具体的で生命力に溢れる「カブ」をモチーフとしました。<br>
                        カブのようにどっしりと根差し、少しずつ大きくなるイメージで、心技体を活用いただけると幸いです。
                    </p>
                </div>
            </section>


        </main>

        {{-- フッター（任意） --}}
        <footer class="text-center text-xs text-stone-500">
            &copy; {{ date('Y') }} Shingitai
        </footer>
    </div>
</body>
</html>

