@extends('Admin.layouts.master')

@section('content')
<section class="form-section" id="edit-article">
    <h2>ویرایش مقاله</h2>
    <div class="card">
        <form method="POST" action="{{ route('panel.article.update', $article->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">تصویر مقاله</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @if($article->image)
                    <div class="image-preview">
                        <img src="{{ asset('AdminAssets/Article-image/' . $article->image) }}" alt="تصویر فعلی مقاله" style="max-height: 150px; border-radius: 8px; margin-top: 1rem;">
                    </div>
                @endif
                @error('image')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="title">عنوان مقاله</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="status">وضعیت</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="1" {{ old('status', $article->status) == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ old('status', $article->status) == 0 ? 'selected' : '' }}>غیرفعال</option>
                </select>
                @error('status')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">متن مقاله</label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

     

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">ذخیره تغییرات</button>
                <a href="{{ route('panel.article.index') }}" class="btn btn-cancel">لغو</a>
            </div>
        </form>
    </div>
</section>

<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
        margin: 3rem auto;
    }

    .form-section h2 {
        font-family: 'Vazir', sans-serif;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.5rem;
    }

    .card {
        padding: 1rem;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 5px rgba(67, 160, 71, 0.3);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-control.is-invalid {
        border-color: var(--accent-color);
    }

    .error {
        color: var(--accent-color);
        font-size: 0.9rem;
        margin-top: 0.25rem;
        display: block;
    }

    .image-preview {
        margin-top: 1rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 25px;
        font-family: 'Vazir', sans-serif;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn-submit {
        background: var(--accent-color);
        color: white;
    }

    .btn-submit:hover {
        background: var(--secondary-color);
        transform: scale(1.05);
    }

    .btn-cancel {
        background: #ddd;
        color: var(--text-color);
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-cancel:hover {
        background: #ccc;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-group {
            min-width: 100%;
        }

        .form-section {
            margin: 1rem;
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
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
