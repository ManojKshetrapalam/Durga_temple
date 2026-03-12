<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

defineProps({
  stats: Object,
  recentDonations: Array,
  upcomingEvents: Array,
});

const getToday = () => new Date().toISOString().split('T')[0];
const startDate = ref(getToday());
const endDate = ref(getToday());

const resetToToday = () => {
  startDate.value = getToday();
  endDate.value = getToday();
};

const dateLabel = computed(() => {
  if (startDate.value === getToday() && endDate.value === getToday()) return 'Today';
  return 'Selected Range';
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-col">
        <h2 class="text-2xl font-extrabold tracking-tight">Dashboard Overview</h2>
        <p class="text-sm text-slate-500 font-medium">Welcome back, Administrator.</p>
      </div>
    </template>

    <div class="space-y-8">
      <!-- Date Filter Bar -->
      <div class="flex items-center justify-end gap-3 mb-2">
        <div class="flex items-center gap-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-1.5 shadow-sm">
          <span class="text-[10px] font-bold uppercase text-slate-400">Range</span>
          <div class="flex items-center gap-1">
            <input v-model="startDate" type="date" class="bg-transparent border-none p-0 text-xs focus:ring-0 w-28" />
            <span class="text-slate-300">-</span>
            <input v-model="endDate" type="date" class="bg-transparent border-none p-0 text-xs focus:ring-0 w-28" />
          </div>
        </div>
        <button @click="resetToToday" class="p-2 text-slate-400 hover:text-primary transition-colors bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm" title="Reset to Today">
          <span class="material-symbols-outlined text-xl">restart_alt</span>
        </button>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <Link href="/donations" class="group bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
              <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-1 rounded-full">+12.5%</span>
          </div>
          <p class="text-sm font-bold text-slate-500 uppercase tracking-tight">{{ dateLabel }} Donations</p>
          <h3 class="text-3xl font-black mt-1 group-hover:text-primary transition-colors">₹4,50,000</h3>
        </Link>

        <Link href="/events" class="group bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-primary/10 rounded-xl text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
              <span class="material-symbols-outlined text-2xl">calendar_month</span>
            </div>
          </div>
          <p class="text-sm font-bold text-slate-500 uppercase tracking-tight">{{ dateLabel }} Events</p>
          <h3 class="text-3xl font-black mt-1 group-hover:text-primary transition-colors">12</h3>
        </Link>

        <Link href="/volunteers" class="group bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
              <span class="material-symbols-outlined text-2xl">person_add</span>
            </div>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-1 rounded-full">New</span>
          </div>
          <p class="text-sm font-bold text-slate-500 uppercase tracking-tight">Volunteer Requests</p>
          <h3 class="text-3xl font-black mt-1 group-hover:text-primary transition-colors">8</h3>
        </Link>

        <div class="group bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all duration-300">
          <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-600">
              <span class="material-symbols-outlined text-2xl">group</span>
            </div>
            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-1 rounded-full">+15%</span>
          </div>
          <p class="text-sm font-bold text-slate-500 uppercase tracking-tight">Daily Visitors</p>
          <h3 class="text-3xl font-black mt-1">1,240</h3>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Donations Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-bold text-lg">Recent Donations</h3>
            <Link href="/donations" class="text-primary text-sm font-semibold hover:underline">View All</Link>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead class="bg-slate-50 dark:bg-slate-800/50">
                <tr>
                  <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Donor Name</th>
                  <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Amount</th>
                  <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                <tr 
                  v-for="(donation, index) in recentDonations" 
                  :key="index"
                  @click="router.visit('/donations')"
                  class="hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-colors"
                >
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs">
                        {{ donation.name.split(' ').map(n => n[0]).join('') }}
                      </div>
                      <span class="text-sm font-medium">{{ donation.name }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm font-bold">₹{{ donation.amount }}</td>
                  <td class="px-6 py-4 text-sm text-slate-500">{{ donation.date }}</td>
                  <td class="px-6 py-4">
                    <span 
                      class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide"
                      :class="donation.status === 'Confirmed' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-600'"
                    >
                      {{ donation.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Festival List -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="font-bold text-lg">Upcoming Festivals</h3>
          </div>
          <div class="p-6 flex-1 space-y-6">
            <div class="space-y-4 pt-4">
              <div v-for="(event, index) in upcomingEvents" :key="index" class="flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex flex-col items-center justify-center">
                  <span class="text-[10px] font-bold text-primary uppercase leading-none">{{ event.month }}</span>
                  <span class="text-lg font-bold text-primary leading-none">{{ event.day }}</span>
                </div>
                <div>
                  <p class="text-sm font-bold">{{ event.title }}</p>
                  <p class="text-xs text-slate-500">{{ event.time }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="p-4 bg-slate-50 dark:bg-slate-800/50">
            <Link href="/events" class="w-full block py-2 bg-primary text-white rounded-lg font-bold text-sm hover:opacity-90 transition-opacity text-center">Add New Event</Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
