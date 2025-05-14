<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازیابی رمز عبور</title>
    <style>
        body {
            font-family: 'Iranian Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            direction: rtl;
            text-align: right;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .code {
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            color: #4CAF50;
            margin: 20px 0;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .note {
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>بازیابی رمز عبور</h1>
        </div>
        
        <p>کاربر گرامی،</p>
        <p>کد تایید برای بازیابی رمز عبور شما:</p>
        
        <div class="code">
            {{ $code }}
        </div>
        
        <div class="note">
            <p>این کد به مدت 10 دقیقه معتبر است.</p>
            <p>اگر شما درخواست بازیابی رمز عبور نداده‌اید، این ایمیل را نادیده بگیرید.</p>
        </div>
    </div>
</body>
</html>
