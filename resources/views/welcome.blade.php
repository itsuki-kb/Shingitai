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
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
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
                    <h2 class="text-2xl font-bold mb-6">心技体とは</h2>

                    <p class="py-4">心技体は、あなたの1日の「心・技・体」を記録・共有するための日記共有アプリです。</p>

                    <p class="leading-loose">
                        ・現代の情報社会において、私たちは「あれをすべき、これをすべき」と大量の情報に囲まれています。<br>
                        ・一方で、自らについて省みる習慣を持つ人は多くありません。<br>
                        ・これにより、私たちは自身の状態を十分に把握せず、<br>
                        <span class="ms-4">時に精神や肉体の健康を損ない、時に成長を続ける志を見失います。<br></span>
                    </p>

                    <p class="leading-loose">
                        ・そこで、人々が日々を振り返り、より良い人生へと進む助けになるよう、心技体は構想されました。<br>
                        ・心技体では、人間を構成する複雑な要素を「心技体」という3つの切り口で捉えます。<br>
                        <span class="ms-4">柔道家 道長伯が述べたというこの言葉は、武道だけでなく、人生全般に応用できるものと考えています。<br></span>
                        <span class="ms-4">日々の「心技体」を記録し振り返ることで、自身の状態を正しく認識し、より良い生活、習慣、人生に繋がります。<br></span>
                    </p>
                </div>
            </section>

            {{-- このアプリの使い方 --}}
            <section class="snap-start flex bg-stone-100 bg-opacity-20 rounded-2xl shadow-lg p-8 my-8">
                <div class="w-1/4 flex ">
                    <x-application-logo class="block w-100 w-auto fill-current text-blue-800" />
                </div>
                <div class="w-3/4 p-8">
                    <h2 class="text-2xl font-bold py-6">心技体の使い方</h2>

                    <p class="py-4">あなたのその日の「心技体」について、状態と記録を投稿できます。</p>

                    <p class="leading-loose">
                        ・ひとつの日付に紐づけられる投稿はひとつまでです。<br>
                        ・「心技体」の状態は、「太陽マーク」「月マーク」から選択します。<br>
                        <span class="ps-4">良い状態では「太陽」を、悪い状態では「月」を選択します。</span><br>
                        ・「心技体」の記録は、あなたの感じたこと、考えたこと、行動したこと、やりたいことなどを記録します。<br>
                        ・より良い「心技体」に必要なものは人それぞれです。自身と向き合った結果を書いてください。<br>
                        ・各ユーザーの投稿は、投稿一覧に共有されます。<br>
                        <span class="ps-4">見習いたい投稿や、応援したい投稿などには、ハートボタンを押してLikeしてください。</span><br>
                        ・マイページでは、直近1週間の「心技体」の状態を一覧できるカレンダー機能もあります。<br>
                        <span class="ps-4">太陽マークが続いていればさらに続くよう試み、月マークが続いていれば自分を労わってあげてください。<br></span>
                    </p>
                </div>
            </section>

            {{-- ロゴについて --}}
            <section class="snap-start flex bg-stone-100 bg-opacity-20 rounded-2xl shadow-lg p-8 my-8">
                <div class="w-1/4 flex ">
                    <x-application-logo class="block w-100 w-auto fill-current text-green-800" />
                </div>
                <div class="w-3/4 p-8">
                    <h2 class="text-2xl font-bold py-6">ロゴについて</h2>

                    <p class="py-4">仙厓義梵の「蕪画讃」をイメージした丸いカブです。</p>

                    <p class="leading-loose">
                        ・きっかけは、製作者が「心技体」という言葉から連想した、江戸時代の禅僧 仙厓義梵の絵画「○△◻︎」です。<br>
                        <span class="ps-4">「○△◻︎」の正しい解釈はわかりませんが、</span><br>
                        <span class="ps-4">丸い心と伸ばした技、安定した体という心技体のイメージに近しいものを感じました。</span><br>
                        ・一方、仙厓義梵の有名な絵画のひとつに「蕪画賛」があります。<br>
                        <span class="ps-4">抽象的な「○△◻︎」より、生命力に溢れる「カブ」の方がより具体的で親しみやすいため、</span><br>
                        <span class="ps-4">「カブ」をロゴデザインに採用しました。描画はchatGPTによるものです。</span><br>
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

