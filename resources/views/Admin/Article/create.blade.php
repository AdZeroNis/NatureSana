@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="add-article">
    <h2>افزودن مقاله جدید</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.article.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <div class="form-row">
                <div class="form-group">
                    <label for="title">عنوان مقاله</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">تصویر مقاله</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="content">متن مقاله</label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                @error('content')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره مقاله</button>
                <a href="{{ route('panel.article.index') }}" class="btn btn-cancel">لغو</a>
            </div>
        </form>
    </div>
</section>
<!-- No JavaScript needed -->
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('content', {
            language: 'fa',
            height: 400,
            contentsLangDirection: 'rtl',
            toolbar: [
                { name: 'document', items: ['Source'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyRight', 'JustifyCenter', 'JustifyLeft', 'JustifyBlock', '-', 'BidiRtl', 'BidiLtr'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
            ],
            removeButtons: '',
            format_tags: 'p;h1;h2;h3;pre',
            removeDialogTabs: 'image:advanced;link:advanced',
            font_names: 'Vazir;Tahoma;Arial;Times New Roman;Verdana'
        });
    });
</script>
@endsection
