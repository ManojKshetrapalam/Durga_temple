<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
  donations: Array,
  stats: Object,
});

const getToday = () => new Date().toISOString().split('T')[0];

const startDate = ref(getToday());
const endDate = ref(getToday());

// Sync local state with props for instant updates and filtering
const localDonations = ref([...props.donations]);
watch(() => props.donations, (newDonations) => {
  localDonations.value = [...newDonations];
});

const resetToToday = () => {
  startDate.value = getToday();
  endDate.value = getToday();
};

const filterTime = ref('Custom Range');

const isModalOpen = ref(false);
const form = useForm({
  name: '',
  amount: '',
  date: getToday(),
  method: 'Cash',
  status: 'Completed'
});

const filteredDonations = computed(() => {
  return localDonations.value.filter(donation => {
    // Parse the display date (e.g., "Oct 24, 2023") or ISO date
    let donationDate;
    if (donation.date.includes(',')) {
      donationDate = new Date(donation.date);
    } else {
      donationDate = new Date(donation.date);
    }
    
    const start = new Date(startDate.value);
    const end = new Date(endDate.value);
    
    // Set hours to 0 to compare dates only
    donationDate.setHours(0,0,0,0);
    start.setHours(0,0,0,0);
    end.setHours(0,0,0,0);
    
    return donationDate >= start && donationDate <= end;
  });
});

const totalFilteredAmount = computed(() => {
  return filteredDonations.value.reduce((sum, d) => sum + parseFloat(d.amount.toString().replace(/,/g, '')), 0);
});

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  form.reset();
};

const formatDateForDisplay = (dateStr) => {
  const options = { month: 'short', day: 'numeric', year: 'numeric' };
  return new Date(dateStr).toLocaleDateString('en-US', options);
};

const handleExport = () => {
  alert(`Exporting ${filteredDonations.value.length} donations to CSV...`);
};

const saveDonation = () => {
  form.post('/donations', {
    preserveScroll: true,
    onSuccess: () => {
      alert(`Successfully recorded donation of ₹${form.amount} from ${form.name}`);
      closeModal();
    },
  });
};
</script>

