<template>
  <div class="flex min-h-screen bg-slate-900 font-sans text-slate-100">
    <Sidebar />

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900">
      <!-- Top Bar -->
      <header class="bg-slate-900/50 backdrop-blur-md sticky top-0 z-30 border-b border-white/5 px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Customers</h1>
        
        <div class="flex items-center space-x-4">
          <div class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm border border-indigo-500/30">
            Admin
          </div>
          <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500"></div>
        </div>
      </header>

      <div class="p-8 max-w-6xl mx-auto">
        
        <!-- Add/Edit Form -->
        <div class="mb-8 p-6 bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl shadow-xl">
          <h2 class="text-lg font-bold text-white mb-4 flex items-center">
            <span class="mr-2">{{ form.id ? 'Edit Customer' : 'Add New Customer' }}</span>
            <div class="h-px bg-white/10 flex-1 ml-4"></div>
          </h2>
          
          <form @submit.prevent="save" class="space-y-4">
         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex-1 space-y-2">
              <label class="text-sm font-medium text-slate-400 ml-1">Customer Name</label>
              <input v-model="form.name" 
                     class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                     placeholder="" />
            </div>

            <div class="flex-1 space-y-2">
              <label class="text-sm font-medium text-slate-400 ml-1">Customer Email</label>
              <input v-model="form.email" 
                     class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                     placeholder="must using @ parentheses..." />
            </div>
            <div class="flex-1 space-y-2">
              <label class="text-sm font-medium text-slate-400 ml-1">Customer Phone</label>
              <input v-model="form.phone" 
                     class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                     placeholder="" />
            </div>
            <div class="flex-1 space-y-2">
              <label class="text-sm font-medium text-slate-400 ml-1">Customer Address</label>
              <input v-model="form.address" 
                     class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                     placeholder="" />
            </div>

        </div>
        
        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-indigo-500/20 transform transition-all duration-200 hover:scale-105 active:scale-95 flex items-center">
              <svg v-if="!form.id" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
              <svg v-else class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
              {{ form.id ? 'Update Customer' : 'Add Customer' }}
            </button>
            <button v-if="form.id" @click="cancelEdit" type="button" class="bg-white/5 hover:bg-white/10 text-slate-300 font-semibold py-3 px-6 rounded-xl border border-white/5 transition-all duration-200">
              Cancel
            </button>
        </div>
      </form>
        </div>

        <!-- customers Table -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl shadow-xl overflow-hidden">
          <div class="p-6 border-b border-white/5 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">All Customers</h3>
            <span class="text-sm text-slate-400 bg-white/5 px-3 py-1 rounded-lg border border-white/5">{{ customers.length }} entries</span>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-white/5">
                  <th class="p-4 pl-6">#</th>
                  <th class="p-4">Name</th>
                  <th class="p-4">Email</th>
                  <th class="p-4">Phone</th>
                  <th class="p-4">Address</th>
                  <th class="p-4 pr-6 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-white/5">
                <tr v-for="(c,i) in customers" :key="c.id" class="hover:bg-white/5 transition-colors duration-150 group">
                  <td class="p-4 pl-6 font-medium text-slate-400">{{ i+1 }}</td>
                  <td class="p-4 text-white font-medium">{{ c.name }}</td>
                  <td class="p-4 text-slate-300">{{ c.email }}</td>
                  <td class="p-4 text-slate-300">{{ c.phone }}</td>
                  <td class="p-4 text-slate-300 max-w-xs truncate">{{ c.address }}</td>
                  <td class="p-4 pr-6 text-right">
                    <div class="flex justify-end space-x-2">
                       <button @click="edit(c)" class="p-2 rounded-lg text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 transition-colors">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                       </button>
                       <button @click="confirmDelete(c.id)" class="p-2 rounded-lg text-red-400 hover:bg-red-500/20 hover:text-red-300 transition-colors">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                       </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="customers.length === 0">
                  <td colspan="6" class="p-8 text-center text-slate-500">
                    No customers found. Add one above!
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <ConfirmModal 
      :show="showDeleteModal"
      title="Delete Customer"
      message="Are you sure you want to delete this customer? This action cannot be undone."
      @confirm="executeDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>

<script setup>
import Sidebar from '../../components/sidebar/Sidebar.vue';
import ConfirmModal from '../../components/ui/ConfirmModal.vue';
import { ref, reactive, onMounted } from 'vue';

const customers = ref([]);
const form = reactive({ id: null, name: '', email: '', phone: '', address: '' });

// Modal State
const showDeleteModal = ref(false);
const itemToDelete = ref(null);

const load = async () => {
    try {
        const res = await fetch('/admin/customers/data');
        if (res.ok) {
           customers.value = await res.json();
        }
    } catch (e) {
        console.error("Failed to load customers", e);
    }
}

const save = async () => {
    if(!form.name) return;

    const url = form.id
    ? `/admin/customers/${form.id}`
    : `/admin/customers`

    try {
        await fetch(url, {
            method: form.id ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ name: form.name, email: form.email, phone: form.phone, address: form.address })
        });
        
        cancelEdit();
        load();
    } catch (e) {
        console.error("Failed to save", e);
    }
}

const edit = (c) => {
    form.id = c.id;
    form.name = c.name;
    form.email = c.email;
    form.phone = c.phone;
    form.address = c.address;
}

const cancelEdit = () => {
    form.id = null;
    form.name = '';
    form.email = '';
    form.phone = '';
    form.address = '';
}

const confirmDelete = (id) => {
    itemToDelete.value = id;
    showDeleteModal.value = true;
}

const executeDelete = async () => {
    if (!itemToDelete.value) return;
    
    try {
        await fetch(`/admin/customers/${itemToDelete.value}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        load();
    } catch (e) {
        console.error("Failed to delete", e);
    } finally {
        showDeleteModal.value = false;
        itemToDelete.value = null;
    }
}

onMounted(() => {
    load();
});
</script>
