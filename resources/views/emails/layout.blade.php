<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0A0A0A;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #141414;
        }
        .header {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #0A0A0A;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
            color: #ffffff;
        }
        .footer {
            background-color: #0A0A0A;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #D4AF37;
        }
        .footer p {
            margin: 0;
            color: #A0A0A0;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            color: #0A0A0A !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
        .highlight {
            color: #D4AF37;
        }
        .info-box {
            background-color: #0A0A0A;
            border: 1px solid #D4AF37;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #333;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            color: #A0A0A0;
        }
        .value {
            color: #ffffff;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <table class="container" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="header">
                <h1>GoldVault</h1>
            </td>
        </tr>
        <tr>
            <td class="content">
                @yield('content')
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>© {{ date('Y') }} GoldVault. All rights reserved.</p>
                <p style="margin-top: 10px;">This is an automated email. Please do not reply.</p>
            </td>
        </tr>
    </table>
</body>
</html>
