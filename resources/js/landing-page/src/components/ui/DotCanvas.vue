<template>
    <canvas
        ref="canvasRef"
        class="absolute inset-0 z-0 pointer-events-auto bg-white"
        @mousemove="handleMouseMove"
        @mouseleave="handleMouseLeave"
    ></canvas>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
    color: { type: String, default: "#CFDD11" },
    dotSize: { type: Number, default: 1.5 },
    spacing: { type: Number, default: 35 },
    mouseRadius: { type: Number, default: 130 },
    repelForce: { type: Number, default: 25 },
    linkDistance: { type: Number, default: 120 },
    linkOpacity: { type: Number, default: 0.09 },
    dotOpacity: { type: Number, default: 0.35 },
    dotOpacityNearMouse: { type: Number, default: 0.4 },
});

const canvasRef = ref(null);
let ctx = null;
let dots = [];
let animationFrameId = null;
let dpr = 1;

const config = {
    dotSize: props.dotSize,
    spacing: props.spacing,
    mouseRadius: props.mouseRadius,
    repelForce: props.repelForce,
    linkDistance: props.linkDistance,
    linkOpacity: props.linkOpacity,
    dotOpacity: props.dotOpacity,
    dotOpacityNearMouse: props.dotOpacityNearMouse,
    color: props.color,
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
    if (!canvasRef.value || !canvasRef.value.parentElement) return;
    dpr = window.devicePixelRatio || 1;
    const parent = canvasRef.value.parentElement;
    const w = parent.offsetWidth;
    const h = parent.offsetHeight;
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
