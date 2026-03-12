<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const isDarkMode = ref(false);
const searchQuery = ref('');
const showNotifications = ref(false);

const notifications = ref([
  { id: 1, text: 'New volunteer registration: Rahul Sharma', time: '2 mins ago', unread: true },
  { id: 2, text: 'Donation of ₹5,000 received from Sanjay', time: '1 hour ago', unread: true },
  { id: 3, text: 'Holi Maha Festival schedule updated', time: '5 hours ago', unread: false },
]);

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

const handleSearch = () => {
  console.log('Searching for:', searchQuery.value);
  // Implementation of global search could go here
};

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
};

const logout = () => {
  router.post(route('logout'));
};

onMounted(() => {
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDarkMode.value = true;
    document.documentElement.classList.add('dark');
  }
  
  // Close dropdowns on click outside
  window.addEventListener('click', (e) => {
    if (!e.target.closest('.notification-container')) {
      showNotifications.value = false;
    }
  });
});
</script>

<template>
  <div class="flex h-screen overflow-hidden bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-sans">
    <!-- Sidebar -->
    <aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col">
      <div class="p-6 flex items-center gap-3">
        <div class="bg-primary rounded-xl p-2 text-white">
          <span class="material-symbols-outlined text-2xl">temple_hindu</span>
        </div>
        <div>
          <h1 class="text-lg font-bold leading-none">Durga Devi</h1>
          <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mt-1">Admin Portal</p>
        </div>
      </div>
      
      <nav class="flex-1 px-4 py-4 space-y-1">
        <Link 
          href="/dashboard" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'Dashboard' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">dashboard</span>
          Dashboard
        </Link>
        <Link 
          href="/donations" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'Donations' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">volunteer_activism</span>
          Donations
        </Link>
        <Link 
          href="/events" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'Events' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">event</span>
          Events
        </Link>
        <Link 
          href="/purohits" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'Purohits' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">person</span>
          Purohits
        </Link>
        <Link 
          href="/volunteers" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'Volunteers' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">group</span>
          Volunteers
        </Link>
        <Link 
          href="/assign-volunteers" 
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
          :class="$page.component === 'AssignVolunteers' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
        >
          <span class="material-symbols-outlined">assignment_ind</span>
          Assign Volunteers
        </Link>
        
        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 space-y-1">
          <Link 
            href="/notification-logs" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
            :class="$page.component === 'NotificationLogs' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
          >
            <span class="material-symbols-outlined">history</span>
            Notification Logs
          </Link>
          <Link 
            href="/notification-settings" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors"
            :class="$page.component === 'NotificationSettings' ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800'"
          >
            <span class="material-symbols-outlined">settings_suggest</span>
            Notify Settings
          </Link>
          <Link href="/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined">settings</span>
            System Settings
          </Link>
        </div>
      </nav>

      <div class="p-4 border-t border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between p-2">
          <Link href="/profile" class="flex items-center gap-3 hover:opacity-80 transition-opacity flex-1 min-w-0">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqXUbeShDXjKSSIeptCIqT8U24u7qcMCCeCwZBnTuuPDBU7ezlmdo5APQluP8e9-tlKZkbcl6weCqLA2hTsyNHbzhibVXScg47qiXsXI-i5iU1EsbYCqkPa4ho2ZLCGVfqUlWc6nFA7tHbzgUkBGpD6tI3S7avq6ypJoPMp9obv6moB2Rm4r-BxRjUQRiZqa13RRx0Ut5dHR_u33OazfdwxYkYUjKB-RLxXk8G7gSb5PcnJMrpDaFWq8RPJwEUcG4C2ZuVA1SNATWL" alt="Admin Profile" class="w-10 h-10 rounded-full object-cover" />
            <div class="overflow-hidden">
              <p class="text-sm font-bold truncate">Shastri Ji</p>
              <p class="text-xs text-slate-500 truncate">Super Admin</p>
            </div>
          </Link>
          <button @click="logout" class="text-slate-400 hover:text-red-500 transition-colors ml-2">
            <span class="material-symbols-outlined text-xl">logout</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">
      <!-- Header -->
      <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 dark:border-slate-800 px-8 py-4 flex items-center justify-between">
        <div>
          <slot name="header" />
        </div>
        <div class="flex items-center gap-4">
          <div class="relative hidden md:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
            <input 
              v-model="searchQuery" 
              @input="handleSearch"
              type="text" 
              placeholder="Search records..." 
              class="pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-lg focus:ring-2 focus:ring-primary w-64 text-sm" 
            />
          </div>
          <button @click="toggleDarkMode" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-colors flex items-center justify-center w-10 h-10 shadow-sm border border-slate-200/50 dark:border-slate-700/50">
            <span class="material-symbols-outlined">{{ isDarkMode ? 'light_mode' : 'dark_mode' }}</span>
          </button>
          <div class="relative notification-container">
            <button @click.stop="toggleNotifications" class="relative p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-colors flex items-center justify-center w-10 h-10 shadow-sm border border-slate-200/50 dark:border-slate-700/50">
              <span class="material-symbols-outlined">notifications</span>
              <span v-if="notifications.some(n => n.unread)" class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-800"></span>
            </button>
            
            <!-- Notifications Dropdown -->
            <div v-if="showNotifications" class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
              <div class="px-5 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <h4 class="font-bold">Notifications</h4>
                <button class="text-xs text-primary font-bold hover:underline">Mark all as read</button>
              </div>
              <div class="max-h-[350px] overflow-y-auto">
                <div v-for="notification in notifications" :key="notification.id" class="px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 border-b border-slate-50 dark:border-slate-800 last:border-0 cursor-pointer transition-colors">
                  <div class="flex gap-3">
                    <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" :class="notification.unread ? 'bg-primary' : 'bg-transparent'"></div>
                    <div>
                      <p class="text-sm leading-tight mb-1" :class="notification.unread ? 'font-bold' : 'text-slate-600 dark:text-slate-400'">{{ notification.text }}</p>
                      <span class="text-[10px] text-slate-400 uppercase font-medium tracking-wider">{{ notification.time }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-5 py-3 bg-slate-50 dark:bg-slate-800/30 text-center border-t border-slate-100 dark:border-slate-800">
                <button class="text-xs font-bold text-slate-500 hover:text-primary transition-colors">View all notifications</button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="p-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<style>
/* Base theme variables are now in app.css */
</style>
