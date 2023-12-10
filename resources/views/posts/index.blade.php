<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>料理一覧ページ</title>
    </head>
    
        <div>
            <div>ホーム</div>
            <form action="/" method="get">
                <input type="search" name="search" placeholder="キーワードで検索">
                <input type="submit" name="submit" value="検索">
            </form>
        </div>
        <body>
        <!-- 投稿ここから -->
        <div class="posts">
            @foreach ($posts as $post)
                <div class="posts_left">
                    <table>
                        <tr>
                            <th>投稿者</th>
                            <td>{{ $post->user->name }}</td>
                        </tr>
                        <tr>
                            <th>料理名</th>
                            <td>{{ $post->meal_name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="posts_right">
                    <table>
                        <tr>
                            <th>投稿日</th>
                            <td>{{ $post->created_at }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    @if($post->is_liked())
                        <a href="/posts/unlike/{{$post->id}}" class="btn btn-success btn-sm">いいね<span class="badge">{{ $post->likes->count() }}</span></a>
                    @else
                        <a href="/posts/like/{{$post->id}}" class="btn btn-success btn-sm">いいね<span class="badge">{{ $post->likes->count() }}</span></a>
                    @endif
                </div>
                
                <!--投稿データのキーでforeach回す-->
            <!-- 高さ指定で余白は色で埋める（Instagram参考）-->
                <div class="tag">
                    <table>
                        <tr>
                            <th>この料理のタグ</th>
                            @foreach($post->tags as $tag)
                            <td><a href="/tags/{{ $tag->id }}">{{ $tag->tag_name }}</a></td>
                            @endforeach
                        </tr>
                    </table>
                </div>
                <div class="stamps_comments">
                    <table>
                        <tr>
                            <th>取得スタンプ数</th>
                            <td>00000</td>
                            <th>コメント数</th>
                            <td>00000</td>
                    </table>
                </div>
                <form action="/posts/{{ $post->id }}">
                    <input type="submit" value="詳細"/>
                </form>
            @endforeach
        </div>
    </body>
    
</html>