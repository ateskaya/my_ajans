<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\ClientProject;
use App\Models\ProjectUpdate;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'ensar@ensar-saas-factory'],
            [
                'name' => 'Ensar Admin',
                'password' => 'password',
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $client = User::query()->updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Test Müşteri',
                'password' => 'password',
                'role' => 'client',
                'email_verified_at' => now(),
            ],
        );

        $project = ClientProject::query()->updateOrCreate(
            [
                'user_id' => $client->id,
                'title' => 'Kurumsal Müşteri Portalı',
            ],
            [
                'description' => 'B2B müşteri portalı: proje takibi, kilometre taşları ve staging ortamı erişimi.',
                'status' => 'gelistirme',
                'progress_percentage' => 35,
                'staging_url' => 'https://staging.example.com',
                'live_url' => null,
                'target_date' => now()->addMonths(3)->toDateString(),
            ],
        );

        ProjectUpdate::query()->updateOrCreate(
            [
                'client_project_id' => $project->id,
                'title' => 'Faz 1: Veritabanı ve yetkilendirme tamamlandı',
            ],
            [
                'content' => 'Kullanıcı rolleri, client_projects ve project_updates tabloları ile admin middleware devreye alındı.',
                'type' => 'kilometre_tasi',
                'is_visible_to_client' => true,
            ],
        );

        ProjectUpdate::query()->updateOrCreate(
            [
                'client_project_id' => $project->id,
                'title' => 'Haftalık durum özeti',
            ],
            [
                'content' => 'Portal arayüz tasarımı ve müşteri dashboard rotaları bir sonraki sprintte planlandı.',
                'type' => 'genel',
                'is_visible_to_client' => true,
            ],
        );

        $softwareIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" /></svg>';
        $aiIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" /></svg>';
        $webIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a2.25 2.25 0 0 1-2.25-2.25m2.25 2.25a2.25 2.25 0 0 0 2.25-2.25m-2.25 2.25V6.75m0 0a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v5.25m-18 0a2.25 2.25 0 0 0 2.25 2.25" /></svg>';

        Service::factory()->createMany([
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
        ]);

        CaseStudy::factory()->createMany([
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
                'cover_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1400&auto=format&fit=crop&q=80',
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
                'cover_image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=1400&auto=format&fit=crop&q=80',
                'is_featured' => true,
            ],
        ]);

        $this->call(LabProjectSeeder::class);
    }
}
