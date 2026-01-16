<template>
  <Transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <!-- Backdrop -->
      <div 
        @click="$emit('cancel')" 
        class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity"
      ></div>

      <!-- Modal Content -->
      <div class="relative w-full max-w-md bg-slate-800/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-6 transform transition-all">
        <div class="mb-6 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-500/10 mb-4">
                <svg class="h-8 w-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">{{ title }}</h3>
            <p class="text-slate-400">{{ message }}</p>
        </div>

        <div class="flex gap-3 justify-end">
            <button 
                @click="$emit('cancel')"
                class="flex-1 px-4 py-2.5 rounded-xl border border-white/10 text-slate-300 hover:bg-white/5 transition-colors font-medium"
            >
                Cancel
            </button>
            <button 
                @click="$emit('confirm')"
                class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white shadow-lg shadow-red-500/20 transition-all font-medium"
            >
                Delete
            </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
defineProps({
  show: Boolean,
  title: {
    type: String,
    default: 'Confirm Action'
  },
  message: {
    type: String,
    default: 'Are you sure you want to perform this action?'
  }
});

defineEmits(['confirm', 'cancel']);
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