<template>
  <Head title="Donations Management" />

  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-slate-900 dark:text-slate-50 text-4xl font-black leading-tight tracking-tight">Donations Management</h1>
      <p class="text-slate-500 dark:text-stone-400 text-base">Track and record temple contributions and donor relationships</p>
    </template>

    <div class="space-y-8">
      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex flex-col gap-3 rounded-xl p-6 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 shadow-sm transition-all duration-300">
          <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-stone-400 text-sm font-medium uppercase tracking-wider">Filtered Total</p>
            <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-2">payments</span>
          </div>
          <div class="flex items-baseline gap-2">
            <p class="text-slate-900 dark:text-slate-50 text-3xl font-black tracking-tight">₹{{ totalFilteredAmount.toLocaleString('en-IN') }}</p>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Selected Range</span>
          </div>
        </div>
        <div class="flex flex-col gap-3 rounded-xl p-6 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 shadow-sm">
          <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-stone-400 text-sm font-medium">This Year</p>
            <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-2">auto_graph</span>
          </div>
          <div class="flex items-baseline gap-2">
            <p class="text-slate-900 dark:text-slate-50 text-3xl font-bold tracking-tight">₹{{ stats.thisYear }}</p>
            <p class="text-green-600 dark:text-green-400 text-sm font-bold flex items-center">
              <span class="material-symbols-outlined text-sm">trending_up</span> 8%
            </p>
          </div>
        </div>
        <div class="flex flex-col gap-3 rounded-xl p-6 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-800 shadow-sm">
          <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-stone-400 text-sm font-medium">Total Donors</p>
            <span class="material-symbols-outlined text-primary bg-primary/10 rounded-full p-2">group</span>
          </div>
          <div class="flex items-baseline gap-2">
            <p class="text-slate-900 dark:text-slate-50 text-3xl font-bold tracking-tight">{{ stats.totalDonors }}</p>
            <p class="text-green-600 dark:text-green-400 text-sm font-bold flex items-center">
              <span class="material-symbols-outlined text-sm">trending_up</span> 5%
            </p>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="bg-white dark:bg-stone-900 rounded-xl border border-slate-200 dark:border-stone-800 overflow-hidden shadow-sm">
        <!-- Filters Bar -->
        <div class="flex flex-wrap items-center gap-4 p-4 border-b border-slate-200 dark:border-stone-800 bg-slate-50/50 dark:bg-stone-800/50">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 rounded-xl px-3 py-1.5 shadow-sm">
              <span class="text-[10px] font-bold uppercase text-slate-400">From</span>
              <input v-model="startDate" type="date" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-32 font-bold" />
            </div>
            <div class="flex items-center gap-2 bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 rounded-xl px-3 py-1.5 shadow-sm">
              <span class="text-[10px] font-bold uppercase text-slate-400">To</span>
              <input v-model="endDate" type="date" class="bg-transparent border-none p-0 text-sm focus:ring-0 w-32 font-bold" />
            </div>
            <button @click="resetToToday" class="p-2 text-slate-400 hover:text-primary transition-colors bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 rounded-xl shadow-sm" title="Reset to Today">
              <span class="material-symbols-outlined">restart_alt</span>
            </button>
          </div>
          <div class="flex gap-2">
             <button @click="handleExport" class="flex items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-slate-700 dark:text-stone-300 text-sm font-bold hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined mr-2 text-xl">download</span>
              Export
            </button>
            <button @click="openModal" class="flex items-center justify-center rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
              <span class="material-symbols-outlined mr-2 text-xl">add_box</span>
              New Donation
            </button>
          </div>
        </div>

        <!-- Recent Donations Table -->
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="bg-slate-50 dark:bg-stone-800/50 text-slate-500 dark:text-stone-400 uppercase text-[10px] font-bold tracking-wider">
                <th class="px-6 py-4">Donor Name</th>
                <th class="px-6 py-4">Amount</th>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Method</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-stone-800">
              <tr v-if="filteredDonations.length === 0">
                <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-stone-500 italic">
                  No donations found for the selected range.
                </td>
              </tr>
              <tr v-for="(donation, index) in filteredDonations" :key="index" class="hover:bg-slate-50 dark:hover:bg-stone-800/30 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                      {{ donation.name.split(' ').map(n => n[0]).join('') }}
                    </div>
                    <span class="font-medium text-slate-900 dark:text-slate-100">{{ donation.name }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 font-black text-slate-900 dark:text-slate-100">₹{{ donation.amount }}</td>
                <td class="px-6 py-4 text-slate-600 dark:text-stone-400 text-sm font-medium">{{ donation.date }}</td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2 text-slate-600 dark:text-stone-400 text-sm">
                    <span class="material-symbols-outlined text-lg">payments</span>
                    {{ donation.method }}
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide"
                    :class="donation.status === 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'"
                  >
                    {{ donation.status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-right">
                  <button class="text-slate-400 hover:text-primary"><span class="material-symbols-outlined">more_vert</span></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-stone-800/50 border-t border-slate-200 dark:border-stone-800">
          <p class="text-sm text-slate-500 dark:text-stone-400 font-medium">Showing <span class="font-bold text-slate-900 dark:text-slate-100">{{ filteredDonations.length }}</span> results</p>
          <div class="flex gap-2">
            <button class="px-3 py-1 text-sm border border-slate-200 dark:border-stone-700 rounded-md bg-white dark:bg-stone-800 hover:bg-slate-50 disabled:opacity-50" disabled>Previous</button>
            <button class="px-3 py-1 text-sm border border-slate-200 dark:border-stone-700 rounded-md bg-white dark:bg-stone-800 hover:bg-slate-50">Next</button>
          </div>
        </div>
      </div>
    </div>

    <!-- New Donation Modal -->
    <Teleport to="body">
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="closeModal"></div>
        <div class="relative bg-white dark:bg-stone-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
          <div class="p-6 border-b border-slate-100 dark:border-stone-800 flex justify-between items-center bg-slate-50/50 dark:bg-stone-800/50">
            <h3 class="text-xl font-black text-slate-900 dark:text-slate-50 uppercase tracking-tight">Record Donation</h3>
            <button @click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
              <span class="material-symbols-outlined">close</span>
            </button>
          </div>
          
          <form @submit.prevent="saveDonation" class="p-6 space-y-4">
            <div class="space-y-1.5">
              <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Donor Name</label>
              <input v-model="form.name" type="text" required placeholder="Full Name" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Amount</label>
                <div class="relative">
                  <span class="absolute left-4 top-3 text-slate-400 text-sm font-bold">₹</span>
                  <input v-model="form.amount" type="number" required placeholder="0.00" class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl pl-8 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-bold" />
                </div>
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Date</label>
                <input v-model="form.date" type="date" required class="w-full bg-slate-100 dark:bg-stone-800 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium" />
              </div>
            </div>

            <div class="space-y-1.5">
              <label class="text-[10px] font-bold uppercase text-slate-500 tracking-wider">Payment Method</label>
              <div class="grid grid-cols-3 gap-2">
                <button 
                  v-for="method in ['Cash', 'Online', 'Cheque']" 
                  :key="method"
                  type="button"
                  @click="form.method = method"
                  class="py-2.5 rounded-xl border-2 text-xs font-bold uppercase transition-all"
                  :class="form.method === method ? 'border-primary bg-primary/5 text-primary' : 'border-transparent bg-slate-100 dark:bg-stone-800 text-slate-400 hover:bg-slate-200'"
                >
                  {{ method }}
                </button>
              </div>
            </div>

            <div class="pt-4 flex gap-3">
              <button @click="closeModal" type="button" class="flex-1 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors uppercase tracking-wider">Cancel</button>
              <button type="submit" :disabled="form.processing" class="flex-2 px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest disabled:opacity-50">
                {{ form.processing ? 'Recording...' : 'Record' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </AuthenticatedLayout>
</template>
