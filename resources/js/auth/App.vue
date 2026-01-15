<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 font-sans text-white">
    <!-- Glassmorphism Card -->
    <div class="relative w-full max-w-md p-8 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl">
      
      <!-- Decorative Elements -->
      <div class="absolute -top-12 -left-12 w-32 h-32 bg-indigo-500/30 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-purple-500/30 rounded-full blur-3xl"></div>

      <h1 class="text-3xl font-bold text-center mb-2 tracking-tight">Welcome Back</h1>
      <p class="text-center text-gray-400 mb-8 text-sm">Sign in to access your dashboard</p>

      <form @submit.prevent="handleLogin" class="space-y-6 relative z-10">
        
        <!-- Email Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-300 ml-1">Email Address</label>
          <input v-model="form.email"
                 type="email"
                 placeholder="name@example.com"
                 :class="{'border-red-500/50 focus:ring-red-500/50': errors.email || frontErrors.email}"
                 class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" />
          <p v-if="frontErrors.email" class="text-red-400 text-xs ml-1">{{ frontErrors.email }}</p>
          <p v-if="errors.email" class="text-red-400 text-xs ml-1">{{ errors.email[0] }}</p>
        </div>

        <!-- Password Input -->
        <div class="space-y-2">
          <label class="text-sm font-medium text-gray-300 ml-1">Password</label>
          <input v-model="form.password"
                 type="password"
                 placeholder="••••••••"
                 :class="{'border-red-500/50 focus:ring-red-500/50': errors.password || frontErrors.password}"
                 class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200" />
          <p v-if="frontErrors.password" class="text-red-400 text-xs ml-1">{{ frontErrors.password }}</p>
          <p v-if="errors.password" class="text-red-400 text-xs ml-1">{{ errors.password[0] }}</p>
        </div>

        <!-- Global Message -->
        <div v-if="message" class="p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-200 text-sm text-center">
          {{ message }}
        </div>

        <!-- Login Button -->
        <button type="submit" 
                :disabled="isLoading"
                class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold py-3 rounded-lg shadow-lg shadow-indigo-500/20 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center">
          <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span v-if="!isLoading">Sign In</span>
          <span v-else>Signing in...</span>
        </button>

      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';

const form = reactive({
  email: '',
  password: ''
});

const errors = ref({}); // Backend errors
const frontErrors = ref({}); // Frontend errors
const message = ref('');
const isLoading = ref(false);

const validate = () => {
  frontErrors.value = {};
  let isValid = true;
  
  // Stricter email regex
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

  if (!form.email) {
    frontErrors.value.email = 'Email address is required';
    isValid = false;
  } else if (!emailPattern.test(form.email)) {
    frontErrors.value.email = 'Please enter a valid email address (e.g., user@example.com)';
    isValid = false;
  }

  if (!form.password) {
    frontErrors.value.password = 'Password is required';
    isValid = false;
  } else if (form.password.length < 8) {
    frontErrors.value.password = 'Password must be at least 8 characters long';
    isValid = false;
  }

  return isValid;
};

const handleLogin = async () => {
  if (!validate()) return;

  isLoading.value = true;
  errors.value = {};
  frontErrors.value = {}; // Clear front errors on submit
  message.value = '';

  try {
    const res = await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(form)
    });

    const data = await res.json();

    if (res.status === 422) {
        errors.value = data.errors;
       
        if (data.errors.email) {
           
        }
    } else if (!res.ok) {
        
        message.value = data.message || 'Invalid credentials. Please try again.';
    } else {
      
        window.location.href = data.redirect || '/admin/dashboard';
    }
  } catch (error) {
    message.value = 'Network error. Please check your connection.';
    console.error(error);
  } finally {
    isLoading.value = false;
  }
};
</script>
