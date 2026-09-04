<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Email Akun Diubah</title>

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

                            <div style="text-align: center; margin-bottom: 26px;">
                                <div
                                    style="display: inline-block; width: 64px; height: 64px; line-height: 64px; background: #ecfdf5; color: #059669; border-radius: 50%; font-size: 28px; font-weight: bold;">
                                    ✉️
                                </div>
                            </div>

                            <h1
                                style="margin: 0 0 12px; text-align: center; font-size: 25px; line-height: 1.3; color: #18181b;">
                                Email Akun Diubah
                            </h1>

                            <p
                                style="margin: 0 0 18px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a;">
                                Halo
                                <strong style="color: #27272a;">
                                    {{ $user->name }}
                                </strong>,
                            </p>

                            @if ($isOldEmail)
                                <p
                                    style="margin: 0 0 28px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a;">
                                    Alamat email yang terhubung dengan akun
                                    {{ config('app.name') }} Anda telah diubah.
                                </p>

                                {{-- Email Information --}}
                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                    style="margin-bottom: 24px;">

                                    <tr>
                                        <td
                                            style="padding: 14px 16px; background: #f4f4f5; border-radius: 10px 10px 0 0;">

                                            <div
                                                style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Email Lama
                                            </div>

                                            <div
                                                style="margin-top: 5px; font-size: 14px; color: #27272a; word-break: break-all;">
                                                {{ $oldEmail }}
                                            </div>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            style="padding: 14px 16px; background: #ecfdf5; border-radius: 0 0 10px 10px;">

                                            <div
                                                style="font-size: 11px; font-weight: 700; color: #047857; text-transform: uppercase; letter-spacing: 0.5px;">
                                                Email Baru
                                            </div>

                                            <div
                                                style="margin-top: 5px; font-size: 14px; color: #065f46; word-break: break-all;">
                                                {{ $newEmail }}
                                            </div>

                                        </td>
                                    </tr>

                                </table>
                            @else
                                <p
                                    style="margin: 0 0 28px; text-align: center; font-size: 15px; line-height: 1.7; color: #71717a;">
                                    Alamat email akun {{ config('app.name') }} Anda
                                    telah berhasil diperbarui menjadi:
                                </p>

                                <div
                                    style="padding: 16px; background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 10px; text-align: center;">

                                    <p
                                        style="margin: 0; font-size: 15px; font-weight: 700; color: #047857; word-break: break-all;">
                                        {{ $newEmail }}
                                    </p>

                                </div>
                            @endif

                        </td>
                    </tr>

                    {{-- Security --}}
                    <tr>
                        <td style="padding: 0 40px 36px;">

                            <div
                                style="padding: 18px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px;">

                                <p
                                    style="margin: 0 0 8px; text-align: center; font-size: 12px; font-weight: 700; color: #c2410c;">
                                    @if ($isOldEmail)
                                        Bukan Anda?
                                    @else
                                        Pemberitahuan Keamanan
                                    @endif
                                </p>

                                <p
                                    style="margin: 0; text-align: center; font-size: 12px; line-height: 1.6; color: #78716c;">

                                    @if ($isOldEmail)
                                        Jika Anda tidak melakukan perubahan email ini,
                                        segera hubungi administrator untuk mengamankan akun Anda.
                                    @else
                                        Jika Anda yang melakukan perubahan ini,
                                        tidak ada tindakan lebih lanjut yang diperlukan.
                                    @endif

                                </p>

                            </div>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding: 22px 32px; background: #fafafa; border-top: 1px solid #f4f4f5; text-align: center;">

                            <p style="margin: 0; font-size: 12px; color: #a1a1aa;">
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
