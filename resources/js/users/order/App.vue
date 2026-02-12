<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
      <div v-if="loading" class="flex justify-center items-center h-64">
           <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
      
      <div v-else-if="!product" class="text-center py-12">
          <h2 class="text-2xl font-bold text-gray-900">Product Not Found</h2>
          <p class="mt-2 text-gray-600">The product you are looking for does not exist.</p>
          <a href="/" class="mt-4 inline-block text-blue-600 hover:underline">Go back home</a>
      </div>

      <div v-else class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Checkout
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Complete your order.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- Product Info -->
            <div>
                 <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden bg-gray-100 mb-4 h-48">
                    <img v-if="product.image" :src="`/storage/${product.image}`" class="object-cover w-full h-full" alt="Product Image">
                    <div v-else class="flex items-center justify-center h-full text-gray-400">
                        <span class="text-4xl">📦</span>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ product.name }}</h2>
                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                    {{ product.categories && product.categories.length ? product.categories[0].name : 'General' }}
                </span>
                <p class="mt-4 text-gray-600">{{ product.description }}</p>
                 <div class="mt-6">
                    <p class="text-sm text-gray-500">Price per unit</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ formatPrice(product.price) }}</p>
                </div>
            </div>

            <!-- Order Form -->
            <div>
                <form @submit.prevent="submitOrder" class="space-y-6">
                    <div v-if="!customer">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        You need to be logged in to place an order.
                                    </p>
                                    <p class="mt-2 text-sm">
                                         <a href="/overview" class="font-medium text-yellow-700 underline hover:text-yellow-600">Sign In / Register</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                         <div class="bg-gray-50 p-4 rounded-md mb-6">
                            <h4 class="text-sm font-medium text-gray-900">Ordering as:</h4>
                            <p class="text-gray-600">{{ customer.name }} ({{ customer.email }})</p>
                             <p class="text-gray-500 text-sm mt-1">{{ customer.address }}</p>
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <div class="mt-1">
                                <input type="number" name="quantity" id="quantity" v-model="form.quantity" min="1" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <span>Total:</span>
                                <span>Rp {{ formatPrice(product.price * form.quantity) }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" :disabled="submitting" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                                <span v-if="submitting">Processing...</span>
                                <span v-else>Confirm Invoice</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
        <!-- Invoice Success Modal -->
        <Transition name="modal">
            <div v-if="showInvoice" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                 <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-center transform transition-all">
                     <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Order Successful!</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Your order has been placed.</p>
                        <p class="mt-4 text-sm font-bold text-gray-700">Invoice Number:</p>
                        <p class="text-2xl font-mono text-blue-600 tracking-wider my-2">{{ invoiceNumber }}</p>
                         <p class="text-xs text-gray-400">Please save this number for your reference.</p>
                    </div>
                    <div class="mt-6">
                        <button @click="closeInvoice" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Back to Home
                        </button>
                    </div>
                 </div>
            </div>
        </Transition>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';
import Navbar from '../../landing/components/Navbar.vue';

const product = ref(null);
const customer = ref(null);
const loading = ref(true);
const submitting = ref(false);
const showInvoice = ref(false);
const invoiceNumber = ref('');

const form = reactive({
    quantity: 1
});

const productId = document.getElementById('users-order-app').dataset.productId;

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
}

const checkCustomer = () => {
    const storedCustomer = localStorage.getItem('customer');
    if (storedCustomer) {
        try {
            customer.value = JSON.parse(storedCustomer);
        } catch (e) {
            console.error(e);
        }
    }
};

onMounted(async () => {
    checkCustomer();
    if (productId) {
         try {
             // We can reuse the landing/products API or fetch single product
             // Currently there is no single product API route in web.php, only /landing/products (all) and /api/products/all
             // I'll assume we can fetch all and filtering, OR I should add a route.
             // Best to filtered from the existing `GET /api/products/all` for now as it's quick, or add a specific route.
             // Actually, I can add a route to get single product.
             // But let's try to filter from the /landing/products which returns 6 latest? 
             // Or /api/products/all which returns all.
             
             const response = await axios.get('/api/products/all');
             const products = response.data;
             product.value = products.find(p => p.id == productId);
             
             if (!product.value) {
                 // Maybe it's not in the latest/active list?
                 // Should ideally have a dedicated endpoint `GET /api/products/{id}`.
             }
        } catch (e) {
            console.error("Failed to load product", e);
        } finally {
            loading.value = false;
        }
    } else {
        loading.value = false;
    }
});

const submitOrder = async () => {
    if (!customer.value) return;
    
    submitting.value = true;
    try {
        const response = await axios.post('/orders', {
            customer_id: customer.value.id,
            product_id: product.value.id,
            quantity: form.quantity
        });
        
        invoiceNumber.value = response.data.invoice_number;
        showInvoice.value = true;
        
    } catch (error) {
        console.error(error);
        alert('Failed to place order.');
    } finally {
        submitting.value = false;
    }
};

const closeInvoice = () => {
    showInvoice.value = false;
    window.location.href = '/';
};
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
