<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  logs: Array,
  stats: Object,
});
</script>

<template>
  <Head title="Notification Logs" />

  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-slate-900 dark:text-slate-50 text-4xl font-black leading-tight tracking-tight">Notification Logs</h1>
      <p class="text-slate-500 dark:text-stone-400 text-base">Monitor temple communications and delivery history</p>
    </template>

    <div class="space-y-8">
      <!-- Stats Summary -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl border border-slate-200 dark:border-stone-800 shadow-sm flex flex-col gap-2">
          <p class="text-slate-500 dark:text-stone-400 text-sm font-medium uppercase tracking-wider">Total Sent (Month)</p>
          <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ stats.totalSent }}</span>
            <span class="text-green-600 text-sm font-bold flex items-center gap-0.5">
              <span class="material-symbols-outlined text-sm">trending_up</span>12%
            </span>
          </div>
        </div>
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl border border-slate-200 dark:border-stone-800 shadow-sm flex flex-col gap-2">
          <p class="text-slate-500 dark:text-stone-400 text-sm font-medium uppercase tracking-wider">Success Rate</p>
          <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ stats.successRate }}%</span>
            <span class="text-green-600 text-sm font-bold flex items-center gap-0.5">
              <span class="material-symbols-outlined text-sm">trending_up</span>0.5%
            </span>
          </div>
        </div>
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl border border-slate-200 dark:border-stone-800 shadow-sm flex flex-col gap-2">
          <p class="text-slate-500 dark:text-stone-400 text-sm font-medium uppercase tracking-wider">Pending Retries</p>
          <div class="flex items-baseline gap-2">
            <span class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ stats.pendingRetries }}</span>
            <span class="text-rose-600 text-sm font-bold flex items-center gap-0.5">
              <span class="material-symbols-outlined text-sm">trending_down</span>5%
            </span>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white dark:bg-stone-900 p-6 rounded-xl border border-slate-200 dark:border-stone-800 shadow-sm flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
          <label class="block text-xs font-bold text-slate-500 dark:text-stone-400 uppercase mb-1">Date Range</label>
          <select class="w-full bg-slate-50 dark:bg-stone-800 border-slate-200 dark:border-stone-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <option>Last 7 Days</option>
            <option>Last 30 Days</option>
            <option>Last 3 Months</option>
          </select>
        </div>
        <div class="flex-1 min-w-[150px]">
          <label class="block text-xs font-bold text-slate-500 dark:text-stone-400 uppercase mb-1">Type</label>
          <select class="w-full bg-slate-50 dark:bg-stone-800 border-slate-200 dark:border-stone-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <option>All Types</option>
            <option>SMS</option>
            <option>Email</option>
            <option>Push</option>
          </select>
        </div>
        <div class="flex-1 min-w-[150px]">
          <label class="block text-xs font-bold text-slate-500 dark:text-stone-400 uppercase mb-1">Status</label>
          <select class="w-full bg-slate-50 dark:bg-stone-800 border-slate-200 dark:border-stone-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
            <option>All Statuses</option>
            <option>Sent</option>
            <option>Pending</option>
            <option>Failed</option>
          </select>
        </div>
        <button class="bg-primary hover:bg-primary/90 text-white px-6 h-10 rounded-lg font-bold text-sm transition-colors flex items-center gap-2">
          <span class="material-symbols-outlined text-xl">filter_alt</span>
          Apply
        </button>
      </div>

      <!-- Table -->
      <div class="bg-white dark:bg-stone-900 rounded-xl border border-slate-200 dark:border-stone-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="bg-slate-50 dark:bg-stone-800/50 border-b border-slate-100 dark:border-stone-800">
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400">Recipient</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400">Contact</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400 text-center">Type</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400">Event/Trigger</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400">Date & Time</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400">Status</th>
                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-500 dark:text-stone-400 text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-stone-800">
              <tr v-for="(log, index) in logs" :key="index" class="hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
                <td class="px-6 py-4">
                  <div class="font-bold text-sm text-slate-900 dark:text-slate-100">{{ log.recipient }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-stone-400">{{ log.contact }}</td>
                <td class="px-6 py-4">
                  <div class="flex justify-center text-primary">
                    <span class="material-symbols-outlined text-xl">{{ log.typeIcon }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ log.event }}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-stone-400">{{ log.datetime }}</td>
                <td class="px-6 py-4">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase"
                    :class="{
                      'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': log.status === 'Sent',
                      'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400': log.status === 'Pending',
                      'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400': log.status === 'Failed'
                    }"
                  >
                    {{ log.status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right">
                  <button class="text-primary hover:text-primary/70 text-sm font-bold">Details</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="bg-slate-50 dark:bg-stone-800/50 px-6 py-4 border-t border-slate-100 dark:border-stone-800 flex items-center justify-between">
          <p class="text-xs text-slate-500 dark:text-stone-400 font-medium">Showing 1 to 5 of {{ stats.totalSent }} entries</p>
          <div class="flex gap-2">
            <button class="px-3 py-1 rounded border border-slate-200 dark:border-stone-700 text-slate-500 dark:text-stone-400 hover:bg-white dark:hover:bg-stone-800 disabled:opacity-50" disabled>
              <span class="material-symbols-outlined text-sm">chevron_left</span>
            </button>
            <button class="px-3 py-1 rounded bg-primary text-white font-bold text-xs ring-4 ring-primary/20">1</button>
            <button class="px-3 py-1 rounded border border-slate-200 dark:border-stone-700 text-slate-600 dark:text-stone-400 hover:bg-white dark:hover:bg-stone-800 transition-colors">
              <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
