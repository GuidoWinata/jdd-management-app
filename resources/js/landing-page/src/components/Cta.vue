<template>
    <div ref="containerRef" class="relative w-full overflow-hidden bg-[#020b10]">
        <canvas
            ref="canvasRef"
            class="absolute inset-0 z-0 pointer-events-auto"
            @mousemove="handleMouseMove"
            @mouseleave="handleMouseLeave"
        ></canvas>

        <Section
            variant="deep"
            size="lg"
            border-top
            container="max-w-7xl"
            class="relative z-10 pointer-events-none !bg-transparent"
        >
            <div class="flex flex-col items-center text-center">
                <span
                    class="text-jd-cyan text-sm font-bold tracking-[0.2em] uppercase mb-8 block reveal"
                    style="transition-delay: 0.1s"
                >
                    Limited Seats Available
                </span>

                <h2
                    class="text-5xl md:text-7xl font-montserrat font-black uppercase tracking-tight mb-8 leading-tight reveal"
                    style="transition-delay: 0.2s"
                >
                    BE PART OF THE <span class="text-jd-cyan">MOMENT</span>
                </h2>

                <p
                    class="text-[#98b6c2] text-lg md:text-xl font-medium leading-relaxed max-w-3xl mb-12 reveal"
                    style="transition-delay: 0.3s"
                >
                    Bergabunglah bersama 500+ developer dan tech leader Jawa
                    Timur dalam acara yang mendefinisikan ulang masa depan
                    teknologi.
                </p>

                <div
                    class="flex flex-col sm:flex-row items-center justify-center gap-6 w-full sm:w-auto reveal pointer-events-auto"
                    style="transition-delay: 0.4s"
                >
                    <AppButton
                        :glow="true"
                        :href="primaryHref"
                        class="w-full sm:w-auto"
                    >
                        {{ primaryLabel }}
                        <span class="text-lg leading-none">&rarr;</span>
                    </AppButton>

                    <AppButton
                        variant="outline"
                        :href="secondaryHref"
                        class="w-full sm:w-auto"
                    >
                        {{ secondaryLabel }}
                        <span class="text-lg leading-none">&rarr;</span>
                    </AppButton>
                </div>
            </div>
        </Section>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import Section from "./ui/Section.vue";
import AppButton from "./ui/AppButton.vue";

defineProps({
    primaryLabel: { type: String, default: "JADI MEDIA PARTNER" },
    primaryHref: { type: String, default: "https://s.id/partnershipjdd2026" },
    secondaryLabel: { type: String, default: "JADI SPONSOR" },
    secondaryHref: { type: String, default: "https://s.id/sponsorshipjdd2026" },
});

const canvasRef = ref(null);
const containerRef = ref(null);

let ctx = null;
let dots = [];
let animationFrameId = null;
let dpr = 1;

const config = {
    dotSize: 1.5,
    spacing: 35,
    mouseRadius: 130,
    repelForce: 25,
    linkDistance: 120,
    linkOpacity: 0.09,
    dotOpacity: 0.35,
    dotOpacityNearMouse: 0.4,
    color: "#18BCBC",
    idleSpeed: 0.001,
    idleAmplitude: 5,
    idleAmplitude2: 2.5,
    easing: 0.08,
    perspectiveTop: 1,
    perspectiveBottom: 1.15,
};

const mouse = { x: -1000, y: -1000 };

class Dot {
    constructor(x, y) {
        this.baseX = x;
        this.baseY = y;
        this.x = x;
        this.y = y;
        this.targetX = x;
        this.targetY = y;
        this.angle = Math.random() * Math.PI * 2;
        this.angle2 = Math.random() * Math.PI * 2;
        this.speedMult = 0.7 + Math.random() * 0.6;
    }

