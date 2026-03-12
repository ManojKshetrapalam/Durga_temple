<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  event: Object,
  availableVolunteers: Array,
  assignedVolunteers: Array,
});
</script>

<template>
  <Head :title="`Assign Volunteers - ${event.title}`" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-wrap justify-between items-end gap-4">
        <div class="flex min-w-72 flex-col gap-2">
          <span class="text-primary font-semibold text-xs uppercase tracking-wider">Active Event</span>
          <h1 class="text-slate-900 dark:text-slate-100 text-4xl font-black leading-tight tracking-[-0.033em]">{{ event.title }}</h1>
          <div class="flex items-center gap-4 text-slate-500 dark:text-stone-400 text-base font-normal">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> {{ event.date }}</span>
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> {{ event.location }}</span>
          </div>
        </div>
        <button class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-6 bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all text-sm font-bold">
          <span class="truncate">Edit Event Details</span>
        </button>
      </div>
    </template>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
      <!-- Left: Available Volunteers Column -->
      <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="flex flex-col gap-4">
          <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold">Find Available Volunteers</h2>
          <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
              <span class="material-symbols-outlined text-xl">search</span>
            </div>
            <input class="block w-full p-4 pl-12 text-sm text-slate-900 dark:text-slate-100 border-none rounded-lg bg-white dark:bg-stone-900 focus:ring-2 focus:ring-primary shadow-sm" placeholder="Search by skill (e.g. Puja Setup, Crowd Control, Decoration)..." type="text" />
          </div>
        </div>

        <div class="flex flex-col gap-3">
          <div class="flex items-center justify-between px-2">
            <span class="text-sm font-medium text-slate-500 dark:text-stone-400 uppercase tracking-wide">Top Matches ({{ availableVolunteers.length }})</span>
            <button class="text-primary text-xs font-bold hover:underline">Filter by Availability</button>
          </div>

          <!-- Volunteer Cards -->
          <div v-for="volunteer in availableVolunteers" :key="volunteer.id" class="flex items-center gap-4 bg-white dark:bg-stone-900 p-4 rounded-xl border border-slate-100 dark:border-stone-800 hover:border-primary/30 transition-all shadow-sm group">
            <img :src="volunteer.avatar" class="rounded-full h-14 w-14 object-cover" />
            <div class="flex flex-1 flex-col">
              <div class="flex justify-between">
                <p class="text-slate-900 dark:text-slate-100 text-base font-bold">{{ volunteer.name }}</p>
                <span class="text-[10px] bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-2 py-0.5 rounded-full font-bold uppercase">Available</span>
              </div>
              <p class="text-slate-500 dark:text-stone-400 text-sm mt-1">
                <span class="font-medium text-primary/80">Skills:</span> {{ volunteer.skills.join(', ') }}
              </p>
            </div>
            <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">
              Assign
            </button>
          </div>
        </div>
      </div>

      <!-- Right: Assigned Volunteers Panel -->
      <div class="flex flex-col gap-4 bg-slate-50 dark:bg-stone-800/50 p-6 rounded-2xl border border-slate-200 dark:border-stone-800">
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold">Assigned Crew</h2>
          <span class="bg-primary/20 text-primary text-xs px-2 py-1 rounded-md font-bold">{{ assignedVolunteers.length }} / 15</span>
        </div>

        <div class="space-y-4">
          <!-- Assigned Items -->
          <div v-for="assigned in assignedVolunteers" :key="assigned.id" class="flex items-center gap-3 p-3 bg-white dark:bg-stone-900 rounded-lg shadow-sm border-l-4 border-primary">
            <img :src="assigned.avatar" class="size-10 rounded-full object-cover" />
            <div class="flex-1">
              <p class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ assigned.name }}</p>
              <p class="text-[11px] text-primary font-medium">{{ assigned.role }}</p>
            </div>
            <button class="text-slate-300 hover:text-red-500 transition-colors">
              <span class="material-symbols-outlined text-lg">cancel</span>
            </button>
          </div>
        </div>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-stone-800">
          <div class="bg-primary/5 rounded-lg p-4">
            <p class="text-xs text-slate-600 dark:text-stone-400 leading-relaxed italic">
              "Team, please ensure you arrive 2 hours before the first Aarti session for final briefing."
            </p>
          </div>
          <button class="w-full mt-4 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 py-3 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity shadow-sm">
            Save Assignments
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
