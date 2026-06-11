<template>
    <div
        class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
        aria-hidden="true"
    >
        <div class="hero-orb hero-orb--cyan" />
        <div class="hero-orb hero-orb--blue" />
        <div class="hero-glow" />
    </div>
</template>

<style scoped>
.hero-orb {
    position: absolute;
    border-radius: 9999px;
    filter: blur(72px);
    will-change: transform;
}

.hero-orb--cyan {
    top: 8%;
    right: 8%;
    width: min(420px, 55vw);
    height: min(420px, 55vw);
    background: radial-gradient(
        circle,
        rgba(34, 211, 238, 0.45) 0%,
        rgba(34, 211, 238, 0) 70%
    );
    animation: hero-drift-a 14s ease-in-out infinite;
}

.hero-orb--blue {
    bottom: 12%;
    left: 4%;
    width: min(360px, 48vw);
    height: min(360px, 48vw);
    background: radial-gradient(
        circle,
        rgba(37, 99, 235, 0.4) 0%,
        rgba(37, 99, 235, 0) 72%
    );
    animation: hero-drift-b 18s ease-in-out infinite;
}

.hero-glow {
    position: absolute;
    inset: 0;
    background: radial-gradient(
        ellipse 80% 55% at 50% -10%,
        rgba(59, 130, 246, 0.14) 0%,
        transparent 65%
    );
}

@keyframes hero-drift-a {
    0%,
    100% {
        transform: translate3d(0, 0, 0) scale(1);
    }

    50% {
        transform: translate3d(-24px, 18px, 0) scale(1.06);
    }
}

@keyframes hero-drift-b {
    0%,
    100% {
        transform: translate3d(0, 0, 0) scale(1);
    }

    50% {
        transform: translate3d(20px, -14px, 0) scale(1.04);
    }
}

@media (prefers-reduced-motion: reduce) {
    .hero-orb--cyan,
    .hero-orb--blue {
        animation: none;
    }
}
</style>
