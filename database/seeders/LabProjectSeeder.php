<?php

namespace Database\Seeders;

use App\Models\LabProject;
use Illuminate\Database\Seeder;

class LabProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LabProject::query()->insert([
            [
                'title' => 'Eresbos',
                'slug' => 'eresbos',
                'short_description' => 'Gemini 2.5 Flash altyapısını kullanarak RSS feed\'lerini analiz eden, otonom yapay zeka tabanlı teknoloji haber motoru.',
                'tech_stack' => json_encode(['Laravel 11', 'Vue 3', 'Gemini AI', 'Otonom Bot']),
                'status' => 'Canlıda',
                'project_url' => null,
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kenacademy AI Asistanı',
                'slug' => 'kenacademy-ai-asistani',
                'short_description' => 'Eğitim dokümanları ve videoları üzerinde eğitilmiş, RAG (Retrieval-Augmented Generation) mimarisiyle çalışan otonom öğrenci destek ve satış asistanı.',
                'tech_stack' => json_encode(['Python', 'Vector DB', 'RAG', 'LLM']),
                'status' => 'Ar-Ge',
                'project_url' => null,
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Launch Lead',
                'slug' => 'launch-lead',
                'short_description' => 'Girişimler ve yazılım projeleri için hızlı müşteri doğrulama ve dashboard yönetim paneli sunan SaaS platformu.',
                'tech_stack' => json_encode(['Laravel', 'Inertia.js', 'Tailwind CSS']),
                'status' => 'Beta',
                'project_url' => null,
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Discovery Otonom Filtre',
                'slug' => 'discovery-otonom-filtre',
                'short_description' => 'İş ilanı platformlarından aktif verileri çekip, geçersiz URL\'leri ve kapalı ilanları otonom olarak ayıklayan JavaScript tabanlı filtreleme katmanı.',
                'tech_stack' => json_encode(['JavaScript', 'Web Scraping', 'DOM Manipülasyonu']),
                'status' => 'Canlıda',
                'project_url' => null,
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
