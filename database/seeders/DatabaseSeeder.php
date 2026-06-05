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

        Service::factory()->createMany([
            [
                'title' => 'Özel Yazılım Geliştirme',
                'slug' => 'ozel-yazilim-gelistirme',
                'excerpt' => 'İş süreçlerinize özel, ölçeklenebilir ve güvenli yazılım çözümleri tasarlıyor ve geliştiriyoruz.',
                'description' => 'Kurumsal ihtiyaçlarınıza uygun mimari kararlar, modern teknoloji yığınları ve sürdürülebilir kod standartlarıyla uçtan uca yazılım geliştirme hizmeti sunuyoruz. MVP\'den enterprise seviyeye kadar tüm aşamalarda yanınızdayız.',
                'icon_name' => 'code-bracket',
                'is_active' => true,
            ],
            [
                'title' => 'Yapay Zeka Entegrasyonları',
                'slug' => 'yapay-zeka-entegrasyonlari',
                'excerpt' => 'LLM, otomasyon ve akıllı analiz yeteneklerini mevcut ürün ve operasyonlarınıza entegre ediyoruz.',
                'description' => 'Müşteri destek botları, doküman analizi, tahminsel modeller ve iş akışı otomasyonları ile yapay zekayı somut ROI\'ye dönüştürüyoruz. Güvenlik, veri gizliliği ve maliyet optimizasyonu önceliğimizdir.',
                'icon_name' => 'cpu-chip',
                'is_active' => true,
            ],
            [
                'title' => 'Ölçeklenebilir Web Sistemleri',
                'slug' => 'olceklenebilir-web-sistemleri',
                'excerpt' => 'Yüksek trafikli, performans odaklı ve bulut-native web platformları inşa ediyoruz.',
                'description' => 'E-ticaret, SaaS ve kurumsal portallar için CDN, cache, mikroservis ve gözlemlenebilirlik katmanlarıyla ölçeklenebilir web altyapıları kuruyoruz. Google Ads ve SEO performansını destekleyen hızlı yükleme süreleri hedefliyoruz.',
                'icon_name' => 'server-stack',
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
                'cover_image' => null,
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
                'cover_image' => null,
                'is_featured' => true,
            ],
        ]);

        $this->call(LabProjectSeeder::class);
    }
}
