<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>料理投稿ページ</title>
    </head>
        <div>
            <div>編集</div>
            <form action="/create" method="get">
                <!-- 投稿者名をcreate.blade.phpに送りたい -->
            </form>
        </div>
        <body>
        <!-- 投稿ここから -->
        <form action="/mypage/{{$post->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="post_left">
                <table>
                    <tr>
                        <th>料理名</th>
                        <td><input type="text" name="post[meal_name]" value={{ $post->meal_name }} /></td>
                    </tr>
                </table>
            </div>
            
            <!-- 写真のプレビュー表示 -->
            <input type="text" name="post[post_comment]" value={{ $post->post_comment }}></input>
            <div class="tag">
                @foreach($categories as $category)
                <table>
                    <tr>
                        <th>{{ $category->category_name }}</th>
                        @foreach($category->tags as $tag)
                        <td>
                            <label>
                                <input type="checkbox" value={{ $tag->id }} name="tags_array[]">{{ $tag->tag_name }}
                            </label>
                        </td>
                        @endforeach
                    </tr>
                </table>
                @endforeach
            </div>
            <p></p>
            <input type="submit" value="投稿"/>
        </form>
    </body>
</html>