@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if (in_array($resource, ['tickets', 'sections'], true))
        @if ($resource === 'tickets')
            <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
        @endif
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    @endif
    <script>
        (function () {
            function syncEditors() {
                document.querySelectorAll('.js-editor').forEach(function (textarea) {
                    if (textarea.__editor) {
                        textarea.__editor.updateSourceElement();
                    }
                });
            }

            function initEventContentForm() {
                if (window.flatpickr) {
                    document.querySelectorAll('.flatpickr-datetime:not([data-flatpickr-ready])').forEach(function (input) {
                        input.dataset.flatpickrReady = '1';
                        window.flatpickr(input, {
                            enableTime: true,
                            dateFormat: 'Y-m-d H:i',
                            altInput: true,
                            altFormat: 'd F Y H:i',
                            allowInput: true,
                            time_24hr: true,
                        });
                    });

                    document.querySelectorAll('.flatpickr-time:not([data-flatpickr-ready])').forEach(function (input) {
                        input.dataset.flatpickrReady = '1';
                        window.flatpickr(input, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: 'H:i',
                            time_24hr: true,
                            allowInput: true,
                        });
                    });
                }

                if (window.jQuery && window.jQuery.fn.select2) {
                    window.jQuery('.js-select2:not(.select2-hidden-accessible)').each(function () {
                        var options = {
                            width: 'resolve',
                        };

                        if (this.dataset.select2Tags === '1') {
                            options.tags = true;
                            options.placeholder = '-';
                        }

                        window.jQuery(this).select2(options);
                    });
                }

                if (window.Cleave) {
                    document.querySelectorAll('.js-money:not([data-cleave-ready])').forEach(function (input) {
                        input.dataset.cleaveReady = '1';
                        new window.Cleave(input, {
                            numeral: true,
                            numeralDecimalScale: 0,
                            delimiter: '.',
                            numeralDecimalMark: ',',
                        });
                    });
                }

                if (window.ClassicEditor) {
                    document.querySelectorAll('.js-editor:not([data-editor-ready])').forEach(function (textarea) {
                        textarea.dataset.editorReady = '1';
                        window.ClassicEditor.create(textarea, {
                            toolbar: [
                                'heading', '|',
                                'bold', 'italic', '|',
                                'bulletedList', 'numberedList', 'blockQuote', '|',
                                'link', 'insertTable', '|',
                                'undo', 'redo'
                            ],
                        }).then(function (editor) {
                            textarea.__editor = editor;
                        });
                    });
                }

                document.querySelectorAll('form[navigate-form]').forEach(function (form) {
                    if (form.dataset.eventContentReady) {
                        return;
                    }

                    form.dataset.eventContentReady = '1';
                    form.addEventListener('submit', syncEditors, true);
                });

                var partnerType = document.querySelector('[name="partner_type"]');
                var sponsorField = document.querySelector('[data-field-name="sponsor_category"]');
                if (partnerType && sponsorField) {
                    var toggleSponsorField = function () {
                        var isSponsor = partnerType.value === 'sponsor';
                        sponsorField.classList.toggle('hidden', !isSponsor);
                        if (!isSponsor) {
                            sponsorField.querySelector('select').value = '';
                        }
                    };
                    partnerType.addEventListener('change', toggleSponsorField);
                    toggleSponsorField();
                }
            }

            if (window.jQuery) {
                window.jQuery(document)
                    .off('click.eventContentForm', '.js-add-benefit')
                    .on('click.eventContentForm', '.js-add-benefit', function () {
                        var list = this.previousElementSibling;
                        var row = list.querySelector('.js-benefit-row').cloneNode(true);
                        row.querySelector('input').value = '';
                        list.appendChild(row);
                    })
                    .off('click.eventContentForm', '.js-remove-benefit')
                    .on('click.eventContentForm', '.js-remove-benefit', function () {
                        var list = this.closest('.js-benefit-list');
                        if (list.querySelectorAll('.js-benefit-row').length === 1) {
                            this.closest('.js-benefit-row').querySelector('input').value = '';
                            return;
                        }
                        this.closest('.js-benefit-row').remove();
                    })
                    .off('click.eventContentForm', '.js-add-merchandise-addon')
                    .on('click.eventContentForm', '.js-add-merchandise-addon', function () {
                        var list = this.parentElement.querySelector('.js-merchandise-addon-list');
                        var template = document.getElementById('merchandise-addon-template');
                        var index = parseInt(list.dataset.nextIndex || '0', 10);
                        var html = template.innerHTML.split('__INDEX__').join(index);

                        list.dataset.nextIndex = String(index + 1);
                        list.insertAdjacentHTML('beforeend', html);
                        initEventContentForm();
                    })
                    .off('click.eventContentForm', '.js-remove-merchandise-addon')
                    .on('click.eventContentForm', '.js-remove-merchandise-addon', function () {
                        var list = this.closest('.js-merchandise-addon-list');
                        if (list.querySelectorAll('.js-merchandise-addon-row').length === 1) {
                            var row = this.closest('.js-merchandise-addon-row');
                            row.querySelector('select').value = '';
                            row.querySelector('input').value = '1';
                            window.jQuery(row.querySelector('select')).trigger('change');
                            return;
                        }
                        this.closest('.js-merchandise-addon-row').remove();
                    })
                    .off('click.eventContentForm', '.js-add-agenda-item')
                    .on('click.eventContentForm', '.js-add-agenda-item', function () {
                        var list = this.closest('[data-field-name="agenda_items"]').querySelector('.js-agenda-item-list');
                        var template = document.getElementById('agenda-item-template');
                        var index = parseInt(list.dataset.nextIndex || '0', 10);
                        var html = template.innerHTML.split('__INDEX__').join(index);

                        list.dataset.nextIndex = String(index + 1);
                        list.insertAdjacentHTML('beforeend', html);
                        initEventContentForm();
                    })
                    .off('click.eventContentForm', '.js-remove-agenda-item')
                    .on('click.eventContentForm', '.js-remove-agenda-item', function () {
                        var list = this.closest('.js-agenda-item-list');
                        if (list.querySelectorAll('.js-agenda-item-row').length === 1) {
                            var row = this.closest('.js-agenda-item-row');
                            row.querySelector('select').value = '';
                            row.querySelector('[name$="[starts_at]"]').value = '';
                            row.querySelector('[name$="[ends_at]"]').value = '';
                            window.jQuery(row.querySelector('select')).trigger('change');
                            return;
                        }
                        this.closest('.js-agenda-item-row').remove();
                    });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initEventContentForm);
            } else {
                initEventContentForm();
            }
        })();
    </script>
@endpush
