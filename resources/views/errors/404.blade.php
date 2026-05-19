<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>404 | {{ config('app.name') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body>
        <main class="product-page">
            <div class="container">
                <section class="product-content-card">
                    <div class="content-card__header">
                        <p class="section-kicker">404</p>
                        <h1>Khong tim thay trang</h1>
                    </div>
                    <p class="section-description">Duong dan nay khong ton tai hoac noi dung da duoc di chuyen.</p>
                    <div class="purchase-actions">
                        <a href="{{ route('home') }}" class="purchase-button purchase-button--primary">Ve trang chu</a>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
