<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    articles: {
        type: Array,
        required: true,
    },
});

const formatDate = (dateString) => {
    if (!dateString) {
        return '';
    }

    return new Date(dateString).toLocaleDateString('tr-TR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
};

const excerpt = (html, length = 160) => {
    const text = html.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();

    return text.length > length ? `${text.slice(0, length)}…` : text;
};
</script>

<template>
    <Head title="İçgörüler" />

    <AgencyLayout>
        <PageHeader
            eyebrow="SEO & Teknoloji"
            title="İçgörüler"
            description="RSS kaynaklarından otonom üretilen, Gemini AI ile özgünleştirilmiş teknoloji ve yazılım içgörüleri."
        />

        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div
                    v-if="articles.length === 0"
                    class="rounded-xl border border-slate-800 bg-slate-900/40 px-6 py-16 text-center text-slate-300"
                >
                    Henüz yayınlanmış makale yok. İlk içeriği üretmek için
                    <code class="text-blue-300">php artisan app:auto-generate-articles</code>
                    komutunu çalıştırın.
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="article in articles"
                        :key="article.id"
                        class="group flex flex-col overflow-hidden rounded-xl border border-slate-800 bg-slate-900/50 transition-all duration-300 hover:-translate-y-1 hover:border-blue-500"
                    >
                        <div
                            v-if="article.image_url"
                            class="aspect-video overflow-hidden border-b border-slate-800"
                        >
                            <img
                                :src="article.image_url"
                                :alt="article.title"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            />
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <time class="text-xs font-medium text-blue-300">
                                {{ formatDate(article.published_at) }}
                            </time>
                            <h2
                                class="mt-2 text-lg font-semibold text-white transition-colors group-hover:text-blue-300"
                            >
                                {{ article.title }}
                            </h2>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-300">
                                {{ excerpt(article.content) }}
                            </p>
                            <Link
                                :href="route('blog.show', article.slug)"
                                class="mt-4 inline-flex text-sm font-medium text-blue-300 hover:text-blue-200"
                            >
                                {{ article.title }} makalesini oku
                                <span aria-hidden="true"> →</span>
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </AgencyLayout>
</template>
