<!-- password with meter -->

@php
    if (!isset($field['attributes']['autocomplete'])) {
        $field['attributes']['autocomplete'] = 'new-password';
    }

    $field['attributes']['data-password-meter-input'] = 'true';
    $field['attributes']['data-password-meter-confirmation'] = $field['confirmation_field'] ?? 'password_confirmation';
    $meterId = 'password-meter-'.md5($field['name']);
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div class="future-password-meter" id="{{ $meterId }}" data-password-meter>
        <button type="button" class="future-password-meter__magic" data-password-meter-generate>
            Magic Password <span aria-hidden="true">&#10024;</span> <span>(Clicca qui)</span>
        </button>

        <div class="future-password-visibility">
            <input
                type="password"
                name="{{ $field['name'] }}"
                placeholder="Inserisci password"
                @include('crud::fields.inc.attributes')
            >
            <button type="button" class="future-password-visibility__toggle" aria-label="Mostra password" aria-pressed="false" data-password-visibility-toggle>
                <i class="la la-eye-slash" aria-hidden="true"></i>
            </button>
        </div>

        <p class="future-password-meter__hint">Usa 8 o piu caratteri con una combinazione di lettere e numeri.</p>

        <div class="future-password-meter__panel" aria-live="polite">
            <div class="future-password-meter__title">Password Recipe:</div>
            <ul class="future-password-meter__rules">
                <li data-password-rule="length"><span class="future-password-meter__rule-icon" aria-hidden="true"></span>Minimo 8 caratteri</li>
                <li data-password-rule="lowercase"><span class="future-password-meter__rule-icon" aria-hidden="true"></span>Almeno una lettera minuscola (a-z)</li>
                <li data-password-rule="uppercase"><span class="future-password-meter__rule-icon" aria-hidden="true"></span>Almeno una lettera maiuscola (A-Z)</li>
                <li data-password-rule="number"><span class="future-password-meter__rule-icon" aria-hidden="true"></span>Almeno un numero (0-9)</li>
            </ul>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@push('after_styles')
    <style>
        .future-password-meter {
            max-width: 560px;
        }

        .future-password-meter__magic {
            border: 0;
            background: transparent;
            color: #2f3650;
            font-weight: 600;
            padding: 0;
            margin: 0 0 10px;
            cursor: pointer;
        }

        .future-password-meter__magic:hover {
            color: #2f66d7;
        }

        .future-password-visibility {
            position: relative;
        }

        .future-password-visibility .form-control {
            padding-right: 46px;
        }

        .future-password-visibility__toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            width: 30px;
            height: 30px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #7a86a3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 2;
        }

        .future-password-visibility__toggle:hover {
            color: #2f66d7;
            background: #eef4ff;
        }

        .future-password-visibility__toggle i {
            font-size: 18px;
            line-height: 1;
        }

        .future-password-meter__hint {
            margin: 8px 0 12px;
            color: #9aa3bd;
            font-size: .9rem;
            line-height: 1.35;
        }

        .future-password-meter__panel {
            border: 1px solid #e8edf7;
            border-radius: 12px;
            background: #fbfcff;
            padding: 22px 26px;
        }

        .future-password-meter__title {
            color: #2f3650;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .future-password-meter__rules {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 12px;
        }

        .future-password-meter__rules li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ff4267;
            font-weight: 500;
        }

        .future-password-meter__rule-icon {
            width: 20px;
            display: inline-flex;
            justify-content: center;
            color: #ff4267;
            font-weight: 700;
        }

        .future-password-meter__rule-icon::before {
            content: "x";
        }

        .future-password-meter__rules li.is-valid {
            color: #1f9f74;
        }

        .future-password-meter__rules li.is-valid .future-password-meter__rule-icon {
            color: #1f9f74;
        }

        .future-password-meter__rules li.is-valid .future-password-meter__rule-icon::before {
            content: "\2713";
        }
    </style>
@endpush

