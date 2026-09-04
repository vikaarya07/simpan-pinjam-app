<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Email</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, Helvetica, sans-serif; color: #27272a;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 16px;">

                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style=" max-width: 560px; background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06); ">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style=" padding: 32px 32px 26px; background: #059669; ">

                            <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name') }}" width="60"
                                height="60"
                                style="display: block; width: 64px; height: 64px; object-fit: contain; border: 0; ">

                            <div
                                style="margin-top: 16px; color: #ffffff; font-size: 22px; line-height: 1.3; font-weight: 700; letter-spacing: 0.3px;">
                                {{ __('SATYA MUDA GETAS') }}
                            </div>

                            <div
                                style="margin-top: 6px; color: #d1fae5; font-size: 14px; line-height: 1.4; font-weight: 600; letter-spacing: 1.5px;">
                                {{ __('SIMPAN PINJAM') }}
                            </div>

                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding: 40px 40px 36px;">

                            <div style=" text-align: center; margin-bottom: 28px; ">

                                <div
                                    style=" display: inline-block; width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background: #ecfdf5; color: #059669; font-size: 28px; font-weight: bold; ">
                                    <flux:icon.check-badge color="emerald" />
                                </div>

                            </div>

                            <h1
                                style=" margin: 0 0 12px; text-align: center; font-size: 25px; line-height: 1.3; color: #18181b; ">
                                Verifikasi Email Anda
                            </h1>

                            <p
                                style=" margin: 0 0 18px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a; ">
                                Halo <strong style="color: #27272a;">
                                    {{ $user->name }}
                                </strong>,
                            </p>

                            <p
                                style=" margin: 0 0 28px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a; ">
                                Terima kasih telah membuat akun di
                                <strong style="color: #059669;">
                                    {{ config('app.name') }}
                                </strong>.
                                Silakan verifikasi alamat email Anda untuk mengaktifkan akun.
                            </p>

                            {{-- Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td align="center">

                                        <a href="{{ $verificationUrl }}"
                                            style=" display: inline-block; padding: 14px 28px; background: #059669; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 15px; font-weight: 700; ">
                                            Verifikasi Email
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <p
                                style=" margin: 28px 0 0; text-align: center; font-size: 13px; line-height: 1.6; color: #a1a1aa; ">
                                Link verifikasi ini berlaku selama <strong>60 menit</strong>.
                            </p>

                        </td>
                    </tr>

                    {{-- Alternative URL --}}
                    <tr>
                        <td style="padding: 0 40px 34px; ">

                            <div style="padding: 18px; background: #f4f4f5; border-radius: 10px; ">

                                <p style="margin: 0 0 8px; font-size: 12px; font-weight: 700; color: #52525b; ">
                                    Tombol tidak dapat diklik?
                                </p>

                                <p
                                    style="margin: 0; font-size: 11px; line-height: 1.6; color: #71717a; word-break: break-all; ">
                                    Salin dan buka link berikut di browser:
                                </p>

                                <p style="margin: 8px 0 0; font-size: 11px; line-height: 1.6; word-break: break-all; ">
                                    <a href="{{ $verificationUrl }}" style="color: #059669;">
                                        {{ $verificationUrl }}
                                    </a>
                                </p>

                            </div>

                        </td>
                    </tr>

                    {{-- Security Notice --}}
                    <tr>
                        <td style="padding: 0 40px 36px; ">

                            <p
                                style="margin: 0; text-align: center; font-size: 12px; line-height: 1.6; color: #a1a1aa; ">
                                Jika Anda tidak membuat akun ini, Anda dapat mengabaikan email ini.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding: 22px 32px; background: #fafafa; border-top: 1px solid #f4f4f5; text-align: center;">

                            <p style="margin: 0; font-size: 12px; color: #a1a1aa; ">
                                © {{ date('Y') }}
                                {{ config('app.name') }}.
                                All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
