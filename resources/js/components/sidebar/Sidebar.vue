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
