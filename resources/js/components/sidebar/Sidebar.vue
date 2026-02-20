<template>
  <aside class="w-72 bg-slate-900/50 backdrop-blur-xl border-r border-white/10 text-white min-h-screen flex flex-col transition-all duration-300">
    <div class="p-6 border-b border-white/5">
      <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent tracking-tight">Vercy Admin</h2>
    </div>

    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
      <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu</p>

      <a href="/dashboard"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/dashboard') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        Dashboard
      </a>

      <a href="/admin/orders"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/admin/orders') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Orders
      </a>

      <a href="/admin/order_items"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/admin/order_items') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Order Items
      </a>

      <a href="/admin/categories"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/admin/categories') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
        Categories
      </a>

      <a href="/admin/products"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/admin/products') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        Products
      </a>

      <a href="/admin/customers"
         :class="[
           'flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 mb-1 font-medium hover:bg-white/5 hover:text-white hover:translate-x-1', 
           isActive('/admin/customers') ? 'bg-gradient-to-r from-indigo-600/20 to-purple-600/20 text-indigo-300 border border-indigo-500/30 shadow-lg shadow-indigo-500/10' : ''
         ]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
</svg>
        Customers
      </a>
    </nav>

    <div class="p-4 border-t border-white/5">
        <form action="/logout" method="POST">
        <input type="hidden" name="_token" :value="csrf" />
        <button class="w-full flex items-center px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-colors duration-200 group">
            <svg class="w-5 h-5 mr-3 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="font-medium">Sign Out</span>
        </button>
        </form>
    </div>
  </aside>
</template>

<script setup>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

const isActive = (path) => {
  return window.location.pathname.startsWith(path);
};
</script>
