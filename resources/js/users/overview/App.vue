<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        {{ isLogin ? 'Customer Login' : 'Customer Registration' }}
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        {{ isLogin ? 'Sign in to your account' : 'Join our community' }}
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="submitForm">
          <!-- Name (Register Only) -->
          <div v-if="!isLogin">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
              <input id="name" v-model="form.name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
             <p v-if="errors.name" class="mt-2 text-sm text-red-600">{{ errors.name[0] }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
              <input id="email" v-model="form.email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
             <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
          </div>

          <!-- Password -->
           <div>
             <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
             <div class="mt-1">
               <input id="password" v-model="form.password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
             </div>
             <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
           </div>
           
          <!-- Phone (Register Only) -->
          <div v-if="!isLogin">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <div class="mt-1">
              <input id="phone" v-model="form.phone" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
             <p v-if="errors.phone" class="mt-2 text-sm text-red-600">{{ errors.phone[0] }}</p>
          </div>

          <!-- Address (Register Only) -->
           <div v-if="!isLogin">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <div class="mt-1">
              <textarea id="address" v-model="form.address" rows="3" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
             <p v-if="errors.address" class="mt-2 text-sm text-red-600">{{ errors.address[0] }}</p>
          </div>

          <div>
            <button type="submit" :disabled="loading" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
              <span v-if="loading">Processing...</span>
              <span v-else>{{ isLogin ? 'Sign In' : 'Register' }}</span>
            </button>
          </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-3">
                <button type="button" @click="toggleIsLogin" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                     {{ isLogin ? 'Create new account' : 'Sign in to existing account' }}
                </button>
            </div>
        </div>

         <div v-if="successMessage" class="mt-4 p-4 rounded-md bg-green-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ successMessage }}
                    </p>
                </div>
            </div>
        </div>
        <div v-if="errorMessage" class="mt-4 p-4 rounded-md bg-red-50">
            <div class="flex">
                 <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                     <p class="text-sm font-medium text-red-800">
                        {{ errorMessage }}
                    </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import Navbar from '../../landing/components/Navbar.vue';

const isLogin = ref(false);
const form = reactive({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: ''
});

const errors = ref({});
const loading = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

const toggleIsLogin = () => {
    isLogin.value = !isLogin.value;
    errors.value = {};
    successMessage.value = '';
    errorMessage.value = '';
    // reset form
    form.name = '';
    form.email = '';
    form.phone = '';
    form.address = '';
    form.password = '';
};

const submitForm = async () => {
  loading.value = true;
  errors.value = {};
  successMessage.value = '';
  errorMessage.value = '';

  try {
    const url = isLogin.value ? '/customers/login' : '/customers';
    const response = await axios.post(url, form);
    
    successMessage.value = isLogin.value ? 'Login successful!' : 'Registration successful! Your details have been saved.';
    
    // Store customer info in localStorage
    if (response.data.customer) {
        localStorage.setItem('customer', JSON.stringify(response.data.customer));
        // Reload page to update Navbar or emit event (reload is simpler for now)
        window.location.reload(); 
    }

    if (!isLogin.value) {
        // Clear form after registration
        form.name = '';
        form.email = '';
        form.phone = '';
        form.address = '';
        form.password = '';
    }

  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else if (error.response && error.response.status === 401) {
        errorMessage.value = error.response.data.message;
    } else {
        console.error(error);
        errorMessage.value = 'An error occurred. Please try again.';
    }
  } finally {
    loading.value = false;
  }
};
</script>