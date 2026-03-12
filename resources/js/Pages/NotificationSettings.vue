<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  settings: Object,
});

const form = useForm({
  auto_assignment_emails: props.settings.auto_assignment_emails,
  schedule_change_alerts: props.settings.schedule_change_alerts,
  reminder_notifications: props.settings.reminder_notifications,
  first_reminder_timing: props.settings.first_reminder_timing,
  final_reminder_timing: props.settings.final_reminder_timing,
  delivery_methods: props.settings.delivery_methods,
});

const submit = () => {
  // form.post(route('notification-settings.update'));
};
</script>

<template>
  <Head title="Notification Settings" />

  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Notification Settings</h1>
      <p class="text-slate-500 dark:text-stone-400 mt-2">Configure alerts and delivery preferences for temple staff</p>
    </template>

    <div class="max-w-4xl mx-auto space-y-6 mt-4">
      <!-- Section 1: Email & Alerts -->
      <section class="bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-stone-800 bg-slate-50 dark:bg-stone-800/50">
          <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Email & Instant Alerts</h2>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-stone-800">
          <!-- Automatic Assignment Emails -->
          <div class="flex items-center justify-between p-6 hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
            <div class="flex items-start gap-4">
              <div class="bg-primary/10 p-3 rounded-lg text-primary">
                <span class="material-symbols-outlined">mail</span>
              </div>
              <div>
                <p class="font-bold text-slate-900 dark:text-slate-100">Automatic Assignment Emails</p>
                <p class="text-sm text-slate-500 dark:text-stone-400">Notify priests and staff immediately when a new seva or task is assigned.</p>
              </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input v-model="form.auto_assignment_emails" class="sr-only peer" type="checkbox" />
              <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-stone-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
            </label>
          </div>
          <!-- Schedule Change Alerts -->
          <div class="flex items-center justify-between p-6 hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
            <div class="flex items-start gap-4">
              <div class="bg-primary/10 p-3 rounded-lg text-primary">
                <span class="material-symbols-outlined">calendar_month</span>
              </div>
              <div>
                <p class="font-bold text-slate-900 dark:text-slate-100">Schedule Change Alerts</p>
                <p class="text-sm text-slate-500 dark:text-stone-400">Receive alerts when temple puja timings or festival dates are modified.</p>
              </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input v-model="form.schedule_change_alerts" class="sr-only peer" type="checkbox" />
              <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-stone-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
            </label>
          </div>
          <!-- Reminder Notifications -->
          <div class="flex items-center justify-between p-6 hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
            <div class="flex items-start gap-4">
              <div class="bg-primary/10 p-3 rounded-lg text-primary">
                <span class="material-symbols-outlined">notifications_active</span>
              </div>
              <div>
                <p class="font-bold text-slate-900 dark:text-slate-100">Reminder Notifications</p>
                <p class="text-sm text-slate-500 dark:text-stone-400">Automated reminders for upcoming shifts and temple duties.</p>
              </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input v-model="form.reminder_notifications" class="sr-only peer" type="checkbox" />
              <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-stone-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
            </label>
          </div>
        </div>
      </section>

      <!-- Section 2: Configuration -->
      <section class="bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-stone-800 bg-slate-50 dark:bg-stone-800/50">
          <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Reminder Configuration</h2>
        </div>
        <div class="p-6 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">First Reminder Timing</label>
              <select v-model="form.first_reminder_timing" class="w-full bg-slate-50 dark:bg-stone-800 border-slate-200 dark:border-stone-700 rounded-lg text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary">
                <option value="48h">48 hours before</option>
                <option value="24h">24 hours before</option>
                <option value="12h">12 hours before</option>
                <option value="6h">6 hours before</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Final Reminder Timing</label>
              <select v-model="form.final_reminder_timing" class="w-full bg-slate-50 dark:bg-stone-800 border-slate-200 dark:border-stone-700 rounded-lg text-slate-900 dark:text-slate-100 focus:ring-primary focus:border-primary">
                <option value="3h">3 hours before</option>
                <option value="1h">1 hour before</option>
                <option value="30m">30 minutes before</option>
                <option value="start">At start time</option>
              </select>
            </div>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Delivery Method</label>
            <div class="flex flex-wrap gap-4">
              <label v-for="method in ['Email', 'SMS', 'Push']" :key="method" class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-stone-800 px-4 py-2 rounded-lg border border-slate-200 dark:border-stone-700 hover:border-primary/50 transition-colors">
                <input v-model="form.delivery_methods" :value="method" class="text-primary focus:ring-primary rounded" type="checkbox" />
                <span class="text-sm font-medium">{{ method }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>

      <!-- Save Button -->
      <div class="flex justify-end pt-4">
        <button @click="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-transform active:scale-95 flex items-center gap-2">
          <span class="material-symbols-outlined text-sm">save</span>
          Save Changes
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
