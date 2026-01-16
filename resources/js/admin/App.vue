<template>
  <div class="flex min-h-screen bg-slate-900 font-sans text-slate-100">
    <Sidebar />

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900">
      <!-- Top Bar -->
      <header class="bg-slate-900/50 backdrop-blur-md sticky top-0 z-30 border-b border-white/5 px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        
        <div class="flex items-center space-x-4">
          <div class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm border border-indigo-500/30">
            Admin
          </div>
          <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500"></div>
        </div>
      </header>

      <!-- Dashboard Content -->
      <div class="p-8 space-y-8">
        
        <!-- Welcome Section -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-700 p-8 shadow-2xl">
          <div class="relative z-10">
            <h2 class="text-3xl font-bold text-white mb-2">Welcome back, Admin!</h2>
            <p class="text-indigo-100 max-w-xl">Here's what's happening successfully in your store today.</p>
          </div>
          <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 transform skew-x-12"></div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(stat, index) in stats" :key="index" 
               class="bg-slate-800/50 backdrop-blur-xl border border-white/5 p-6 rounded-2xl hover:bg-slate-800 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
              <div :class="`p-3 rounded-xl ${stat.bgColor} ${stat.textColor}`">
                <component :is="stat.icon" class="w-6 h-6" />
              </div>
              <span :class="`text-sm font-medium ${stat.changeType === 'up' ? 'text-green-400' : 'text-red-400'} flex items-center bg-slate-900/50 px-2 py-1 rounded-lg`">
                {{ stat.change }}
                <svg v-if="stat.changeType === 'up'" class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <svg v-else class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
              </span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">{{ stat.title }}</h3>
            <p class="text-2xl font-bold text-white group-hover:scale-105 transition-transform origin-left">{{ stat.value }}</p>
          </div>
        </div>

        <!-- Recent Orders Mock -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/5 rounded-2xl p-6">
          <h3 class="text-lg font-bold text-white mb-6">Recent Activity</h3>
          <div class="space-y-4">
             <div v-for="i in 3" :key="i" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors">
                <div class="flex items-center space-x-4">
                   <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center text-lg">🛍️</div>
                   <div>
                      <p class="text-white font-medium">New Order #{{ 1023 + i }}</p>
                      <p class="text-sm text-slate-400">2 minutes ago</p>
                   </div>
                </div>
                <span class="text-green-400 font-bold">+$120.00</span>
             </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import Sidebar from '../components/sidebar/Sidebar.vue';
import { ref, markRaw } from 'vue';

// Simple SVG Icon components (inline for simplicity or extracted later)
const TrendingUpIcon = {
  template: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
}

const stats = ref([
  { 
    title: 'Total Revenue', 
    value: '$54,230', 
    change: '+12%', 
    changeType: 'up',
    icon: markRaw(TrendingUpIcon),
    bgColor: 'bg-green-500/10',
    textColor: 'text-green-400'
  },
  { 
    title: 'Active Users', 
    value: '2,430', 
    change: '+5%', 
    changeType: 'up',
    icon: markRaw(TrendingUpIcon),
    bgColor: 'bg-blue-500/10',
    textColor: 'text-blue-400'
  },
  { 
    title: 'New Orders', 
    value: '145', 
    change: '-2%', 
    changeType: 'down',
    icon: markRaw(TrendingUpIcon),
    bgColor: 'bg-purple-500/10',
    textColor: 'text-purple-400'
  }
]);
</script>