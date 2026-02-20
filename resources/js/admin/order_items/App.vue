<template>
  <div class="flex min-h-screen bg-slate-900 font-sans text-slate-100">
    <Sidebar />

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900">
       <!-- Top Bar -->
      <header class="bg-slate-900/50 backdrop-blur-md sticky top-0 z-30 border-b border-white/5 px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Order Items Management</h1>
        
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
                              <th class="p-4 text-sm font-semibold text-slate-300">Order ID</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Customer</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Order Items</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Total Price</th>
                              <th class="p-4 text-sm font-semibold text-slate-300">Status</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-white/5">
                          <tr v-if="loading" class="animate-pulse">
                              <td colspan="5" class="p-4 text-center text-slate-400">Loading orders...</td>
                          </tr>
                          <tr v-else-if="orders.length === 0">
                              <td colspan="5" class="p-8 text-center text-slate-500">No orders found.</td>
                          </tr>
                          <tr v-for="order in orders" :key="order.id" class="hover:bg-white/5 transition-colors group">
                              <td class="p-4 text-slate-300 font-mono text-sm">{{ order.order_number }}</td>
                              <td class="p-4">
                                  <div class="flex flex-col">
                                      <span class="text-white font-medium">{{ order.customer ? order.customer.name : 'Unknown' }}</span>
                                      <span class="text-xs text-slate-500">{{ order.customer ? order.customer.email : '' }}</span>
                                  </div>
                              </td>
                              <td class="p-4">
                                  <div class="flex flex-col space-y-2">
                                      <div v-for="item in order.items" :key="item.id" class="flex items-center space-x-3">
                                          <img v-if="item.product && item.product.image" :src="`/storage/${item.product.image}`" class="w-10 h-10 rounded-lg object-cover border border-white/10" alt="Product Image">
                                          <div v-else class="w-10 h-10 rounded-lg bg-slate-700 flex items-center justify-center text-xs border border-white/10">📦</div>
                                          
                                          <div class="flex flex-col">
                                              <span class="text-sm text-slate-200">{{ item.product ? item.product.name : 'Unknown Product' }}</span>
                                              <span class="text-xs text-slate-500">Qty: {{ item.qty }} x Rp {{ formatPrice(item.price) }}</span>
                                          </div>
                                      </div>
                                  </div>
                              </td>
                              <td class="p-4 text-emerald-400 font-medium">Rp {{ formatPrice(order.total_price) }}</td>
                              <td class="p-4 font-medium capitalize" :class="getStatusClass(order.status)">{{ order.status }}</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
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

const fetchOrders = async () => {
  try {
      const response = await axios.get('/admin/order_items/data');
      orders.value = response.data;
  } catch (error) {
      console.error('Error fetching orders:', error);
  } finally {
      loading.value = false;
  }
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