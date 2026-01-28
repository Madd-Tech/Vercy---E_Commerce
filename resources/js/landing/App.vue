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

import { ref, onMounted } from 'vue';
import productImg from '../../assets/product.jpg';

const products = ref([]);
const loading = ref(true);
const selectedProduct = ref(null);
const carouselContainer = ref(null);

const scrollLeft = () => {
    if (carouselContainer.value) {
        carouselContainer.value.scrollBy({ left: -320, behavior: 'smooth' });
    }
};

const scrollRight = () => {
    if (carouselContainer.value) {
        carouselContainer.value.scrollBy({ left: 320, behavior: 'smooth' });
    }
};

const openModal = (product) => {
    selectedProduct.value = product;
};

const closeModal = () => {
    selectedProduct.value = null;
};

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
}

onMounted(async () => {
    try {
        const res = await fetch('/landing/products');
        if (res.ok) {
            products.value = await res.json();
        }
    } catch (e) {
        console.error("Failed to load products", e);
    } finally {
        loading.value = false;
    }
});
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
                        Best Choice for looking a new product
                    </div>
                    <h1
                        class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight"
                    >
                        We Sell
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600"
                            >Officially Products</span
                        >
                        That Trusted.
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
                            Order Now
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
                               <img :src="productImg" alt="About Us" class="w-full h-full object-cover">
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

        <!-- Featured Products Section -->
        <section id="products" class="py-24 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">
                        Shop
                    </h2>
                    <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Featured Products
                    </p>
                    <p class="text-gray-600 text-lg">
                        Check out our latest collection.
                    </p>
                </div>

                <div v-if="loading" class="flex justify-center py-12">
                   <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>

                <div v-else-if="products.length === 0" class="text-center py-12 text-gray-500">
                    No products available at the moment.
                </div>

                <div v-else class="relative">
                     <!-- Navigation Buttons -->
                    <button @click="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 lg:-ml-12 z-10 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-700 hover:text-blue-600 hover:scale-110 transition-all duration-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 lg:-mr-12 z-10 w-12 h-12 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-gray-700 hover:text-blue-600 hover:scale-110 transition-all duration-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Carousel Container -->
                    <div ref="carouselContainer" class="flex overflow-x-auto gap-8 pb-8 px-4 snap-x snap-mandatory scrollbar-hide -mx-4">
                        <div v-for="product in products" :key="product.id" class="flex-none w-full sm:w-1/2 lg:w-1/3 snap-center">
                            <div class="group h-full bg-gray-50 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-200 relative">
                                     <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" />
                                     <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                                         <span class="text-4xl opacity-25">📦</span>
                                     </div>
                                     
                                     <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                         <button @click="openModal(product)" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                             View Details
                                         </button>
                                     </div>
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                                            {{ product.name }}
                                        </h3>
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
                                            {{ product.categories && product.categories.length ? product.categories[0].name : 'Item' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[2.5em]">
                                        {{ product.description || 'No description available.' }}
                                    </p>
                                    <div class="flex items-center justify-between mt-auto">
                                        <span class="text-2xl font-bold text-gray-900">
                                            <span class="text-sm font-normal text-gray-500 align-top mr-0.5">Rp</span>{{ formatPrice(product.price) }}
                                        </span>
                                        <button class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mt-8 text-center">
                        <a href="/products" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-full text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-300">
                            See More Products
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 bg-white">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Ready to Order Now?
                </h2>
                <p class="text-xl text-gray-600 mb-10">
                    Let's discuss how we can help you get your favorite things. Our
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
    <!-- Modal -->
        <Transition name="modal">
            <div v-if="selectedProduct" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click.self="closeModal">
                <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl relative flex flex-col md:flex-row overflow-hidden">
                     <button @click="closeModal" class="absolute top-4 right-4 z-10 bg-white/80 hover:bg-white rounded-full p-2 transition-colors text-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                     </button>
                     
                     <div class="md:w-1/2 bg-gray-100 relative min-h-[300px] md:min-h-full">
                         <img v-if="selectedProduct.image" :src="`/storage/${selectedProduct.image}`" class="absolute inset-0 w-full h-full object-cover">
                         <div v-else class="absolute inset-0 flex items-center justify-center text-gray-400">
                             <span class="text-6xl opacity-25">📦</span>
                         </div>
                     </div>
                     
                     <div class="p-8 md:w-1/2 flex flex-col">
                        <div class="mb-4">
                             <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded uppercase tracking-wide mb-2 inline-block">{{ selectedProduct.categories && selectedProduct.categories.length ? selectedProduct.categories[0].name : 'Item' }}</span>
                             <h2 class="text-3xl font-bold text-gray-900 mb-1 leading-tight">{{ selectedProduct.name }}</h2>
                        </div>

                        <div class="prose prose-sm text-gray-600 mb-6 flex-grow overflow-y-auto max-h-60">
                            <p>{{ selectedProduct.description || 'No description available for this product.' }}</p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Price</p>
                                    <p class="text-3xl font-bold text-gray-900">Rp {{ formatPrice(selectedProduct.price) }}</p>
                                </div>
                                <div class="text-right">
                                     <p class="text-sm text-gray-500 mb-1">Status</p>
                                     <span :class="{'bg-green-100 text-green-700': selectedProduct.status === 'active', 'bg-red-100 text-red-700': selectedProduct.status !== 'active'}" class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                         {{ selectedProduct.status }}
                                     </span>
                                </div>
                            </div>
                            
                            <button class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg shadow-blue-500/30 ring-4 ring-blue-500/10 flex items-center justify-center gap-2">
                                <span>Order Now</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
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

/* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
