<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    article: {
        type: Object,
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
</script>

<template>
    <Head :title="article.title" />

    <AgencyLayout>
        <article class="px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <Link
                    :href="route('blog.index')"
                    class="text-sm font-medium text-blue-400 transition hover:text-blue-300"
                >
                    ← Tüm içgörüler
                </Link>

                <header class="mt-6 border-b border-slate-800 pb-8">
                    <time class="text-sm font-medium text-blue-400">
                        {{ formatDate(article.published_at) }}
                    </time>
                    <h1
                        class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        {{ article.title }}
                    </h1>
                </header>

                <div
                    v-if="article.image_url"
                    class="my-8 overflow-hidden rounded-xl border border-slate-800"
                >
                    <img
                        :src="article.image_url"
                        :alt="article.title"
                        class="w-full object-cover"
                    />
                </div>

                <div
                    class="article-prose max-w-3xl text-slate-300"
                    v-html="article.content"
                />
            </div>
        </article>
    </AgencyLayout>
</template>

<style scoped>
.article-prose :deep(p) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    line-height: 1.75;
    color: rgb(203 213 225);
}

.article-prose :deep(h2),
.article-prose :deep(h3) {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: rgb(255 255 255);
}

.article-prose :deep(ul),
.article-prose :deep(ol) {
    margin-top: 1rem;
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.article-prose :deep(li) {
    margin-top: 0.5rem;
}

.article-prose :deep(a) {
    color: rgb(96 165 250);
    text-decoration: underline;
}

.article-prose :deep(strong) {
    color: rgb(255 255 255);
}
</style>
