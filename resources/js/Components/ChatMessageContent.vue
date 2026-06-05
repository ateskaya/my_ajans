<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { parseChatMessage } from '@/utils/parseChatMessage';

const props = defineProps({
    content: {
        type: String,
        required: true,
    },
});

const segments = computed(() => parseChatMessage(props.content));
</script>

<template>
    <span>
        <template v-for="(segment, index) in segments" :key="index">
            <Link
                v-if="segment.type === 'link'"
                :href="segment.href"
                class="font-medium text-blue-300 underline decoration-blue-400/60 underline-offset-2 hover:text-blue-200"
            >
                {{ segment.label }}
            </Link>
            <span v-else>{{ segment.text }}</span>
        </template>
    </span>
</template>
