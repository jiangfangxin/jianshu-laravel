@extends("layout.main")

@section("content")
    <div class="col-sm-8 blog-main">
        <form action="/posts/{{ $post->id }}" method="POST">
            @method("PUT")
            @csrf
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{ $post->title }}">
            </div>
            <div class="form-group">
                <label>内容</label>
                <div id="content-editor">
                    {!! $post->content !!}
                </div>
                <textarea id="content" name="content" hidden>{!! $post->content !!}</textarea>
            </div>
            @include("layout.error")
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>
            </div><!-- /.blog-main -->
@endsection
