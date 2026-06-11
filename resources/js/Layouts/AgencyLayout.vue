<script setup>
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, defineAsyncComponent, onMounted, ref } from 'vue';

const AiChatWidget = defineAsyncComponent(() =>
    import('@/Components/AiChatWidget.vue'),
);
const DeveloperTerminal = defineAsyncComponent(() =>
    import('@/Components/DeveloperTerminal.vue'),
);
const FloatingContact = defineAsyncComponent(() =>
    import('@/Components/FloatingContact.vue'),
);

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
const showDeferredWidgets = ref(false);

onMounted(() => {
    const enableWidgets = () => {
        showDeferredWidgets.value = true;
    };

    if ('requestIdleCallback' in window) {
        requestIdleCallback(enableWidgets, { timeout: 2000 });
    } else {
        setTimeout(enableWidgets, 1200);
    }
});
</script>

<template>
    <Head>
        <title>SaaS Factory & AI Ajansı | Otonom Sistemler</title>
        <meta
            head-key="description"
            name="description"
            content="Bursa yazılım şirketi olarak işletmenizin dijital dönüşümünü hızlandırıyoruz. Yapay zeka, RAG asistanlar ve otonom sistemlerle ölçeklenebilir özel yazılım çözümleri."
        />
        <meta
            head-key="keywords"
            name="keywords"
            content="bursa yazılım şirketi, bursa yazılım firması, bursa yazılım ajansı, bursa web yazılım, özel yazılım geliştirme, yapay zeka, otonom sistemler, saas altyapısı, B2B yazılım, RAG, LLM entegrasyonu"
        />
    </Head>

    <div class="flex min-h-screen flex-col bg-slate-950 text-slate-300">
        <DeveloperTerminal v-if="showDeferredWidgets" />

        <Navbar />

        <div
            v-if="flashSuccess"
            class="border-b border-emerald-500/30 bg-emerald-950/50 px-4 py-3 text-center text-sm font-medium text-emerald-300"
            role="alert"
        >
            {{ flashSuccess }}
        </div>

        <main class="flex-1">
            <slot />
        </main>

        <Footer />

        <AiChatWidget v-if="showDeferredWidgets" />
        <FloatingContact v-if="showDeferredWidgets" />
    </div>
</template>
