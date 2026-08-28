<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New contact inquiry</title>
</head>
<body style="margin:0;padding:0;background:#f5f7f8;font-family:Inter,Arial,sans-serif;color:#4A5A67;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7f8;padding:24px 12px;">
        <tr>
            <td align="left">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="background:#0e7c86;color:#ffffff;padding:20px 24px;">
                            <div style="font-size:13px;letter-spacing:.08em;text-transform:uppercase;opacity:.85;">LyoVial</div>
                            <h1 style="margin:6px 0 0;font-size:22px;line-height:1.3;">New contact form inquiry</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 18px;">A visitor submitted the contact form on lyovial.ca.</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;width:140px;color:#0e7c86;font-weight:700;">Name</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;">{{ $inquiry->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;color:#0e7c86;font-weight:700;">Email</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;"><a href="mailto:{{ $inquiry->email }}" style="color:#0e7c86;">{{ $inquiry->email }}</a></td>
                                </tr>
                                @if($inquiry->phone)
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;color:#0e7c86;font-weight:700;">Phone</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;">{{ $inquiry->phone }}</td>
                                </tr>
                                @endif
                                @if($inquiry->company)
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;color:#0e7c86;font-weight:700;">Company</td>
                                    <td style="padding:8px 0;border-bottom:1px solid #e8ecee;">{{ $inquiry->company }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:8px 0;color:#0e7c86;font-weight:700;vertical-align:top;">Message</td>
                                    <td style="padding:8px 0;white-space:pre-wrap;">{{ $inquiry->message }}</td>
                                </tr>
                            </table>
                            <p style="margin:22px 0 0;font-size:13px;color:#6b7a86;">Reply to this email to respond directly to the visitor.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
