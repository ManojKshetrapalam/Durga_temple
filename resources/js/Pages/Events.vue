<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
  events: Array,
  purohits: Array,
});

const localEvents = ref([...props.events]);
const activeTab = ref('All Events');
const tabs = ['All Events', 'Festival', 'Daily Ritual', 'Special Event', 'Completed'];

// Modal State
const isModalOpen = ref(false);
const modalMode = ref('Add'); // 'Add' or 'Edit'
const editingEvent = ref({
  title: '',
  type: 'Festival',
  month: 'Mar',
  day: '',
  time: '',
  purohit: '',
  status: 'Scheduled'
});

// Dropdown State
const activeMoreMenu = ref(null);

const filteredEvents = computed(() => {
  let filtered = activeTab.value === 'All Events' 
    ? localEvents.value 
    : (activeTab.value === 'Completed' 
        ? localEvents.value.filter(e => e.status === 'Completed') 
        : localEvents.value.filter(e => e.type === activeTab.value));
  return filtered;
});

const openAddModal = () => {
  modalMode.value = 'Add';
  editingEvent.value = { title: '', type: 'Festival', month: 'Mar', day: '', time: '', purohit: '', status: 'Scheduled' };
  isModalOpen.value = true;
};

const openEditModal = (event, index) => {
  modalMode.value = 'Edit';
  editingEvent.value = { ...event, _index: index };
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const saveEvent = () => {
  if (modalMode.value === 'Add') {
    localEvents.value.push({ ...editingEvent.value });
  } else {
    // Find correctly by some ID or index. Since we use localEvents, index might change if filtered.
    // We'll use a temporary approach for mock data
    const idx = localEvents.value.findIndex(e => e === editingEvent.value._original); // Not reliable
    // Better: use the index passed
    if (editingEvent.value._index !== undefined) {
       localEvents.value[editingEvent.value._index] = { ...editingEvent.value };
    }
  }
  closeModal();
};

const deleteEvent = (index) => {
  if (confirm('Are you sure you want to delete this event?')) {
    localEvents.value.splice(index, 1);
  }
};

const toggleMoreMenu = (index) => {
  activeMoreMenu.value = activeMoreMenu.value === index ? null : index;
};

// Close menus on click outside
onMounted(() => {
  window.addEventListener('click', (e) => {
    if (!e.target.closest('.more-menu-container')) {
      activeMoreMenu.value = null;
    }
  });
});
</script>

<template>
  <Head title="Events Management" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 w-full">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight mb-2">Events Management</h1>
          <p class="text-slate-500 dark:text-slate-400">Manage upcoming festivals and daily rituals for the temple schedule.</p>
        </div>
        <button @click="openAddModal" class="flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
          <span class="material-symbols-outlined text-base">add</span>
          Add New Event
        </button>
      </div>
    </template>

    <div class="space-y-6">
      <!-- Tabs -->
      <div class="flex border-b border-primary/10 mb-6 overflow-x-auto whitespace-nowrap scrollbar-hide">
        <button 
          v-for="tab in tabs" 
          :key="tab"
          @click="activeTab = tab"
          class="px-6 py-4 border-b-2 text-sm transition-all"
          :class="activeTab === tab ? 'border-primary text-primary font-bold' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-primary font-medium'"
        >
          {{ tab === 'Festival' ? 'Festivals' : (tab === 'Daily Ritual' ? 'Daily Rituals' : (tab === 'Special Event' ? 'Special Pujas' : tab)) }}
        </button>
      </div>

      <!-- Event Cards/List -->
      <div class="grid gap-4">
        <div v-for="(event, index) in filteredEvents" :key="index" class="group bg-white dark:bg-background-dark/40 border border-primary/5 rounded-xl p-5 hover:border-primary/30 transition-all hover:shadow-md relative">
          <div class="flex flex-wrap items-center gap-6">
            <div 
              class="w-16 h-16 rounded-xl flex flex-col items-center justify-center border transition-colors"
              :class="event.type === 'Festival' ? 'bg-primary/10 text-primary border-primary/20 group-hover:bg-primary group-hover:text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 border-slate-200 dark:border-slate-700'"
            >
              <span class="text-xs font-bold uppercase">{{ event.month }}</span>
              <span class="text-2xl font-black">{{ event.day }}</span>
            </div>
            <div class="flex-1 min-w-[200px]">
              <div class="flex items-center gap-3 mb-1">
                <h3 class="text-lg font-bold group-hover:text-primary transition-colors" :class="{ 'line-through text-slate-400': event.status === 'Completed' }">{{ event.title }}</h3>
                <span 
                  class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                  :class="event.type === 'Festival' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-800 dark:border-slate-700'"
                >
                  {{ event.type }}
                </span>
              </div>
              <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-base">schedule</span>
                  {{ event.time }}
                </div>
                <div class="flex items-center gap-1.5 font-medium">
                  <span class="material-symbols-outlined text-base">person</span>
                  {{ event.purohit }}
                </div>
              </div>
            </div>
            <div class="flex items-center gap-4 min-w-[120px]">
              <span 
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold"
                :class="{
                  'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400': event.status === 'Scheduled',
                  'bg-primary/10 text-primary border border-primary/20': event.status === 'In Progress',
                  'bg-slate-100 text-slate-500 dark:bg-slate-800/50': event.status === 'Completed'
                }"
              >
                <span v-if="event.status === 'Scheduled'" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span v-if="event.status === 'In Progress'" class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                <span v-if="event.status === 'Completed'" class="material-symbols-outlined text-sm">check_circle</span>
                {{ event.status }}
              </span>
            </div>
            <div class="flex items-center gap-2">
              <button @click="openEditModal(event, index)" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all">
                <span class="material-symbols-outlined">edit</span>
              </button>
              <button @click="deleteEvent(index)" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                <span class="material-symbols-outlined">delete</span>
              </button>
              <div class="relative more-menu-container">
                <button @click.stop="toggleMoreMenu(index)" class="p-2 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all">
                  <span class="material-symbols-outlined">more_vert</span>
                </button>
                <!-- Dropdown Menu -->
                <div v-if="activeMoreMenu === index" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 z-20 py-2 overflow-hidden">
                  <button class="w-full px-4 py-2 text-left text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">content_copy</span>
                    Duplicate Event
                  </button>
                  <button class="w-full px-4 py-2 text-left text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">print</span>
                    Print Schedule
                  </button>
                  <button class="w-full px-4 py-2 text-left text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">share</span>
                    Share Details
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div v-if="filteredEvents.length === 0" class="py-12 text-center bg-white dark:bg-background-dark/40 border border-dashed border-primary/20 rounded-xl">
          <p class="text-slate-500">No events found in this category.</p>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="filteredEvents.length > 0" class="mt-8 flex items-center justify-between border-t border-primary/10 pt-6">
        <p class="text-sm text-slate-500 dark:text-slate-400">Showing <span class="font-bold text-slate-900 dark:text-slate-100">1 to {{ filteredEvents.length }}</span> of <span class="font-bold text-slate-900 dark:text-slate-100">{{ localEvents.length }}</span> events</p>
        <div class="flex items-center gap-2">
          <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-primary/10 text-slate-400 hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined">chevron_left</span>
          </button>
          <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold">1</button>
          <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-primary/10 text-slate-400 hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined">chevron_right</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Add/Edit Event Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
      <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
          <h3 class="text-xl font-bold">{{ modalMode }} Event</h3>
          <button @click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500">Event Title</label>
              <input v-model="editingEvent.title" type="text" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50" placeholder="e.g. Holi Celebration" />
            </div>
            <div class="space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500">Event Type</label>
              <select v-model="editingEvent.type" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50">
                <option>Festival</option>
                <option>Daily Ritual</option>
                <option>Special Event</option>
              </select>
            </div>
            <div class="space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500">Status</label>
              <select v-model="editingEvent.status" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50">
                <option>Scheduled</option>
                <option>In Progress</option>
                <option>Completed</option>
              </select>
            </div>
            <div class="space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500">Day</label>
              <input v-model="editingEvent.day" type="text" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50" placeholder="e.g. 25" />
            </div>
            <div class="space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500">Time Range</label>
              <input v-model="editingEvent.time" type="text" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50" placeholder="08:00 AM - 04:00 PM" />
            </div>
            <div class="col-span-2 space-y-1">
              <label class="text-xs font-bold uppercase text-slate-500 tracking-wider">Assigned Purohit / Group</label>
              <select v-model="editingEvent.purohit" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/50 font-medium">
                <option value="">Select a Purohit</option>
                <option v-for="p in purohits" :key="p.id" :value="p.name">{{ p.name }}</option>
                <option value="Smt. Meera Bai Group">Smt. Meera Bai Group</option>
                <option value="Other">Other / External</option>
              </select>
            </div>
          </div>
        </div>
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 flex items-center justify-end gap-3">
          <button @click="closeModal" class="px-5 py-2 text-sm font-bold text-slate-600 hover:text-slate-900">Cancel</button>
          <button @click="saveEvent" class="px-6 py-2 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
            {{ modalMode === 'Add' ? 'Create Event' : 'Update Event' }}
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
