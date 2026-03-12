<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  volunteers: Array,
  stats: Object,
});
</script>

<template>
  <Head title="Volunteer Management" />

  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-slate-900 dark:text-slate-50 text-4xl font-black leading-tight tracking-tight">Volunteer Management</h1>
      <p class="text-slate-500 dark:text-stone-400 text-base">Coordinate temple service and volunteer community</p>
    </template>

    <div class="space-y-8">
      <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-stone-800 flex items-center gap-4">
          <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
            <span class="material-symbols-outlined text-3xl">groups</span>
          </div>
          <div>
            <p class="text-sm text-slate-500 dark:text-stone-400 font-medium">Total Volunteers</p>
            <div class="flex items-baseline gap-2">
              <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ stats.totalVolunteers }}</h3>
              <span class="text-xs font-medium text-green-600">+5%</span>
            </div>
          </div>
        </div>
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-stone-800 flex items-center gap-4">
          <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400 flex items-center justify-center">
            <span class="material-symbols-outlined text-3xl">how_to_reg</span>
          </div>
          <div>
            <p class="text-sm text-slate-500 dark:text-stone-400 font-medium">Active Today</p>
            <div class="flex items-baseline gap-2">
              <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ stats.activeToday }}</h3>
              <span class="text-xs font-medium text-green-600">+2%</span>
            </div>
          </div>
        </div>
        <div class="bg-white dark:bg-stone-900 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-stone-800 flex items-center gap-4">
          <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 flex items-center justify-center">
            <span class="material-symbols-outlined text-3xl">pending_actions</span>
          </div>
          <div>
            <p class="text-sm text-slate-500 dark:text-stone-400 font-medium">Pending Requests</p>
            <div class="flex items-baseline gap-2">
              <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ stats.pendingRequests }}</h3>
              <span class="text-xs font-medium text-rose-600">-1%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Table Section -->
      <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-slate-200 dark:border-stone-800 overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-stone-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <h2 class="text-lg font-bold text-slate-900 dark:text-white">Volunteer Directory</h2>
          <div class="flex items-center gap-2">
            <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-slate-700 dark:text-stone-300 text-sm font-bold hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined mr-2 text-xl">filter_list</span>
              Filter
            </button>
            <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-slate-700 dark:text-stone-300 text-sm font-bold hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined mr-2 text-xl">download</span>
              Export
            </button>
            <button class="flex items-center justify-center rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
              <span class="material-symbols-outlined mr-2 text-xl">person_add</span>
              Register
            </button>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="bg-slate-50 dark:bg-stone-800/50 text-slate-500 dark:text-stone-400 text-xs font-semibold uppercase tracking-wider">
                <th class="px-6 py-4">Volunteer Name</th>
                <th class="px-6 py-4">Contact Info</th>
                <th class="px-6 py-4">Skills</th>
                <th class="px-6 py-4">Assigned Task</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-stone-800">
              <tr v-for="(volunteer, index) in volunteers" :key="index" class="hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <img :src="volunteer.avatar" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-stone-700" />
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ volunteer.name }}</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-slate-900 dark:text-slate-100">{{ volunteer.email }}</div>
                  <div class="text-xs text-slate-500">{{ volunteer.phone }}</div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-wrap gap-1">
                    <span v-for="skill in volunteer.skills" :key="skill" class="px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase">
                      {{ skill }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-stone-400">{{ volunteer.task }}</td>
                <td class="px-6 py-4">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                    :class="{
                      'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': volunteer.status === 'Active',
                      'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400': volunteer.status === 'On Leave',
                      'bg-slate-100 text-slate-800 dark:bg-stone-800 dark:text-stone-400': volunteer.status === 'Inactive'
                    }"
                  >
                    {{ volunteer.status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button>
                    <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button>
                    <button class="text-slate-400 hover:text-red-500"><span class="material-symbols-outlined text-lg">delete</span></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 dark:bg-stone-800/50 flex items-center justify-between border-t border-slate-200 dark:border-stone-800">
          <p class="text-xs text-slate-500 dark:text-stone-400">Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">1,240</span> results</p>
          <div class="flex items-center gap-2">
            <button class="p-1.5 rounded-lg border border-slate-200 dark:border-stone-700 text-slate-400 hover:bg-white dark:hover:bg-stone-700 disabled:opacity-50" disabled>
              <span class="material-symbols-outlined text-lg">chevron_left</span>
            </button>
            <button class="p-1.5 rounded-lg border border-slate-200 dark:border-stone-700 text-slate-400 hover:bg-white dark:hover:bg-stone-700 font-bold text-xs px-3">1</button>
            <button class="p-1.5 rounded-lg border border-slate-200 dark:border-stone-700 text-slate-400 hover:bg-white dark:hover:bg-stone-700 transition-colors">
              <span class="material-symbols-outlined text-lg">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
