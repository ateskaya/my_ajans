<?php

namespace Database\Seeders;

use App\Models\ClientProject;
use App\Models\ProjectUpdate;
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

        $this->call(ContentSeeder::class);
        $this->call(LabProjectSeeder::class);
    }
}