    update(time) {
        const dx = mouse.x - this.baseX;
        const dy = mouse.y - this.baseY;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < config.mouseRadius) {
            const force = (config.mouseRadius - dist) / config.mouseRadius;
            const pushX = (dx / (dist || 1)) * force * config.repelForce;
            const pushY = (dy / (dist || 1)) * force * config.repelForce;
            this.targetX = this.baseX - pushX;
            this.targetY = this.baseY - pushY;
        } else {
            const t = time * config.idleSpeed * this.speedMult;
            const drift1X = Math.sin(t + this.angle) * config.idleAmplitude;
            const drift1Y = Math.cos(t * 0.7 + this.angle * 1.3) * config.idleAmplitude;
            const drift2X = Math.sin(t * 1.6 + this.angle2) * config.idleAmplitude2;
            const drift2Y = Math.cos(t * 1.1 + this.angle2 * 0.9) * config.idleAmplitude2;
            this.targetX = this.baseX + drift1X + drift2X;
            this.targetY = this.baseY + drift1Y + drift2Y;
        }

        this.x += (this.targetX - this.x) * config.easing;
        this.y += (this.targetY - this.y) * config.easing;
    }
}

const initDots = () => {
    dots = [];
    const w = canvasRef.value.width / dpr;
    const h = canvasRef.value.height / dpr;
    const cols = Math.ceil(w / config.spacing) + 1;
    const rows = Math.ceil(h / config.spacing) + 1;

    for (let j = 0; j < rows; j++) {
        const rowNorm = j / (rows - 1);
        const scale = config.perspectiveTop + (config.perspectiveBottom - config.perspectiveTop) * rowNorm;
        const rowWidth = (cols - 1) * config.spacing * scale;
        const offsetX = (w - rowWidth) / 2;
        const offsetY = j * config.spacing;

        for (let i = 0; i < cols; i++) {
            dots.push(new Dot(i * config.spacing * scale + offsetX, offsetY));
        }
    }
};

const resizeCanvas = () => {
    if (!canvasRef.value || !containerRef.value) return;
    dpr = window.devicePixelRatio || 1;
    const w = containerRef.value.offsetWidth;
    const h = containerRef.value.offsetHeight;
    canvasRef.value.width = w * dpr;
    canvasRef.value.height = h * dpr;
    canvasRef.value.style.width = w + "px";
    canvasRef.value.style.height = h + "px";
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    initDots();
};

const drawLinks = () => {
    for (let i = 0; i < dots.length; i++) {
        for (let j = i + 1; j < dots.length; j++) {
            const dx = dots[i].x - dots[j].x;
            const dy = dots[i].y - dots[j].y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < config.linkDistance) {
                const opacity = (1 - dist / config.linkDistance) * config.linkOpacity;
                ctx.beginPath();
                ctx.moveTo(dots[i].x, dots[i].y);
                ctx.lineTo(dots[j].x, dots[j].y);
                ctx.strokeStyle = config.color;
                ctx.globalAlpha = opacity;
                ctx.lineWidth = 0.5;
                ctx.stroke();
                ctx.closePath();
            }
        }
    }
};

const drawDots = () => {
    for (const dot of dots) {
        const dx = mouse.x - dot.x;
        const dy = mouse.y - dot.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        const nearMouse = dist < config.mouseRadius;

        ctx.beginPath();
        ctx.arc(dot.x, dot.y, nearMouse ? config.dotSize + 0.8 : config.dotSize, 0, Math.PI * 2);
        ctx.fillStyle = config.color;
        ctx.globalAlpha = nearMouse ? config.dotOpacityNearMouse : config.dotOpacity;
        ctx.fill();
        ctx.closePath();
    }
};

const animate = (time) => {
    const w = canvasRef.value.width / dpr;
    const h = canvasRef.value.height / dpr;
    ctx.clearRect(0, 0, w, h);

    for (const dot of dots) {
        dot.update(time);
    }

    drawLinks();
    drawDots();
    ctx.globalAlpha = 1;

    animationFrameId = requestAnimationFrame(animate);
};

const handleMouseMove = (e) => {
    if (!canvasRef.value) return;
    const rect = canvasRef.value.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
};

const handleMouseLeave = () => {
    mouse.x = -1000;
    mouse.y = -1000;
};

onMounted(() => {
    if (canvasRef.value) {
        ctx = canvasRef.value.getContext("2d");
        resizeCanvas();
        animationFrameId = requestAnimationFrame(animate);
        window.addEventListener("resize", resizeCanvas);
    }
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", resizeCanvas);
    if (animationFrameId) cancelAnimationFrame(animationFrameId);
});
</script>
