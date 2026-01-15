<script setup>
import Navbar from "./components/Navbar.vue";

const services = [
    {
        title: "Digital Strategy",
        description:
            "We help you navigate the digital landscape with data-driven strategies that ensure growth and sustainability.",
        icon: "📊",
    },
    {
        title: "Web Development",
        description:
            "Building robust, scalable, and high-performance web applications tailored to your business needs.",
        icon: "💻",
    },
    {
        title: "UI/UX Design",
        description:
            "Creating intuitive and engaging user experiences that delight your customers and boost conversion.",
        icon: "🎨",
    },
];
</script>

<template>
    <div
        class="min-h-screen bg-gray-50 font-sans text-gray-900 selection:bg-blue-100 selection:text-blue-900"
    >
        <Navbar />

        <!-- Hero Section -->
        <header id="home" class="relative overflow-hidden pt-16 pb-24 lg:pt-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <div
                        class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-sm font-medium mb-8 border border-blue-100"
                    >
                        <span
                            class="flex h-2 w-2 rounded-full bg-blue-600 mr-2"
                        ></span>
                        Now accepting new projects
                    </div>
                    <h1
                        class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight"
                    >
                        We Build
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600"
                            >Digital Profiles</span
                        >
                        That Stand Out.
                    </h1>
                    <p
                        class="mt-4 text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed"
                    >
                        Elevate your business presence with our cutting-edge
                        solutions. We combine design, technology, and strategy
                        to create impactful digital experiences.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a
                            href="#contact"
                            class="px-8 py-4 bg-blue-600 text-white rounded-full font-semibold text-lg hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-blue-500/30 ring-4 ring-blue-500/10"
                        >
                            Start Your Project
                        </a>
                        <a
                            href="#about"
                            class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-full font-semibold text-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm"
                        >
                            Learn More
                        </a>
                    </div>
                </div>
            </div>

            <!-- Decoration -->
            <div
                class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-10 pointer-events-none"
            >
                <div
                    class="absolute top-[20%] left-[20%] w-72 h-72 bg-blue-200/30 rounded-full blur-3xl mix-blend-multiply animate-blob"
                ></div>
                <div
                    class="absolute top-[20%] right-[20%] w-72 h-72 bg-indigo-200/30 rounded-full blur-3xl mix-blend-multiply animate-blob animation-delay-2000"
                ></div>
                <div
                    class="absolute -bottom-8 left-[50%] w-72 h-72 bg-purple-200/30 rounded-full blur-3xl mix-blend-multiply animate-blob animation-delay-4000"
                ></div>
            </div>
        </header>

        <!-- About Section -->
        <section id="about" class="py-24 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div class="relative mb-12 lg:mb-0">
                        <div
                            class="relative rounded-2xl overflow-hidden shadow-2xl ring-1 ring-gray-900/10"
                        >
                            <!-- Placeholder image using a gradient -->
                            <div
                                class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400"
                            >
                                <span class="text-xl"
                                    >Business Image Placeholder</span
                                >
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-6 -right-6 w-24 h-24 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-xl"
                        >
                            10+ <br />
                            <span class="text-xs font-normal opacity-80"
                                >Years Exp.</span
                            >
                        </div>
                    </div>
                    <div>
                        <h2
                            class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2"
                        >
                            About Us
                        </h2>
                        <p
                            class="text-3xl md:text-4xl font-bold text-gray-900 mb-6"
                        >
                            Driven by results, fueled by passion.
                        </p>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            At Vercy, we believe in the transformative power of
                            technology. Our team of dedicated professionals
                            works tirelessly to bring your vision to life,
                            ensuring that every pixel serves a purpose and every
                            line of code drives efficiency.
                        </p>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Whether you are a startup looking to make a splash
                            or an established enterprise seeking to innovate, we
                            are your partners in success.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-center text-gray-700">
                                <span
                                    class="flex h-6 w-6 rounded-full bg-green-100 text-green-600 items-center justify-center mr-3"
                                    >✓</span
                                >
                                Innovative Solutions
                            </li>
                            <li class="flex items-center text-gray-700">
                                <span
                                    class="flex h-6 w-6 rounded-full bg-green-100 text-green-600 items-center justify-center mr-3"
                                    >✓</span
                                >
                                Client-Centric Approach
                            </li>
                            <li class="flex items-center text-gray-700">
                                <span
                                    class="flex h-6 w-6 rounded-full bg-green-100 text-green-600 items-center justify-center mr-3"
                                    >✓</span
                                >
                                Timely Delivery
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2
                        class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2"
                    >
                        Our Expertise
                    </h2>
                    <p
                        class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"
                    >
                        What We Do Best
                    </p>
                    <p class="text-gray-600 text-lg">
                        Comprehensive solutions tailored to elevate your
                        business in the digital era.
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div
                        v-for="service in services"
                        :key="service.title"
                        class="bg-white rounded-2xl p-8 hover:shadow-xl transition-shadow duration-300 border border-gray-100"
                    >
                        <div
                            class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-2xl mb-6"
                        >
                            {{ service.icon }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ service.title }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ service.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 bg-white">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Ready to transform your business?
                </h2>
                <p class="text-xl text-gray-600 mb-10">
                    Let's discuss how we can help you achieve your goals. Our
                    team is ready to answer your questions.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a
                        href="mailto:hello@vercy.com"
                        class="px-8 py-4 bg-gray-900 text-white rounded-full font-bold hover:bg-gray-800 transition-colors duration-200"
                    >
                        Get in Touch
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 py-12 border-t border-gray-200">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center bg-gray-50"
            >
                <div class="mb-4 md:mb-0">
                    <span class="font-bold text-xl text-gray-900">Vercy</span>
                    <p class="text-sm text-gray-500 mt-1">
                        © 2026 Vercy Inc. All rights reserved.
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-600"
                        >Twitter</a
                    >
                    <a href="#" class="text-gray-400 hover:text-gray-600"
                        >LinkedIn</a
                    >
                    <a href="#" class="text-gray-400 hover:text-gray-600"
                        >Instagram</a
                    >
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
/* Custom animations if needed that tailwind doesn't cover by default */
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
