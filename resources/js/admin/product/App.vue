<template>
  <div class="flex min-h-screen bg-slate-900 font-sans text-slate-100">
    <Sidebar />

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900">
      <!-- Top Bar -->
      <header class="bg-slate-900/50 backdrop-blur-md sticky top-0 z-30 border-b border-white/5 px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Product</h1>
        
        <div class="flex items-center space-x-4">
          <div class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm border border-indigo-500/30">
            Admin
          </div>
          <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500"></div>
        </div>
      </header>

      <div class="p-8 max-w-6xl mx-auto">
        
        <!-- Add/Edit Form -->
        <div class="relative z-10 mb-8 p-6 bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl shadow-xl">
          <h2 class="text-lg font-bold text-white mb-4 flex items-center">
            <span class="mr-2">{{ form.id ? 'Edit Product' : 'Add New Product' }}</span>
            <div class="h-px bg-white/10 flex-1 ml-4"></div>
          </h2>
          
          <form @submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Product Name -->
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-400 ml-1">Product Name *</label>
                <input v-model="form.name" 
                       class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                       placeholder="e.g. iPhone 15 Pro, Nike Air Max..." 
                       required />
              </div>
              
              <!-- Price -->
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-400 ml-1">Price (Rp) *</label>
                <input v-model="form.price" 
                       type="number"
                       step="0.01"
                       min="0"
                       class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" 
                       placeholder="e.g. 15000000" 
                       required />
              </div>
            </div>
            
            <!-- Description -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-400 ml-1">Description</label>
              <textarea v-model="form.description" 
                     rows="3"
                     class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200 resize-none" 
                     placeholder="Enter product description..."></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Categories Multi-Select Combobox -->
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-400 ml-1">Categories</label>
                <div ref="categoryDropdownRef" class="relative">
                  <!-- Combobox Trigger -->
                  <div @click="toggleCategoryDropdown" 
                       class="w-full min-h-[48px] bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white cursor-pointer transition-all duration-300 flex items-center flex-wrap gap-2"
                       :class="{ 
                         'ring-2 ring-indigo-500/50 border-indigo-500/50 shadow-lg shadow-indigo-500/10': showCategoryDropdown,
                         'hover:border-white/20 hover:bg-slate-900/70': !showCategoryDropdown 
                       }">
                    <!-- Selected Tags -->
                    <span v-if="form.category_ids.length === 0" class="text-slate-500">Select categories...</span>
                    <span v-for="catId in form.category_ids" :key="catId"
                          class="inline-flex items-center gap-1 px-2.5 py-1 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 rounded-lg text-sm transition-all duration-200 hover:bg-indigo-500/30">
                      {{ getCategoryName(catId) }}
                      <button @click.stop="removeCategory(catId)" type="button" 
                              class="ml-1 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                      </button>
                    </span>
                    <!-- Dropdown Arrow -->
                    <svg class="w-5 h-5 ml-auto text-slate-400 transition-transform duration-300" 
                         :class="{ 'rotate-180': showCategoryDropdown }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>
                  
                  <!-- Dropdown Options -->
                  <transition 
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 translate-y-1"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 translate-y-1">
                    <div v-if="showCategoryDropdown" 
                         class="absolute z-50 w-full mt-2 bg-slate-800 border border-white/10 rounded-xl shadow-2xl shadow-black/50 overflow-hidden backdrop-blur-xl">
                      <div v-if="categories.length === 0" class="p-4 text-slate-500 text-sm text-center">
                        No categories available
                      </div>
                      <div v-else class="max-h-48 overflow-y-auto custom-scrollbar">
                        <div v-for="cat in categories" :key="cat.id"
                             @click="toggleCategory(cat.id)"
                             class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all duration-150"
                             :class="form.category_ids.includes(cat.id) 
                               ? 'bg-indigo-500/20 text-indigo-300' 
                               : 'text-slate-300 hover:bg-white/5'">
                          <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-all duration-200"
                               :class="form.category_ids.includes(cat.id) 
                                 ? 'bg-indigo-500 border-indigo-500' 
                                 : 'border-slate-500'">
                            <svg v-if="form.category_ids.includes(cat.id)" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                          </div>
                          <span class="text-sm font-medium">{{ cat.name }}</span>
                        </div>
                      </div>
                    </div>
                  </transition>
                </div>
              </div>
              
              <!-- Status -->
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-400 ml-1">Status</label>
                <div class="relative">
                  <select v-model="form.status" 
                          class="w-full appearance-none bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 pr-10 text-white cursor-pointer transition-all duration-300 hover:border-white/20 hover:bg-slate-900/70 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:shadow-lg focus:shadow-indigo-500/10">
                    <option value="active" class="bg-slate-800 text-white">Active</option>
                    <option value="inactive" class="bg-slate-800 text-white">Inactive</option>
                  </select>
                  <!-- Custom Arrow -->
                  <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </div>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-4 pt-2">
              <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-indigo-500/20 transform transition-all duration-200 hover:scale-105 active:scale-95 flex items-center">
                <svg v-if="!form.id" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <svg v-else class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                {{ form.id ? 'Update Product' : 'Add Product' }}
              </button>
              <button v-if="form.id" @click="cancelEdit" type="button" class="bg-white/5 hover:bg-white/10 text-slate-300 font-semibold py-3 px-6 rounded-xl border border-white/5 transition-all duration-200">
                Cancel
              </button>
            </div>
          </form>
        </div>

        <!-- Product Table -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl shadow-xl overflow-hidden">
          <div class="p-6 border-b border-white/5 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">All Products</h3>
            <span class="text-sm text-slate-400 bg-white/5 px-3 py-1 rounded-lg border border-white/5">{{ products.length }} entries</span>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-white/5">
                  <th class="p-4 pl-6">#</th>
                  <th class="p-4">Name</th>
                  <th class="p-4">Categories</th>
                  <th class="p-4">Price</th>
                  <th class="p-4">Status</th>
                  <th class="p-4 pr-6 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="text-sm divide-y divide-white/5">
                <tr v-for="(p, i) in products" :key="p.id" class="hover:bg-white/5 transition-colors duration-150 group">
                  <td class="p-4 pl-6 font-medium text-slate-400">{{ i + 1 }}</td>
                  <td class="p-4 text-white font-medium">
                    <div>{{ p.name }}</div>
                    <div v-if="p.description" class="text-xs text-slate-500 truncate max-w-xs">{{ p.description }}</div>
                  </td>
                  <td class="p-4">
                    <div class="flex flex-wrap gap-1 max-w-xs">
                      <span v-for="cat in p.categories" :key="cat.id"
                            class="px-2 py-0.5 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 rounded-full text-xs">
                        {{ cat.name }}
                      </span>
                      <span v-if="!p.categories || p.categories.length === 0" class="text-slate-500 text-xs">-</span>
                    </div>
                  </td>
                  <td class="p-4 text-emerald-400 font-medium">Rp {{ formatPrice(p.price) }}</td>
                  <td class="p-4">
                    <span :class="p.status === 'active' 
                      ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' 
                      : 'bg-red-500/20 text-red-400 border-red-500/30'" 
                      class="px-2 py-1 rounded-full text-xs font-medium border">
                      {{ p.status }}
                    </span>
                  </td>
                  <td class="p-4 pr-6 text-right">
                    <div class="flex justify-end space-x-2">
                       <button @click="edit(p)" class="p-2 rounded-lg text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 transition-colors">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                       </button>
                       <button @click="confirmDelete(p.id)" class="p-2 rounded-lg text-red-400 hover:bg-red-500/20 hover:text-red-300 transition-colors">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                       </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="products.length === 0">
                  <td colspan="6" class="p-8 text-center text-slate-500">
                    No products found. Add one above!
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
      title="Delete Product"
      message="Are you sure you want to delete this product? This action cannot be undone."
      @confirm="executeDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>

