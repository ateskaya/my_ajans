<?php

return [
    'brand' => env('SEO_BRAND_NAME', 'Otonoma'),
    'city' => 'Bursa',
    'district' => 'Nilüfer',

    /*
    | Yerel SEO blog planı — php artisan app:generate-local-seo-article --all
    */
    'topics' => [
        [
            'keyword' => 'bursa yazılım şirketi',
            'angle' => 'Bursa\'da kurumsal yazılım şirketi seçerken teknik yetkinlik, referanslar ve sürdürülebilir mimari kriterleri',
        ],
        [
            'keyword' => 'bursa nilüfer yazılım firması',
            'angle' => 'Nilüfer\'de faaliyet gösteren yazılım firmalarıyla çalışmanın lojistik, iletişim ve proje yönetimi avantajları',
        ],
        [
            'keyword' => 'bursa web tasarım şirketi',
            'angle' => 'Kurumsal web sitesi ile web uygulaması arasındaki fark; performans, SEO ve dönüşüm odaklı tasarım',
        ],
        [
            'keyword' => 'bursa web yazılım',
            'angle' => 'Ölçeklenebilir web yazılım projelerinde Laravel, Vue ve bulut mimarisi tercihleri',
        ],
        [
            'keyword' => 'bursa yapay zeka entegrasyonu',
            'angle' => 'KOBİ ve kurumsal işletmeler için LLM, RAG ve otonom sistem entegrasyonu use-case\'leri',
        ],
        [
            'keyword' => 'bursa özel yazılım geliştirme',
            'angle' => 'Hazır paket yazılım yerine özel yazılım ne zaman mantıklı; MVP\'den enterprise\'a yol haritası',
        ],
        [
            'keyword' => 'bursa yazılım ajansı',
            'angle' => 'Yazılım ajansı ile freelance veya in-house ekip karşılaştırması; B2B proje yönetimi',
        ],
        [
            'keyword' => 'bursa e-ticaret yazılımı',
            'angle' => 'Yüksek trafikli e-ticaret altyapısı, kampanya dönemleri ve performans optimizasyonu',
        ],
    ],
];
