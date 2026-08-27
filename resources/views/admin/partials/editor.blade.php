@php
    $name = $name ?? 'content';
    $id = $id ?? $name;
    $value = $value ?? '';
    $rows = $rows ?? 8;
    $minHeight = $minHeight ?? 280;
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    data-min-height="{{ (int) $minHeight }}"
    class="form-control rich-editor @error($name) is-invalid @enderror"
>{{ old($name, $value) }}</textarea>
@error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

@once
    @push('styles')
        <style>
            .ck.ck-editor { width: 100%; }
            .ck.ck-editor__main > .ck-editor__editable {
                min-height: 280px;
                color: #212529;
            }
            .ck.ck-editor__main > .ck-editor__editable img,
            .ck.ck-content .image img {
                max-width: 100%;
                height: auto;
            }
            .ck.ck-content .image {
                margin: 12px 0;
            }
            .ck.ck-content .image > figcaption {
                font-size: 13px;
                color: #69758a;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            (function () {
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
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: data,
                                credentials: 'same-origin',
                            })
                                .then(async (response) => {
                                    const json = await response.json().catch(() => ({}));
                                    if (! response.ok) {
                                        const firstError = json.errors ? Object.values(json.errors)[0]?.[0] : null;
                                        reject(firstError || json.message || 'Image upload failed');
                                        return;
                                    }
                                    const url = json.url || json.default;
                                    if (! url) {
                                        reject('Upload did not return an image URL');
                                        return;
                                    }
                                    resolve({ default: url });
                                })
                                .catch((err) => reject(err?.message || 'Image upload failed'));
                        }));
                    }

                    abort() {}
                }

                function LaravelUploadAdapterPlugin(editor) {
                    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new LaravelUploadAdapter(loader);
                }

                document.querySelectorAll('textarea.rich-editor').forEach((el) => {
                    const minHeight = parseInt(el.getAttribute('data-min-height') || '280', 10);

                    ClassicEditor.create(el, {
                        extraPlugins: [LaravelUploadAdapterPlugin],
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', 'blockQuote', '|',
                            'uploadImage', 'insertTable', '|',
                            'undo', 'redo',
                        ],
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading2', view: 'h2', title: 'Heading', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Subheading', class: 'ck-heading_heading3' },
                            ],
                        },
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'toggleImageCaption',
                                '|',
                                'imageStyle:inline',
                                'imageStyle:block',
                                'imageStyle:side',
                            ],
                        },
                    }).then((editor) => {
                        editor.editing.view.change((writer) => {
                            writer.setStyle('min-height', minHeight + 'px', editor.editing.view.document.getRoot());
                        });
                    }).catch(console.error);
                });
            })();
        </script>
    @endpush
@endonce
