<script setup>
import { router } from '@inertiajs/vue3';
import { nextTick, onMounted, onUnmounted, ref } from 'vue';

const isVisible = ref(false);
const input = ref('');
const inputRef = ref(null);
const scrollRef = ref(null);

const output = ref([
    {
        type: 'system',
        text: "ensar-saas-factory sistemine hoş geldiniz. Komutları görmek için 'help' yazın.",
    },
]);

const prompt = 'guest@ensar-saas-factory:~$ ';

const appendLine = (type, text) => {
    output.value.push({ type, text });
};

const scrollToBottom = async () => {
    await nextTick();
    if (scrollRef.value) {
        scrollRef.value.scrollTop = scrollRef.value.scrollHeight;
    }
};

const focusInput = async () => {
    await nextTick();
    inputRef.value?.focus();
};

const toggleTerminal = async () => {
    isVisible.value = !isVisible.value;

    if (isVisible.value) {
        await focusInput();
    }
};

const handleKeydown = (event) => {
    if (event.key === '`' || event.key === 'Escape') {
        event.preventDefault();
        toggleTerminal();
    }
};

const executeCommand = async () => {
    const raw = input.value.trim();

    if (!raw) {
        return;
    }

    appendLine('command', `${prompt}${raw}`);
    input.value = '';

    const command = raw.toLowerCase();

    switch (command) {
        case 'help':
            appendLine(
                'response',
                'Kullanılabilir komutlar: whoami, projects, stack, clear, hire_us',
            );
            break;
        case 'whoami':
            appendLine('response', 'guest@ensar-saas-factory');
            break;
        case 'projects':
            appendLine(
                'response',
                '- Eresbos (Otonom Haber Motoru)\n- Kenacademy (RAG Asistanı)\n- Launch Lead (SaaS Dashboard)\n- Discovery (Otonom Filtre Katmanı)',
            );
            break;
        case 'stack':
            appendLine(
                'response',
                'Laravel 11, Vue 3, Inertia, Tailwind CSS, PostgreSQL, Gemini 2.5 Flash API',
            );
            break;
        case 'clear':
            output.value = [];
            break;
        case 'hire_us':
            appendLine('response', 'Sihirbaza yönlendiriliyorsunuz...');
            setTimeout(() => {
                router.visit(route('wizard.index'));
            }, 1000);
            break;
        default:
            appendLine(
                'response',
                `Komut bulunamadı: ${raw}. 'help' yazarak komutları görebilirsiniz.`,
            );
    }

    await scrollToBottom();
    await focusInput();
};

const onInputKeydown = (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        executeCommand();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="-translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="-translate-y-full opacity-0"
    >
        <div
            v-if="isVisible"
            class="fixed left-0 top-0 z-[9999] w-full border-b border-green-500/50 bg-black/95 font-mono text-sm text-green-400 shadow-[0_8px_32px_rgba(34,197,94,0.15)] backdrop-blur-md"
            role="dialog"
            aria-label="Geliştirici terminali"
        >
            <div
                ref="scrollRef"
                class="max-h-[50vh] overflow-y-auto px-4 py-3"
            >
                <div
                    v-for="(line, index) in output"
                    :key="index"
                    class="whitespace-pre-wrap leading-relaxed"
                    :class="{
                        'text-green-500/80': line.type === 'system',
                        'text-green-300': line.type === 'command',
                        'text-green-400': line.type === 'response',
                    }"
                >
                    {{ line.text }}
                </div>

                <form
                    class="mt-2 flex flex-wrap items-center gap-0"
                    @submit.prevent="executeCommand"
                >
                    <span class="shrink-0 text-green-500">{{ prompt }}</span>
                    <input
                        ref="inputRef"
                        v-model="input"
                        type="text"
                        spellcheck="false"
                        autocomplete="off"
                        autocapitalize="off"
                        class="min-w-[12rem] flex-1 bg-transparent outline-none"
                        aria-label="Terminal komutu"
                        @keydown="onInputKeydown"
                    />
                </form>
            </div>

            <p class="border-t border-green-500/20 px-4 py-1 text-[10px] text-green-600/80">
                ` veya Esc ile kapat · help ile komutları listele
            </p>
        </div>
    </Transition>
</template>
