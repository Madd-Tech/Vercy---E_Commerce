<script setup>
import { ref, onMounted } from 'vue';

const products = ref([]);
const loading = ref(true);
const selectedProduct = ref(null);

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
}

const fetchProducts = async () => {
    loading.value = true;
    try {
        const res = await fetch('/api/products/all');
        if (res.ok) {
            products.value = await res.json();
        }
    } catch (e) {
        console.error("Failed to load products", e);
    } finally {
        loading.value = false;
    }
};

const openModal = (product) => {
    selectedProduct.value = product;
};

const closeModal = () => {
    selectedProduct.value = null;
};

onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 font-sans text-gray-900 selection:bg-blue-100 selection:text-blue-900">
        <!-- Simple Header -->
        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Vercy</a>
                <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Back to Home</a>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">All Products</h1>
                <p class="text-gray-600 text-lg">Browse our complete collection of premium products.</p>
            </div>

            <div v-if="loading" class="flex justify-center py-12">
               <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>

            <div v-else-if="products.length === 0" class="text-center py-12 text-gray-500">
                No products found.
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                 <div v-for="product in products" :key="product.id" class="group bg-white rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full">
                     <div class="aspect-[4/3] overflow-hidden bg-gray-200 relative">
                          <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" />
                          <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                              <span class="text-4xl opacity-25">📦</span>
                          </div>
                          
                          <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                 <button @click="openModal(product)" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 hover:bg-blue-50">
                                     View Details
                                 </button>
                          </div>
                     </div>
                     <div class="p-6 flex flex-col flex-grow">
                         <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">{{ product.name }}</h3>
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">{{ product.categories?.[0]?.name || 'Item' }}</span>
                         </div>
                         <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[2.5em]">{{ product.description || 'No description available.' }}</p>
                         <div class="mt-auto flex justify-between items-center">
                             <span class="text-2xl font-bold text-gray-900"><span class="text-sm font-normal text-gray-500 align-top mr-0.5">Rp</span>{{ formatPrice(product.price) }}</span>
                              <button @click="openModal(product)" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </button>
                         </div>
                     </div>
                 </div>
            </div>
        </main>
        
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
                             <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded uppercase tracking-wide mb-2 inline-block">{{ selectedProduct.categories?.[0]?.name || 'Item' }}</span>
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
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
