<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <div v-if="loading" class="flex justify-center items-center h-64">
           <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
      
      <div v-else-if="!order" class="text-center py-12">
          <h2 class="text-2xl font-bold text-gray-900">Invoice Not Found</h2>
          <p class="mt-2 text-gray-600">The invoice you are looking for does not exist.</p>
          <a href="/" class="mt-4 inline-block text-blue-600 hover:underline">Go back home</a>
      </div>

      <div v-else class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-6 py-5 sm:px-8 border-b border-gray-200 flex justify-between items-center">
          <div>
              <h3 class="text-xl leading-6 font-bold text-gray-900">
                Invoice #{{ order.order_number }}
              </h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Created on {{ formatDate(order.created_at) }}
              </p>
          </div>
          <div>
              <span :class="statusClass(order.status)" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize">
                  {{ order.status }}
              </span>
          </div>
        </div>
        
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Order Items -->
            <div>
                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Items</h4>
                <ul class="divide-y divide-gray-200 border-t border-b border-gray-200">
                    <li v-for="item in order.items" :key="item.id" class="py-4 flex">
                        <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden bg-gray-100">
                             <img v-if="item.product && item.product.image" :src="`/storage/${item.product.image}`" class="w-full h-full object-center object-cover">
                             <div v-else class="flex items-center justify-center h-full text-lg">📦</div>
                        </div>
                        <div class="ml-4 flex-1 flex flex-col">
                            <div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3>{{ item.product ? item.product.name : 'Unknown Product' }}</h3>
                                    <p class="ml-4">Rp {{ formatPrice(item.price * item.qty) }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500" v-if="item.product">{{ item.product.categories && item.product.categories.length ? item.product.categories[0].name : 'General' }}</p>
                            </div>
                            <div class="flex-1 flex items-end justify-between text-sm">
                                <p class="text-gray-500">Qty {{ item.qty }} x Rp {{ formatPrice(item.price) }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-4 flex justify-end">
                    <div class="text-base font-medium text-gray-900">Total: Rp {{ formatPrice(order.total_price) }}</div>
                </div>
            </div>

            <!-- Payment Method -->
            <div v-if="order.status === 'pending'">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Select Payment Method</h4>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="transfer" name="payment_method" type="radio" v-model="paymentMethod" value="transfer" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="transfer" class="ml-3 block text-sm font-medium text-gray-700">
                            Bank Transfer
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="cod" name="payment_method" type="radio" v-model="paymentMethod" value="cod" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                            Cash on Delivery (COD)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="ewallet" name="payment_method" type="radio" v-model="paymentMethod" value="ewallet" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                        <label for="ewallet" class="ml-3 block text-sm font-medium text-gray-700">
                            E-Wallet (OVO, GoPay, Dana)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button v-if="order.status === 'pending'" @click="cancelOrder" :disabled="processing" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50">
                    <span v-if="processing">Processing...</span>
                    <span v-else>Cancel Order</span>
                </button>
                
                <button v-if="order.status === 'pending'" @click="payOrder" :disabled="processing || !paymentMethod" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                    <span v-if="processing">Processing...</span>
                    <span v-else>Confirm Payment</span>
                </button>
            </div>
        </div>
      </div>
    </div>

    <!-- Custom Modal -->
    <Transition name="modal">
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
             <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 text-center transform transition-all">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4" 
                    :class="{
                        'bg-green-100': modalType === 'success',
                        'bg-red-100': modalType === 'error',
                        'bg-yellow-100': modalType === 'confirm',
                        'bg-blue-100': modalType === 'info'
                    }">
                    <!-- Success Icon -->
                    <svg v-if="modalType === 'success'" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <!-- Error Icon -->
                    <svg v-else-if="modalType === 'error'" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <!-- Confirm Icon -->
                    <svg v-else-if="modalType === 'confirm'" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <!-- Info Icon -->
                    <svg v-else class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ modalTitle }}</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">{{ modalMessage }}</p>
                </div>
                <div class="mt-6 flex justify-center space-x-3">
                    <button v-if="modalType === 'confirm'" @click="closeCustomModal" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                        Cancel
                    </button>
                    <button @click="modalType === 'confirm' ? handleConfirm() : closeCustomModal()" 
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:text-sm"
                        :class="{
                            'bg-green-600 hover:bg-green-700 focus:ring-green-500': modalType === 'success',
                            'bg-red-600 hover:bg-red-700 focus:ring-red-500': modalType === 'error',
                            'bg-red-600 hover:bg-red-700 focus:ring-red-500': modalType === 'confirm',
                            'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500': modalType === 'info'
                        }">
                        {{ modalType === 'confirm' ? 'Confirm' : 'OK' }}
                    </button>
                </div>
             </div>
        </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Navbar from '../../landing/components/Navbar.vue';

const order = ref(null);
const loading = ref(true);
const processing = ref(false);
const paymentMethod = ref('transfer');
const showModal = ref(false);
const modalTitle = ref('');
const modalMessage = ref('');
const modalType = ref('info'); // info, success, error, confirm
const onConfirmAction = ref(null);

const orderNumber = document.getElementById('users-invoice-app').dataset.orderNumber;

const fetchOrder = async () => {
  try {
      const response = await axios.get(`/api/orders/${orderNumber}`);
      order.value = response.data;
  } catch (error) {
      console.error('Error fetching order:', error);
      showCustomModal('Error', 'Failed to fetch order details.', 'error');
  } finally {
      loading.value = false;
  }
};

const formatPrice = (value) => {
  return Number(value).toLocaleString('id-ID');
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

const statusClass = (status) => {
    switch (status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'paid': return 'bg-green-100 text-green-800';
        case 'canceled': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

const showCustomModal = (title, message, type = 'info', onConfirm = null) => {
    modalTitle.value = title;
    modalMessage.value = message;
    modalType.value = type;
    onConfirmAction.value = onConfirm;
    showModal.value = true;
};

const closeCustomModal = () => {
    showModal.value = false;
    onConfirmAction.value = null;
};

const handleConfirm = () => {
    if (onConfirmAction.value) {
        onConfirmAction.value();
    }
    closeCustomModal();
};

const cancelOrder = async () => {
    showCustomModal(
        'Cancel Order?',
        'Are you sure you want to cancel this order? This action cannot be undone.',
        'confirm',
        async () => {
            processing.value = true;
            try {
                const response = await axios.put(`/orders/${order.value.id}/cancel`);
                order.value = response.data.order;
                showCustomModal('Success', 'Order canceled successfully.', 'success');
            } catch (error) {
                console.error('Error canceling order:', error);
                showCustomModal('Error', 'Failed to cancel order.', 'error');
            } finally {
                processing.value = false;
            }
        }
    );
};

const payOrder = () => {
    showCustomModal(
        'Confirm Payment',
        `Are you sure you want to proceed with payment via ${paymentMethod.value}?`,
        'confirm',
        async () => {
             processing.value = true;
             try {
                 const response = await axios.put(`/orders/${order.value.id}/pay`, {
                     payment_method: paymentMethod.value
                 });
                 order.value = response.data.order;
                 showCustomModal('Success', 'Payment successful! Thank you for your order.', 'success');
             } catch (error) {
                 console.error('Error paying order:', error);
                 showCustomModal('Error', 'Payment failed. Please try again.', 'error');
             } finally {
                 processing.value = false;
             }
        }
    );
};

onMounted(() => {
  fetchOrder();
});
</script>
