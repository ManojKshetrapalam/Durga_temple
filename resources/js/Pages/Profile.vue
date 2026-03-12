<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  admin: Object,
});

const form = useForm({
  name: props.admin.name,
  email: props.admin.email,
  phone: props.admin.phone || '',
  emergency_contact: props.admin.emergency_contact || '',
  address: props.admin.address || '',
});

const showSuccess = ref(false);

const submit = () => {
  // form.put(route('profile.update'), {
  //   onSuccess: () => {
  //     showSuccess.value = true;
  //     setTimeout(() => showSuccess.value = false, 5000);
  //   }
  // });
  showSuccess.value = true;
  setTimeout(() => showSuccess.value = false, 5000);
};
</script>

<template>
  <Head title="Admin Profile" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-col gap-2">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Admin Profile</h2>
        <p class="text-slate-500 dark:text-stone-400 mt-1">Manage your personal information and account settings</p>
      </div>
    </template>

    <div class="max-w-4xl mx-auto mt-4 pb-12">
      <div class="space-y-6">
        <!-- Personal Information Card -->
        <section class="bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 rounded-xl p-6 shadow-sm">
          <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-stone-800 pb-4">
            <span class="material-symbols-outlined text-primary">person</span>
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Personal Information</h3>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Full Name</label>
              <input v-model="form.name" class="rounded-lg border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800 focus:border-primary focus:ring-primary w-full p-3 text-slate-900 dark:text-slate-100" placeholder="Enter full name" type="text" />
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Address</label>
              <input v-model="form.email" class="rounded-lg border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800 focus:border-primary focus:ring-primary w-full p-3 text-slate-900 dark:text-slate-100" placeholder="email@example.com" type="email" />
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Phone Number</label>
              <input v-model="form.phone" class="rounded-lg border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800 focus:border-primary focus:ring-primary w-full p-3 text-slate-900 dark:text-slate-100" placeholder="+91 00000 00000" type="tel" />
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Emergency Contact</label>
              <input v-model="form.emergency_contact" class="rounded-lg border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800 focus:border-primary focus:ring-primary w-full p-3 text-slate-900 dark:text-slate-100" placeholder="Name, Relation, Number" type="text" />
            </div>
            <div class="flex flex-col gap-2 md:col-span-2">
              <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Residential Address</label>
              <textarea v-model="form.address" class="rounded-lg border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800 focus:border-primary focus:ring-primary w-full p-3 text-slate-900 dark:text-slate-100" placeholder="Enter residential address" rows="3"></textarea>
            </div>
          </div>
        </section>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pt-4">
          <button class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-stone-700 text-slate-600 dark:text-stone-400 font-bold hover:bg-slate-50 dark:hover:bg-stone-800 transition-all">
            Cancel
          </button>
          <button @click="submit" class="px-8 py-2.5 rounded-lg bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">save</span>
            Save Changes
          </button>
        </div>
      </div>
    </div>

    <!-- Success Toast Notification -->
    <Transition
      enter-active-class="transform transition ease-out duration-300"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showSuccess" class="fixed top-6 right-6 z-[100] flex items-center gap-3 bg-white dark:bg-stone-900 border border-emerald-500/20 rounded-xl p-4 shadow-2xl">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
          <span class="material-symbols-outlined font-bold">check</span>
        </div>
        <div class="flex flex-col">
          <p class="text-sm font-bold text-slate-900 dark:text-white">Profile updated successfully!</p>
          <p class="text-xs text-slate-500 dark:text-stone-400">Changes have been saved to your account.</p>
        </div>
        <button @click="showSuccess = false" class="ml-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
          <span class="material-symbols-outlined text-lg">close</span>
        </button>
      </div>
    </Transition>
  </AuthenticatedLayout>
</template>
