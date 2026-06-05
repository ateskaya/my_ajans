<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Array,
        required: true,
    },
    showPageLink: {
        type: Boolean,
        default: true,
    },
    fullPage: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <section
        id="hizmetler"
        class="border-t border-slate-800 px-4 py-20 sm:px-6 lg:px-8"
        :class="{ 'border-t-0': fullPage }"
    >
        <div class="mx-auto max-w-7xl">
            <div
                v-if="!fullPage"
                class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between"
            >
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Uzmanlık Alanlarımız
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-400">
                        İş hedeflerinize uygun, ölçeklenebilir ve sürdürülebilir
                        teknoloji çözümleri sunuyoruz.
                    </p>
                </div>
                <Link
                    v-if="showPageLink"
                    :href="route('services.index')"
                    class="shrink-0 text-center text-sm font-medium text-blue-400 transition hover:text-blue-300"
                >
                    Tüm hizmetler →
                </Link>
            </div>

            <div
                class="grid grid-cols-1 gap-6 md:grid-cols-2"
                :class="fullPage ? 'lg:grid-cols-3' : 'md:grid-cols-3'"
            >
                <article
                    v-for="service in services"
                    :key="service.id"
                    class="group rounded-xl border border-slate-800 bg-slate-900/50 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-blue-500"
                >
                    <h3 class="text-lg font-semibold text-white">
                        {{ service.title }}
                    </h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-400">
                        {{ service.excerpt }}
                    </p>
                    <p
                        v-if="fullPage && service.description"
                        class="mt-3 text-sm leading-relaxed text-slate-500"
                    >
                        {{ service.description }}
                    </p>
                </article>
            </div>
        </div>
    </section>
</template>
