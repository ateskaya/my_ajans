<script setup>
import ProjectGalleryExperience from '@/Components/ProjectGalleryExperience.vue';
import { TresCanvas } from '@tresjs/core';
import { useScroll } from '@vueuse/core';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
    caseStudies: {
        type: Array,
        required: true,
    },
    scrollRoot: {
        type: Object,
        default: null,
    },
});

const containerRef = ref(null);
const scrollProgress = ref(0);
const activeIndex = ref(0);
const morphT = ref(0);
const mouse = ref({ x: 0, y: 0 });

const projectCount = computed(() =>
    Math.max(1, Math.min(props.caseStudies.length, 4)),
);

const scrollTarget = computed(() => props.scrollRoot ?? containerRef.value);

const { y: scrollY } = useScroll(scrollTarget, { throttle: 50 });

let scrollTriggerInstance = null;
let panelTriggers = [];

const updateFromProgress = (progress) => {
    const count = projectCount.value;
    const clamped = Math.min(Math.max(progress, 0), 1);
    scrollProgress.value = clamped;

    if (count <= 1) {
        activeIndex.value = 0;
        morphT.value = 0;

        return;
    }

    const scaled = clamped * (count - 1);
    activeIndex.value = Math.min(Math.floor(scaled), count - 1);
    morphT.value = scaled - activeIndex.value;
};

const onMouseMove = (event) => {
    const el = containerRef.value;

    if (!el) {
        return;
    }

    const rect = el.getBoundingClientRect();
    mouse.value = {
        x: ((event.clientX - rect.left) / rect.width - 0.5) * 2,
        y: -((event.clientY - rect.top) / rect.height - 0.5) * 2,
    };
};

const setupScrollTriggers = () => {
    const root = props.scrollRoot;

    if (!root) {
        return;
    }

    scrollTriggerInstance?.kill();
    panelTriggers.forEach((t) => t.kill());
    panelTriggers = [];

    scrollTriggerInstance = ScrollTrigger.create({
        trigger: root,
        start: 'top top',
        end: 'bottom bottom',
        scrub: 0.85,
        onUpdate: (self) => updateFromProgress(self.progress),
    });

    const panels = root.querySelectorAll('.galaxy-panel');

    panels.forEach((panel, index) => {
        const trigger = ScrollTrigger.create({
            trigger: panel,
            start: 'top 55%',
            end: 'bottom 45%',
            onEnter: () => {
                activeIndex.value = index;
                morphT.value = 0;
            },
            onEnterBack: () => {
                activeIndex.value = index;
                morphT.value = 0;
            },
        });

        panelTriggers.push(trigger);
    });

    ScrollTrigger.refresh();
};

onMounted(() => {
    window.addEventListener('mousemove', onMouseMove);
});

watch(
    () => props.scrollRoot,
    async (root) => {
        if (root) {
            await nextTick();
            setupScrollTriggers();
        }
    },
    { immediate: true },
);

watch(scrollY, () => {
    if (props.scrollRoot) {
        return;
    }

    const max = Math.max(
        document.documentElement.scrollHeight - window.innerHeight,
        1,
    );
    updateFromProgress(window.scrollY / max);
});

onUnmounted(() => {
    window.removeEventListener('mousemove', onMouseMove);
    scrollTriggerInstance?.kill();
    panelTriggers.forEach((t) => t.kill());
});
</script>

<template>
    <div
        ref="containerRef"
        class="relative h-full min-h-[280px] w-full overflow-hidden rounded-xl bg-slate-950 lg:min-h-0 lg:rounded-none"
    >
        <TresCanvas clear-color="#020617" class="h-full w-full">
            <ProjectGalleryExperience
                :active-index="activeIndex"
                :morph-t="morphT"
                :scroll-progress="scrollProgress"
                :mouse="mouse"
                :project-count="projectCount"
            />
        </TresCanvas>

        <div
            class="pointer-events-none absolute bottom-4 left-4 right-4 flex justify-center gap-2"
        >
            <span
                v-for="(_, index) in projectCount"
                :key="index"
                class="h-1.5 rounded-full transition-all duration-300"
                :class="
                    index === activeIndex
                        ? 'w-8 bg-cyan-400'
                        : 'w-2 bg-slate-600'
                "
            />
        </div>
    </div>
</template>
