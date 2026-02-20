<template>
  <div class="flex min-h-screen bg-slate-900 font-sans text-slate-100">
    <Sidebar />

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900">
       <!-- Top Bar -->
      <header class="bg-slate-900/50 backdrop-blur-md sticky top-0 z-30 border-b border-white/5 px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Order Management</h1>
        
        <div class="flex items-center space-x-4">
          <div class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm border border-indigo-500/30">
            Admin
          </div>
          <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500"></div>
        </div>
      </header>

      <div class="px-6 py-8">
          <!-- Orders Table -->
          <div class="bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-xl">
              <div class="overflow-x-auto">
                  <table class="w-full text-left border-collapse">
                      <thead>
                          <tr class="border-b border-white/5 bg-white/5">
                              <th class="p-4 text-sm font-semibold text-slate-300">Invoice #</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Customer</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Total Price</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Date</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Status</th>
                              <th class="p-4 text-sm font-semibold text-slate-300 text-center">Actions</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-white/5">
                          <tr v-if="loading" class="animate-pulse">
                              <td colspan="6" class="p-4 text-center text-slate-400">Loading orders...</td>
                          </tr>
                          <tr v-else-if="orders.length === 0">
                              <td colspan="6" class="p-8 text-center text-slate-500">No orders found.</td>
                          </tr>
                          <tr v-for="order in orders" :key="order.id" class="hover:bg-white/5 transition-colors group">
                              <td class="p-4 text-slate-300 font-mono text-sm">{{ order.order_number }}</td>
                              <td class="p-4">
                                  <div class="flex flex-col">
                                      <span class="text-white font-medium">{{ order.customer ? order.customer.name : 'Unknown' }}</span>
                                      <span class="text-xs text-slate-500">{{ order.customer ? order.customer.email : '' }}</span>
                                  </div>
                              </td>
                              <td class="p-4 text-emerald-400 font-medium">Rp {{ formatPrice(order.total_price) }}</td>
                              <td class="p-4 text-slate-400 text-sm">{{ formatDate(order.created_at) }}</td>
                              <td class="p-4 font-medium capitalize" :class="getStatusClass(order.status)">{{ order.status }}</td>
                              <td class="p-4 text-center">
                                  <button @click="showDetails(order)" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 transition-colors border border-indigo-500/20 text-sm">
                                      View Items
                                  </button>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>

          <!-- Order Details Modal -->
          <Transition name="fade">
              <div v-if="selectedOrder" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" @click.self="closeModal">
                  <div class="bg-slate-900 border border-white/10 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto flex flex-col">
                      <!-- Modal Header -->
                      <div class="p-6 border-b border-white/5 flex justify-between items-center sticky top-0 bg-slate-900 z-10">
                          <div>
                              <h3 class="text-xl font-bold text-white">Order Details</h3>
                              <p class="text-slate-400 text-sm font-mono mt-1">#{{ selectedOrder.order_number }}</p>
                          </div>
                          <button @click="closeModal" class="text-slate-400 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/5">
                              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                          </button>
                      </div>

                      <!-- Modal Body -->
                      <div class="p-6 space-y-6">
                          <!-- Customer Info -->
                          <div class="bg-white/5 rounded-xl p-4 border border-white/5">
                              <h4 class="text-sm uppercase tracking-wider text-slate-500 font-semibold mb-3">Customer Information</h4>
                              <div class="grid grid-cols-2 gap-4" v-if="selectedOrder.customer">
                                  <div>
                                      <p class="text-xs text-slate-400">Name</p>
                                      <p class="text-white">{{ selectedOrder.customer.name }}</p>
                                  </div>
                                  <div>
                                      <p class="text-xs text-slate-400">Email</p>
                                      <p class="text-white">{{ selectedOrder.customer.email }}</p>
                                  </div>
                                  <div>
                                      <p class="text-xs text-slate-400">Phone</p>
                                      <p class="text-white">{{ selectedOrder.customer.phone }}</p>
                                  </div>
                                  <div class="col-span-2">
                                      <p class="text-xs text-slate-400">Address</p>
                                      <p class="text-white">{{ selectedOrder.customer.address }}</p>
                                  </div>
                              </div>
                              <div v-else class="text-slate-500 italic">Customer data not available</div>
                          </div>

                          <!-- Order Items -->
                          <div>
                              <h4 class="text-sm uppercase tracking-wider text-slate-500 font-semibold mb-3">Order Items</h4>
                              <div class="bg-white/5 rounded-xl overflow-hidden border border-white/5">
                                  <table class="w-full text-left">
                                      <thead class="bg-black/20">
                                          <tr>
                                              <th class="p-3 text-xs font-semibold text-slate-400">Product</th>
                                              <th class="p-3 text-xs font-semibold text-slate-400 text-right">Qty</th>
                                              <th class="p-3 text-xs font-semibold text-slate-400 text-right">Price</th>
                                              <th class="p-3 text-xs font-semibold text-slate-400 text-right">Total</th>
                                          </tr>
                                      </thead>
                                      <tbody class="divide-y divide-white/5">
                                          <tr v-for="item in selectedOrder.items" :key="item.id">
                                              <td class="p-3">
                                                  <div class="flex items-center space-x-3">
                                                       <div class="h-10 w-10 rounded-lg bg-slate-700 overflow-hidden flex-shrink-0">
                                                          <img v-if="item.product && item.product.image" :src="`/storage/${item.product.image}`" class="w-full h-full object-cover">
                                                          <div v-else class="w-full h-full flex items-center justify-center text-lg">📦</div>
                                                      </div>
                                                      <div>
                                                          <p class="text-white font-medium text-sm">{{ item.product ? item.product.name : 'Unknown Product' }}</p>
                                                          <p class="text-xs text-slate-500" v-if="item.product">Rp {{ formatPrice(item.product.price) }} / unit</p>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td class="p-3 text-right text-slate-300">{{ item.qty }}</td>
                                              <td class="p-3 text-right text-slate-300">Rp {{ formatPrice(item.price) }}</td>
                                              <td class="p-3 text-right text-emerald-400 font-medium">Rp {{ formatPrice(item.qty * item.price) }}</td>
                                          </tr>
                                      </tbody>
                                      <tfoot class="bg-white/5 border-t border-white/10">
                                          <tr>
                                              <td colspan="3" class="p-4 text-right text-slate-300 font-medium">Total Amount</td>
                                              <td class="p-4 text-right text-emerald-400 font-bold text-lg">Rp {{ formatPrice(selectedOrder.total_price) }}</td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </Transition>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Sidebar from '../../components/sidebar/Sidebar.vue';

const orders = ref([]);
const loading = ref(true);
const selectedOrder = ref(null);

const fetchOrders = async () => {
  try {
      const response = await axios.get('/admin/orders/data');
      orders.value = response.data;
  } catch (error) {
      console.error('Error fetching orders:', error);
  } finally {
      loading.value = false;
  }
};

const showDetails = (order) => {
  selectedOrder.value = order;
};

const closeModal = () => {
  selectedOrder.value = null;
};

const formatPrice = (value) => {
  return Number(value).toLocaleString('id-ID');
};

const getStatusClass = (status) => {
    switch (status) {
        case 'pending': return 'text-yellow-500';
        case 'paid': return 'text-green-500';
        case 'canceled': return 'text-red-500';
        default: return 'text-slate-400';
    }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

onMounted(() => {
  fetchOrders();
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>