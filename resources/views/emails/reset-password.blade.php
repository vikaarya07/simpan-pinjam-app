<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.mail.reset_password.subject') }}</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, Helvetica, sans-serif; color: #27272a;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 16px;">

                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width: 560px; background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="padding: 32px 32px 26px; background: #059669;">

                            <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name') }}" width="60"
                                height="60"
                                style="display: block; width: 64px; height: 64px; object-fit: contain; border: 0;">

                            <div
                                style="margin-top: 16px; color: #ffffff; font-size: 22px; line-height: 1.3; font-weight: 700; letter-spacing: 0.3px;">
                                SATYA MUDA GETAS
                            </div>

                            <div
                                style="margin-top: 6px; color: #d1fae5; font-size: 14px; line-height: 1.4; font-weight: 600; letter-spacing: 1.5px;">
                                SIMPAN PINJAM
                            </div>

                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 40px 40px 36px;">

                            <div style="text-align: center; margin-bottom: 26px;">
                                <div
                                    style="display: inline-block; width: 64px; height: 64px; line-height: 64px; background: #ecfdf5; color: #059669; border-radius: 50%; font-size: 28px; font-weight: bold;">
                                    🔐
                                </div>
                            </div>

                            <h1
                                style="margin: 0 0 12px; text-align: center; font-size: 25px; line-height: 1.3; color: #18181b;">
                                {{ __('app.mail.reset_password.title') }}
                            </h1>

                            <p
                                style="margin: 0 0 18px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a;">

                                {{ __('app.mail.reset_password.greeting') }}

                                <strong style="color: #27272a;">
                                    {{ $user->name }}
                                </strong>,

                            </p>

                            <p
                                style="margin: 0 0 28px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a;">

                                {{ __('app.mail.reset_password.request_description', [
                                    'app' => config('app.name'),
                                ]) }}

                            </p>

                            {{-- Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td align="center">

                                        <a href="{{ $resetUrl }}"
                                            style="display: inline-block; padding: 14px 28px; background: #059669; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 15px; font-weight: 700;">

                                            {{ __('app.mail.reset_password.reset_button') }}

                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <p
                                style="margin: 28px 0 0; text-align: center; font-size: 13px; line-height: 1.6; color: #a1a1aa;">

                                {{ __('app.mail.reset_password.expires', [
                                    'minutes' => config('auth.passwords.users.expire'),
                                ]) }}

                            </p>

                        </td>
                    </tr>

                    {{-- Alternative URL --}}
                    <tr>
                        <td style="padding: 0 40px 34px;">

                            <div style="padding: 18px; background: #f4f4f5; border-radius: 10px;">

                                <p style="margin: 0 0 8px; font-size: 12px; font-weight: 700; color: #52525b;">

                                    {{ __('app.mail.reset_password.button_not_working') }}

                                </p>

                                <p
                                    style="margin: 0; font-size: 11px; line-height: 1.6; color: #71717a; word-break: break-all;">

                                    {{ __('app.mail.reset_password.copy_link') }}

                                </p>

                                <p style="margin: 8px 0 0; font-size: 11px; line-height: 1.6; word-break: break-all;">

                                    <a href="{{ $resetUrl }}" style="color: #059669;">
                                        {{ $resetUrl }}
                                    </a>

                                </p>

                            </div>

                        </td>
                    </tr>

                    {{-- Security --}}
                    <tr>
                        <td style="padding: 0 40px 36px;">

                            <p
                                style="margin: 0; text-align: center; font-size: 12px; line-height: 1.6; color: #a1a1aa;">

                                {{ __('app.mail.reset_password.not_requested') }}

                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding: 22px 32px; background: #fafafa; border-top: 1px solid #f4f4f5; text-align: center;">

                            <p style="margin: 0; font-size: 12px; color: #a1a1aa;">

                                © {{ date('Y') }}
                                {{ config('app.name') }}.
                                {{ __('app.mail.reset_password.all_rights_reserved') }}

                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>