<script setup>
import Sidebar from '../../components/sidebar/Sidebar.vue';
import ConfirmModal from '../../components/ui/ConfirmModal.vue';
import { ref, reactive, onMounted, onUnmounted } from 'vue';

const products = ref([]);
const categories = ref([]);
const form = reactive({ 
  id: null, 
  name: '', 
  description: '', 
  price: '', 
  status: 'active',
  category_ids: []
});

// Modal State
const showDeleteModal = ref(false);
const itemToDelete = ref(null);

// Category Combobox State
const showCategoryDropdown = ref(false);
const categoryDropdownRef = ref(null);

const toggleCategoryDropdown = () => {
    showCategoryDropdown.value = !showCategoryDropdown.value;
}

const toggleCategory = (id) => {
    const index = form.category_ids.indexOf(id);
    if (index === -1) {
        form.category_ids.push(id);
    } else {
        form.category_ids.splice(index, 1);
    }
}

const removeCategory = (id) => {
    const index = form.category_ids.indexOf(id);
    if (index !== -1) {
        form.category_ids.splice(index, 1);
    }
}

const getCategoryName = (id) => {
    const cat = categories.value.find(c => c.id === id);
    return cat ? cat.name : '';
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (categoryDropdownRef.value && !categoryDropdownRef.value.contains(event.target)) {
        showCategoryDropdown.value = false;
    }
}

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
}

const load = async () => {
    try {
        const res = await fetch('/admin/products/data');
        if (res.ok) {
           const data = await res.json();
           products.value = data.products;
           categories.value = data.categories;
        }
    } catch (e) {
        console.error("Failed to load products", e);
    }
}

const save = async () => {
    if (!form.name || !form.price) return;

    const url = form.id
      ? `/admin/products/${form.id}`
      : `/admin/products`;

    try {
        await fetch(url, {
            method: form.id ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                name: form.name,
                description: form.description,
                price: form.price,
                status: form.status,
                category_ids: form.category_ids
            })
        });
        
        cancelEdit();
        load();
    } catch (e) {
        console.error("Failed to save", e);
    }
}

const edit = (p) => {
    form.id = p.id;
    form.name = p.name;
    form.description = p.description || '';
    form.price = p.price;
    form.status = p.status;
    form.category_ids = p.categories ? p.categories.map(c => c.id) : [];
}

const cancelEdit = () => {
    form.id = null;
    form.name = '';
    form.description = '';
    form.price = '';
    form.status = 'active';
    form.category_ids = [];
    showCategoryDropdown.value = false;
}

const confirmDelete = (id) => {
    itemToDelete.value = id;
    showDeleteModal.value = true;
}

const executeDelete = async () => {
    if (!itemToDelete.value) return;
    
    try {
        await fetch(`/admin/products/${itemToDelete.value}`, {
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
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* Custom Scrollbar for Dropdown */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.5);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.7);
}

/* Select option styling */
select option {
    background-color: #1e293b;
    color: white;
    padding: 8px;
}
</style>
