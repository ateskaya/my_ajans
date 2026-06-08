<script setup>
import AiChatWidget from '@/Components/AiChatWidget.vue';
import FloatingContact from '@/Components/FloatingContact.vue';
import DeveloperTerminal from '@/Components/DeveloperTerminal.vue';
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
</script>

<template>
    <Head>
        <title>SaaS Factory & AI Ajansı | Otonom Sistemler</title>
        <meta
            head-key="description"
            name="description"
            content="İşletmenizin dijital dönüşümünü hızlandırıyoruz. Yapay zeka, RAG asistanlar ve otonom sistemlerle ölçeklenebilir özel yazılım çözümleri."
        />
        <meta
            head-key="keywords"
            name="keywords"
            content="özel yazılım geliştirme, yapay zeka, otonom sistemler, saas altyapısı, B2B yazılım, RAG, LLM entegrasyonu"
        />
    </Head>

    <div class="flex min-h-screen flex-col bg-slate-950 text-slate-300">
        <DeveloperTerminal />

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

        <AiChatWidget />
        <FloatingContact />
    </div>
</template>
