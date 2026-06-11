<script setup>
import ChatMessageContent from '@/Components/ChatMessageContent.vue';
import { nextTick, ref } from 'vue';

const isOpen = ref(false);
const isLoading = ref(false);
const inputMessage = ref('');
const messagesContainer = ref(null);

const messages = ref([
    {
        role: 'assistant',
        content:
            'Merhaba! Ajansımızın hizmetleri ve başarı hikayeleri hakkında size yardımcı olabilirim. Nasıl destek olabilirim?',
    },
]);

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const toggleChat = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        scrollToBottom();
    }
};

const sendMessage = async () => {
    const text = inputMessage.value.trim();

    if (!text || isLoading.value) {
        return;
    }

    messages.value.push({ role: 'user', content: text });
    inputMessage.value = '';
    isLoading.value = true;
    await scrollToBottom();

    try {
        const { data } = await window.axios.post('/chat', { message: text });

        messages.value.push({
            role: 'assistant',
            content: data.reply ?? 'Yanıt alınamadı.',
        });
    } catch (error) {
        const fallback =
            error.response?.data?.reply ??
            'Bağlantı hatası. Lütfen tekrar deneyin veya iletişim formunu kullanın.';

        messages.value.push({
            role: 'assistant',
            content: fallback,
        });
    } finally {
        isLoading.value = false;
        await scrollToBottom();
    }
};

const onKeydown = (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
};
</script>

<template>
    <div class="fixed bottom-6 left-6 z-50 flex flex-col items-start">
        <!-- Chat window -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="translate-y-4 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-4 opacity-0"
        >
            <div
                v-if="isOpen"
                class="mb-4 flex h-[28rem] w-[22rem] flex-col overflow-hidden rounded-xl border border-slate-800 bg-slate-950 shadow-2xl shadow-blue-900/20 sm:w-96"
            >
                <div
                    class="flex items-center justify-between border-b border-slate-800 bg-slate-900/80 px-4 py-3"
                >
                    <div class="flex items-center gap-2">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600/20 text-blue-300"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 0 0-2.455 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"
                                />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Yapay Zeka Asistanı
                            </p>
                            <p class="text-xs text-slate-300">Gemini · RAG</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="rounded-md p-1 text-slate-300 transition hover:bg-slate-800 hover:text-white"
                        aria-label="Kapat"
                        @click="isOpen = false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <div
                    ref="messagesContainer"
                    class="flex-1 space-y-3 overflow-y-auto p-4"
                >
                    <div
                        v-for="(msg, index) in messages"
                        :key="index"
                        class="flex"
                        :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                    >
                        <div
                            class="max-w-[85%] whitespace-pre-wrap break-words rounded-lg px-3 py-2 text-sm leading-relaxed"
                            :class="
                                msg.role === 'user'
                                    ? 'bg-blue-600 text-white'
                                    : 'border border-slate-800 bg-slate-900 text-slate-300'
                            "
                        >
                            <ChatMessageContent
                                v-if="msg.role === 'assistant'"
                                :content="msg.content"
                            />
                            <template v-else>{{ msg.content }}</template>
                        </div>
                    </div>

                    <div v-if="isLoading" class="flex justify-start">
                        <div
                            class="rounded-lg border border-slate-800 bg-slate-900 px-4 py-3 text-sm text-slate-300"
                        >
                            <span class="inline-flex items-center gap-1">
                                <span class="animate-pulse">Yazıyor</span>
                                <span class="inline-flex gap-0.5">
                                    <span class="animate-bounce">.</span>
                                    <span
                                        class="animate-bounce"
                                        style="animation-delay: 0.1s"
                                    >.</span>
                                    <span
                                        class="animate-bounce"
                                        style="animation-delay: 0.2s"
                                    >.</span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-800 p-3">
                    <div class="flex gap-2">
                        <input
                            v-model="inputMessage"
                            type="text"
                            placeholder="Sorunuzu yazın..."
                            class="flex-1 rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-slate-200 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            :disabled="isLoading"
                            @keydown="onKeydown"
                        />
                        <button
                            type="button"
                            class="inline-flex shrink-0 items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-white transition hover:bg-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="isLoading || !inputMessage.trim()"
                            aria-label="Mesaj gönder"
                            @click="sendMessage"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 12 12 6l6 6-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Toggle button -->
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/30 transition hover:border-blue-500 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950"
            :aria-expanded="isOpen"
            :aria-label="isOpen ? 'Yapay zeka asistanını kapat' : 'Yapay zeka asistanını aç'"
            @click="toggleChat"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5 text-blue-300"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 15.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-8.25-4.5h1.5m12 0h1.5m-12 3h1.5m12 0h1.5M9 12a3 3 0 1 1 6 0 3 3 0 0 1-6 0Z"
                />
            </svg>
            <span class="hidden sm:inline">Yapay Zeka Asistanı</span>
        </button>
    </div>
</template>