@push('after_scripts')
    <script>
        (function () {
            function randomInt(max) {
                if (window.crypto && window.crypto.getRandomValues) {
                    var values = new Uint32Array(1);
                    window.crypto.getRandomValues(values);
                    return values[0] % max;
                }

                return Math.floor(Math.random() * max);
            }

            function shuffle(chars) {
                for (var i = chars.length - 1; i > 0; i--) {
                    var j = randomInt(i + 1);
                    var temp = chars[i];
                    chars[i] = chars[j];
                    chars[j] = temp;
                }

                return chars;
            }

            function generatePassword() {
                var lowercase = 'abcdefghjkmnpqrstuvwxyz';
                var uppercase = 'ABCDEFGHJKMNPQRSTUVWXYZ';
                var numbers = '23456789';
                var symbols = '!@#$%&*?';
                var all = lowercase + uppercase + numbers + symbols;
                var password = [
                    lowercase[randomInt(lowercase.length)],
                    uppercase[randomInt(uppercase.length)],
                    numbers[randomInt(numbers.length)],
                    symbols[randomInt(symbols.length)]
                ];

                while (password.length < 12) {
                    password.push(all[randomInt(all.length)]);
                }

                return shuffle(password).join('');
            }

            function updateMeter(root, value) {
                var checks = {
                    length: value.length >= 8,
                    lowercase: /[a-z]/.test(value),
                    uppercase: /[A-Z]/.test(value),
                    number: /[0-9]/.test(value)
                };

                Object.keys(checks).forEach(function (rule) {
                    var item = root.querySelector('[data-password-rule="' + rule + '"]');
                    if (!item) {
                        return;
                    }

                    item.classList.toggle('is-valid', checks[rule]);
                });
            }

            function updateToggleButton(button, isVisible) {
                var icon = button ? button.querySelector('i') : null;
                if (!button || !icon) {
                    return;
                }

                button.setAttribute('aria-pressed', isVisible ? 'true' : 'false');
                button.setAttribute('aria-label', isVisible ? 'Nascondi password' : 'Mostra password');
                icon.className = isVisible ? 'la la-eye' : 'la la-eye-slash';
            }

            function setPasswordVisibility(input, isVisible) {
                var wrapper = input.closest ? input.closest('.future-password-visibility') : input.parentNode;
                var button = wrapper ? wrapper.querySelector('[data-password-visibility-toggle]') : null;

                input.type = isVisible ? 'text' : 'password';
                updateToggleButton(button, isVisible);
            }

            function bindPasswordVisibility(input) {
                var wrapper;
                var button;

                if (!input || input.getAttribute('data-password-visibility-ready') === 'true') {
                    return;
                }

                wrapper = input.closest ? input.closest('.future-password-visibility') : null;
                if (!wrapper) {
                    wrapper = document.createElement('div');
                    wrapper.className = 'future-password-visibility';
                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(input);
                }

                button = wrapper.querySelector('[data-password-visibility-toggle]');
                if (!button) {
                    button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'future-password-visibility__toggle';
                    button.setAttribute('aria-label', 'Mostra password');
                    button.setAttribute('aria-pressed', 'false');
                    button.setAttribute('data-password-visibility-toggle', 'true');
                    button.innerHTML = '<i class="la la-eye-slash" aria-hidden="true"></i>';
                    wrapper.appendChild(button);
                }

                input.setAttribute('data-password-visibility-ready', 'true');
                updateToggleButton(button, input.type === 'text');

                button.addEventListener('click', function () {
                    setPasswordVisibility(input, input.type === 'password');
                    input.focus();
                });
            }

            document.querySelectorAll('[data-password-meter]').forEach(function (root) {
                var input = root.querySelector('[data-password-meter-input]');
                var button = root.querySelector('[data-password-meter-generate]');
                var confirmationName;
                var confirmation;

                if (!input) {
                    return;
                }

                confirmationName = input.getAttribute('data-password-meter-confirmation');
                confirmation = confirmationName ? document.querySelector('[name="' + confirmationName + '"]') : null;

                bindPasswordVisibility(input);
                bindPasswordVisibility(confirmation);

                input.addEventListener('input', function () {
                    updateMeter(root, input.value);
                });

                if (button) {
                    button.addEventListener('click', function () {
                        var password = generatePassword();

                        input.value = password;
                        setPasswordVisibility(input, true);

                        if (confirmation) {
                            confirmation.value = password;
                            setPasswordVisibility(confirmation, true);
                        }

                        updateMeter(root, password);
                        input.focus();
                    });
                }

                updateMeter(root, input.value);
            });
        })();
    </script>
@endpush
