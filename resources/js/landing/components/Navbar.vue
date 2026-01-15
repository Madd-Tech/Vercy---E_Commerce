<script setup>
import { ref } from "vue";

const isOpen = ref(false);

const toggleMenu = () => {
    isOpen.value = !isOpen.value;
};

const menuItems = [
    { name: "Home", href: "#home" },
    { name: "About", href: "#about" },
    { name: "Services", href: "#services" },
    { name: "Contact", href: "#contact" },
];
</script>

<template>
    <nav
        class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span
                            class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"
                            >Vercy</span
                        >
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div
                    class="hidden md:ml-6 md:flex md:items-center md:space-x-8"
                >
                    <a
                        v-for="item in menuItems"
                        :key="item.name"
                        :href="item.href"
                        class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
                    >
                        {{ item.name }}
                    </a>
                    <a
                        href="#contact"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 shadow-lg shadow-blue-500/30"
                    >
                        Get Started
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button
                        @click="toggleMenu"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 focus:outline-none transition-colors duration-200"
                        aria-controls="mobile-menu"
                        :aria-expanded="isOpen"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            v-if="!isOpen"
                            class="block h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <svg
                            v-else
                            class="block h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            v-show="isOpen"
            class="md:hidden border-t border-gray-100"
            id="mobile-menu"
        >
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white">
                <a
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="item.href"
                    @click="isOpen = false"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200"
                >
                    {{ item.name }}
                </a>
                <a
                    href="#contact"
                    @click="isOpen = false"
                    class="block w-full text-center mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg text-base font-medium transition-colors duration-200 shadow-md"
                >
                    Get Started
                </a>
            </div>
        </div>
    </nav>
</template>
