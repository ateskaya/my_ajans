<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Idempotent demo content for public pages (services, case studies).
     * Safe to run on production: php artisan db:seed --class=ContentSeeder
     */
    public function run(): void
    {
        $softwareIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" /></svg>';
        $aiIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" /></svg>';
        $webIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a2.25 2.25 0 0 1-2.25-2.25m2.25 2.25a2.25 2.25 0 0 0 2.25-2.25m-2.25 2.25V6.75m0 0a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v5.25m-18 0a2.25 2.25 0 0 0 2.25 2.25" /></svg>';

        $services = [
            [
                'title' => 'Özel Yazılım Geliştirme',
                'slug' => 'ozel-yazilim-gelistirme',
                'excerpt' => 'İş süreçlerinize özel, ölçeklenebilir ve güvenli yazılım çözümleri tasarlıyor ve geliştiriyoruz.',
                'description' => 'Kurumsal ihtiyaçlarınıza uygun mimari kararlar, modern teknoloji yığınları ve sürdürülebilir kod standartlarıyla uçtan uca yazılım geliştirme hizmeti sunuyoruz. MVP\'den enterprise seviyeye kadar tüm aşamalarda yanınızdayız.',
                'icon_name' => 'code-bracket',
                'icon_svg' => $softwareIconSvg,
                'image_url' => '/images/services/software.webp',
                'is_active' => true,
            ],
            [
                'title' => 'Yapay Zeka Entegrasyonları',
                'slug' => 'yapay-zeka-entegrasyonlari',
                'excerpt' => 'LLM, otomasyon ve akıllı analiz yeteneklerini mevcut ürün ve operasyonlarınıza entegre ediyoruz.',
                'description' => 'Müşteri destek botları, doküman analizi, tahminsel modeller ve iş akışı otomasyonları ile yapay zekayı somut ROI\'ye dönüştürüyoruz. Güvenlik, veri gizliliği ve maliyet optimizasyonu önceliğimizdir.',
                'icon_name' => 'cpu-chip',
                'icon_svg' => $aiIconSvg,
                'image_url' => '/images/services/ai.webp',
                'is_active' => true,
            ],
            [
                'title' => 'Ölçeklenebilir Web Sistemleri',
                'slug' => 'olceklenebilir-web-sistemleri',
                'excerpt' => 'Yüksek trafikli, performans odaklı ve bulut-native web platformları inşa ediyoruz.',
                'description' => 'E-ticaret, SaaS ve kurumsal portallar için CDN, cache, mikroservis ve gözlemlenebilirlik katmanlarıyla ölçeklenebilir web altyapıları kuruyoruz. Google Ads ve SEO performansını destekleyen hızlı yükleme süreleri hedefliyoruz.',
                'icon_name' => 'server-stack',
                'icon_svg' => $webIconSvg,
                'image_url' => '/images/services/web.webp',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                $service,
            );
        }

        $caseStudies = [
            [
                'title' => 'X E-ticaret Firmasının Altyapı Modernizasyonu',
                'slug' => 'x-eticaret-altyapi-modernizasyonu',
                'client_name' => 'X E-ticaret A.Ş.',
                'problem' => 'Monolitik altyapı yoğun kampanya dönemlerinde yavaşlıyor, sepet terk oranları artıyor ve operasyon ekibi manuel müdahalelerle zaman kaybediyordu.',
                'solution' => 'Laravel tabanlı modüler mimariye geçiş, Redis cache katmanı, queue tabanlı sipariş işleme ve CDN entegrasyonu ile uçtan uca performans optimizasyonu uyguladık.',
                'impact_metrics' => [
                    'speed_increase' => '40%',
                    'conversion_lift' => '18%',
                    'infrastructure_cost_reduction' => '22%',
                    'uptime' => '99.95%',
                ],
                'cover_image' => '/images/case-studies/ecommerce.webp',
                'is_featured' => true,
            ],
            [
                'title' => 'Y SaaS Platformunun AI Destekli Müşteri Deneyimi',
                'slug' => 'y-saas-ai-musteri-deneyimi',
                'client_name' => 'Y SaaS Teknoloji',
                'problem' => 'Destek talepleri 48 saat içinde yanıtlanamıyor, müşteri memnuniyeti düşüyor ve ekip tekrarlayan sorularla meşgul kalıyordu.',
                'solution' => 'Ürün içi AI asistan, bilgi bankası RAG pipeline\'ı ve otomatik ticket sınıflandırma ile destek sürecini yeniden tasarladık.',
                'impact_metrics' => [
                    'first_response_time_reduction' => '65%',
                    'support_ticket_volume_reduction' => '38%',
                    'nps_increase' => '+24 puan',
                    'monthly_ops_savings' => '120.000 TL',
                ],
                'cover_image' => '/images/case-studies/saas-ai.webp',
                'is_featured' => true,
            ],
        ];

        foreach ($caseStudies as $caseStudy) {
            CaseStudy::query()->updateOrCreate(
                ['slug' => $caseStudy['slug']],
                $caseStudy,
            );
        }
    }
}
