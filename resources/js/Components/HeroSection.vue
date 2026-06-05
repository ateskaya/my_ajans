<script setup>
import ThreeScene from '@/Components/ThreeScene.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section
        class="relative flex min-h-[80vh] items-center overflow-hidden bg-slate-950 px-4 sm:px-6 lg:px-8"
    >
        <ThreeScene />

        <!-- Arka plan: radial gradient + ızgara deseni -->
        <div
            class="pointer-events-none absolute inset-0 z-[1] bg-[radial-gradient(ellipse_at_top,_rgba(37,99,235,0.12)_0%,_transparent_55%)]"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute inset-0 z-[1] opacity-40"
            style="
                background-image:
                    linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
                background-size: 48px 48px;
            "
            aria-hidden="true"
        />

        <div class="relative z-10 mx-auto w-full max-w-7xl">
            <div class="max-w-3xl">
                <p
                    class="mb-4 text-sm font-semibold uppercase tracking-widest text-blue-400"
                >
                    Enterprise Yazılım Ajansı
                </p>

                <h1
                    class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl"
                >
                    Otonom Sistemler ve Ölçeklenebilir Web Çözümleri
                </h1>

                <p class="mt-6 text-lg leading-relaxed text-slate-400 sm:text-xl">
                    Yapay zeka entegrasyonları ve modern mimarilerle işletmenizin
                    dijital dönüşümünü hızlandırıyoruz.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center">
                    <Link
                        :href="route('wizard.index')"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.45)] transition-all duration-200 hover:bg-blue-500 hover:shadow-[0_0_32px_rgba(59,130,246,0.55)] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-950"
                    >
                        Hemen Projeyi Başlat
                    </Link>

                    <Link
                        :href="route('services.index')"
                        class="inline-flex items-center justify-center rounded-md border border-slate-700 bg-slate-950/50 px-6 py-3 text-sm font-semibold text-slate-300 transition-colors duration-200 hover:border-slate-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-600 focus:ring-offset-2 focus:ring-offset-slate-950"
                    >
                        Teknolojilerimiz
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
