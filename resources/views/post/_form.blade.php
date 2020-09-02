<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3>{{trans('post.label_newest')}}</h3>
        <a class="btn btn-outline-info" href="{{route('post.index')}}">{{trans('post.label_all')}}</a>
    </div>
    <div class="card-body">
        <form action="{{$route}}" method="post">
            @csrf
            {{$method??''}}
            <div class="form-group">
                <label for="post_title">{{trans('post.label_title')}}</label>
                <input autocomplete="off" value="{{old('post_title', isset($post)?$post->post_title:'')}}" type="text"
                       class="form-control{{$errors->has('post_title')?' is-invalid':''}}"
                       name="post_title">
                @if ($errors->has('post_title'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('post_title') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="post_content">{{trans('post.label_content')}}</label>
                <textarea rows="7" class="form-control{{$errors->has('post_content')?' is-invalid':''}}
                    " name="post_content"
                          id="post_content">{{old('post_content',isset($post)?$post->post_content:'')}}</textarea>
                @if ($errors->has('post_content'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('post_content') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="post_tags">Tag</label>
                <input type="text" class="form-control" name="post_tags"
                       value="{{old('post_tags', isset($post)?$post->all_tags:'')}}"/>
                <p><small>Pisahkan tag dengan koma</small></p>
            </div>
            <div class="form-group">
                <input type="submit" value="{{$label??''}}" class="btn btn-outline-success">
            </div>
        </form>
    </div>
</div>
<script src="{{url('vendor/ckeditor/ckeditor.js')}}"></script>
@section("script")
    <script>
        var editor = CKEDITOR.replace('post_content');
        editor.on('instanceReady', function (event) {
            if (event.editor.getCommand('maximize').state == CKEDITOR.TRISTATE_OFF) ;//ckeck if maximize is off
            event.editor.execCommand('maximize');
        });
        editor.addCommand("cmd_utsmani", {
            exec: function (edt) {
                var mySelection = editor.getSelection();
                var selectedText;

                //Handle for the old Internet Explorer browser
                if (mySelection.getType() == CKEDITOR.SELECTION_TEXT) {
                    if (CKEDITOR.env.ie) {
                        mySelection.unlock(true);
                        selectedText = mySelection.getNative().createRange().text;
                    } else {
                        selectedText = mySelection.getNative();
                    }
                }

                var plainSelectedText = selectedText.toString();
                if (plainSelectedText != "") {
                    var insertedElement = editor.document.createElement('p');
                    insertedElement.setAttribute('class', 'arabic-text');
                    insertedElement.setAttribute('dir', 'rtl');
                    insertedElement.appendText(plainSelectedText);
                    editor.insertElement(insertedElement);
                }
            }
        });

        editor.ui.addButton('utsmani', //button name
            {
                label: 'Use Utsmani Font', //button tooltips (will show up when mouse hovers over the button)
                command: 'cmd_utsmani', // command which is fired to handle event when the button is clicked
                toolbar: 'editing', //name of the toolbar group in which the new button is added
                icon: '{{url("/images/arabic-icon.png")}}' //path to the button's icon
            }
        );
    </script>
@endsection
