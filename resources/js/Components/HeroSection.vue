<script setup>
import HeroBackground from '@/Components/HeroBackground.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const agency = page.props.agency;
</script>

<template>
    <section
        class="relative flex min-h-[80vh] items-center overflow-hidden bg-slate-950 px-4 sm:px-6 lg:px-8"
    >
        <HeroBackground />

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
                    class="mb-4 text-sm font-semibold uppercase tracking-widest text-blue-300"
                >
                    Enterprise Yazılım Ajansı
                </p>

                <h1
                    class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl"
                >
                    Otonom Sistemler ve Ölçeklenebilir Web Çözümleri
                </h1>

                <p class="mt-6 text-lg leading-relaxed text-slate-300 sm:text-xl">
                    Yapay zeka entegrasyonları ve modern mimarilerle işletmenizin
                    dijital dönüşümünü hızlandırıyoruz.
                </p>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <Link
                            :href="route('wizard.index')"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.45)] transition-all duration-200 hover:bg-blue-500 hover:shadow-[0_0_32px_rgba(59,130,246,0.55)] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-950"
                        >
                            Hemen Teklif Al
                        </Link>

                        <a
                            :href="agency.whatsappUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-md border border-slate-700 bg-transparent px-6 py-3 text-sm font-semibold text-slate-300 transition-colors duration-200 hover:border-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:ring-offset-2 focus:ring-offset-slate-950"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-4 w-4 text-green-500"
                                aria-hidden="true"
                            >
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.435 9.884-9.884 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"
                                />
                            </svg>
                            WhatsApp'tan Sor
                        </a>
                    </div>

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
