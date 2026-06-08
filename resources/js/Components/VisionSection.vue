<script setup>
const visionImage =
    'https://images.unsplash.com/photo-1517694712202-14dd9538a88f?w=1920&auto=format&fit=crop&q=80';
</script>

<template>
    <section
        class="relative w-full overflow-hidden border-y border-slate-800"
        aria-label="Vizyon"
    >
        <div class="relative h-64 sm:h-80 lg:h-96">
            <img
                :src="visionImage"
                alt=""
                class="absolute inset-0 h-full w-full object-cover"
                loading="lazy"
                aria-hidden="true"
            />
            <div class="absolute inset-0 bg-slate-950/70" />

            <div
                class="relative flex h-full items-center justify-center px-6 text-center"
            >
                <p
                    class="max-w-3xl text-lg font-medium leading-relaxed text-white sm:text-xl lg:text-2xl"
                >
                    Kod satırlarının ötesinde, işinizi geleceğe taşıyan otonom
                    sistemler inşa ediyoruz.
                </p>
            </div>
        </div>
    </section>
</template>
