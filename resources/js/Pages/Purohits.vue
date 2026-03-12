<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  purohits: Array,
});

const searchQuery = ref('');
const isModalOpen = ref(false);

const form = useForm({
  name: '',
  phone: '',
  email: '',
  specialization: '',
  experience: '',
});

const filteredPurohits = computed(() => {
  if (!searchQuery.value) return props.purohits;
  const query = searchQuery.value.toLowerCase();
  return props.purohits.filter(p => 
    p.name.toLowerCase().includes(query) || 
    p.specialization?.toLowerCase().includes(query)
  );
});

const openModal = () => isModalOpen.value = true;
const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
};

const savePurohit = () => {
  form.post('/purohits', {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      alert(`Purohit ${form.name} added successfully!`);
    },
  });
};
</script>

<template>
  <Head title="Purohit Management" />

  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-slate-900 dark:text-slate-50 text-4xl font-black leading-tight tracking-tight">Purohit Management</h1>
      <p class="text-slate-500 dark:text-stone-400 text-base">Manage temple priests and their specializations</p>
    </template>

    <div class="space-y-8">
      <!-- Main Table Section -->
      <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm border border-slate-200 dark:border-stone-800 overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-stone-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div class="relative flex-1 max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search by name or specialization..." 
              class="w-full pl-10 pr-4 h-10 bg-slate-50 dark:bg-stone-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20 transition-all"
            />
          </div>
          <div class="flex items-center gap-2">
            <button @click="openModal" class="flex items-center justify-center rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all font-bold uppercase tracking-wider">
              <span class="material-symbols-outlined mr-2 text-xl">person_add</span>
              Add Purohit
            </button>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="bg-slate-50 dark:bg-stone-800/50 text-slate-500 dark:text-stone-400 text-[10px] font-bold uppercase tracking-widest">
                <th class="px-6 py-4">Purohit Name</th>
                <th class="px-6 py-4">Contact Info</th>
                <th class="px-6 py-4">Specialization</th>
                <th class="px-6 py-4 text-center">Experience</th>
                <th class="px-6 py-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-stone-800">
              <tr v-for="purohit in filteredPurohits" :key="purohit.id" class="hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors group">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg border border-primary/20">
                      {{ purohit.name.charAt(0) }}
                    </div>
                    <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">{{ purohit.name }}</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ purohit.phone }}</div>
                  <div class="text-[10px] text-slate-500">{{ purohit.email || 'No email provided' }}</div>
                </td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-stone-800 text-slate-600 dark:text-stone-400 text-[10px] font-bold uppercase tracking-wider">
                    {{ purohit.specialization }}
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  <span class="text-sm font-black text-slate-900 dark:text-white">{{ purohit.experience }}</span>
                  <span class="text-[10px] font-bold text-slate-400 ml-1 uppercase tracking-tighter">Years</span>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-primary/10 hover:text-primary transition-all"><span class="material-symbols-outlined text-lg font-bold">edit</span></button>
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all"><span class="material-symbols-outlined text-lg font-bold">delete</span></button>
                  </div>
                </td>
              </tr>
              <tr v-if="filteredPurohits.length === 0">
                <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-stone-400 font-bold uppercase tracking-widest text-xs">No purohits found matching your search.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add Purohit Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-300">
      <div class="bg-white dark:bg-stone-900 w-full max-w-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden transform animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-slate-100 dark:border-stone-800 flex items-center justify-between bg-slate-50/50 dark:bg-stone-800/50">
          <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">ADD NEW PUROHIT</h3>
          <button @click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-stone-700 transition-colors">
            <span class="material-symbols-outlined text-slate-500 text-xl font-bold">close</span>
          </button>
        </div>

        <form @submit.prevent="savePurohit" class="p-6 space-y-4">
          <div class="space-y-1.5">
            <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Full Name</label>
            <input v-model="form.name" type="text" required placeholder="Purohit's Name" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Phone Number</label>
              <input v-model="form.phone" type="tel" required placeholder="+91 ..." class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
            </div>
            <div class="space-y-1.5">
              <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Experience (Years)</label>
              <input v-model="form.experience" type="number" placeholder="Years" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Email Address</label>
            <input v-model="form.email" type="email" placeholder="email@example.com" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
          </div>

          <div class="space-y-1.5">
            <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Specialization</label>
            <input v-model="form.specialization" type="text" placeholder="e.g. Vedic Rituals, Astrology" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
          </div>

          <div class="pt-4 flex gap-3">
            <button @click="closeModal" type="button" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors uppercase tracking-wider">Cancel</button>
            <button type="submit" :disabled="form.processing" class="flex-2 px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest disabled:opacity-50">
              {{ form.processing ? 'ADDING...' : 'ADD PUROHIT' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
