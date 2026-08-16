@php
    $name = $name ?? 'content';
    $id = $id ?? $name;
    $value = $value ?? '';
    $rows = $rows ?? 8;
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    class="form-control rich-editor @error($name) is-invalid @enderror"
>{{ old($name, $value) }}</textarea>
@error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
    @endpush

    @push('scripts')
        <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
            }
        }
        </script>
        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Underline,
                Link,
                List,
                Paragraph,
                Heading,
                BlockQuote,
                Image,
                ImageToolbar,
                ImageUpload,
                ImageCaption,
                ImageStyle,
                Table,
                TableToolbar,
                MediaEmbed,
                SourceEditing,
                GeneralHtmlSupport
            } from 'ckeditor5';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const uploadUrl = @json(route('admin.media.editor-upload'));

            class LaravelUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file.then((file) => new Promise((resolve, reject) => {
                        const data = new FormData();
                        data.append('upload', file);
                        data.append('_token', csrfToken);

                        fetch(uploadUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: data,
                            credentials: 'same-origin',
                        })
                            .then(async (response) => {
                                const json = await response.json().catch(() => ({}));
                                if (!response.ok) {
                                    reject(json.message || 'Upload failed');
                                    return;
                                }
                                resolve({ default: json.url || json.default });
                            })
                            .catch((err) => reject(err?.message || 'Upload failed'));
                    }));
                }

                abort() {}
            }

            function LaravelUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new LaravelUploadAdapter(loader);
            }

            document.querySelectorAll('textarea.rich-editor').forEach((el) => {
                ClassicEditor.create(el, {
                    plugins: [
                        Essentials, Bold, Italic, Underline, Link, List, Paragraph, Heading,
                        BlockQuote, Image, ImageToolbar, ImageUpload, ImageCaption, ImageStyle,
                        Table, TableToolbar, MediaEmbed, SourceEditing, GeneralHtmlSupport,
                        LaravelUploadAdapterPlugin,
                    ],
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'underline', 'link', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'uploadImage', 'insertTable', 'mediaEmbed', '|', 'sourceEditing', 'undo', 'redo',
                    ],
                    image: {
                        toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'],
                    },
                }).catch(console.error);
            });
        </script>
    @endpush
@endonce
