<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  username: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Admin Login" />

  <div class="font-sans bg-deep-maroon min-h-screen flex items-center justify-center m-0 overflow-hidden">
    <div class="flex w-full h-screen overflow-hidden">
      <!-- Left side image -->
      <div class="hidden lg:block lg:w-3/5 xl:w-2/3 relative">
        <div class="absolute inset-0 bg-black/10 z-10"></div>
        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBKyo-kStcDygPrf4BQ3szYMiirZlu9akZMEc5teHJOjMByau1dHKyzBowWXeqesOP8zR_REmHxFiXXIX0_JTCK9j4UrzWPt5bhLF59cSgj6j1vYHPO-PQ1daclWFdTzgYMGcbiGj2i7774C03tYz11x729iKHRZe5bVaDJxYnY2vylKFBT-G4Rao-W9YBKWYQuElcJnWNHFF-rcatNeiV_PwTXKfbd7WCBA5rBhzhjSnZC7b9UzF8Hl8NcPw-yE2FOSN-VaHDoyXhJ')"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-deep-maroon z-20"></div>
      </div>

      <!-- Right side form -->
      <div class="w-full lg:w-2/5 xl:w-1/3 flex items-center justify-center p-6 bg-maroon-pattern relative">
        <div class="lg:hidden absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBKyo-kStcDygPrf4BQ3szYMiirZlu9akZMEc5teHJOjMByau1dHKyzBowWXeqesOP8zR_REmHxFiXXIX0_JTCK9j4UrzWPt5bhLF59cSgj6j1vYHPO-PQ1daclWFdTzgYMGcbiGj2i7774C03tYz11x729iKHRZe5bVaDJxYnY2vylKFBT-G4Rao-W9YBKWYQuElcJnWNHFF-rcatNeiV_PwTXKfbd7WCBA5rBhzhjSnZC7b9UzF8Hl8NcPw-yE2FOSN-VaHDoyXhJ')"></div>
        
        <div class="relative z-30 w-full max-w-md bg-maroon/80 backdrop-blur-md border-gold-ornate p-8 md:p-10 shadow-2xl">
          <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-6">
              <span class="material-symbols-outlined text-gold text-6xl">temple_hindu</span>
            </div>
            <h1 class="font-serif-grandeur text-3xl md:text-4xl text-saffron tracking-wider mb-2">Durga Devi Temple</h1>
            <div class="flex items-center justify-center gap-2">
              <div class="h-px w-8 bg-gold/50"></div>
              <p class="font-body-serif text-gold/80 italic text-sm md:text-base tracking-widest uppercase">Sacred Portal Access</p>
              <div class="h-px w-8 bg-gold/50"></div>
            </div>
          </div>

          <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-2">
              <label class="block text-xs font-semibold text-saffron uppercase tracking-widest">Username</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gold/60 text-xl">person</span>
                <input v-model="form.username" class="w-full pl-10 pr-4 py-3 bg-deep-maroon/50 border border-gold/30 text-saffron placeholder:text-gold/30 focus:ring-1 focus:ring-gold focus:border-gold outline-none transition-all rounded-none" placeholder="Enter admin username" type="text" required />
              </div>
            </div>
            <div class="space-y-2">
              <label class="block text-xs font-semibold text-saffron uppercase tracking-widest">Password</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gold/60 text-xl">lock</span>
                <input v-model="form.password" class="w-full pl-10 pr-4 py-3 bg-deep-maroon/50 border border-gold/30 text-saffron placeholder:text-gold/30 focus:ring-1 focus:ring-gold focus:border-gold outline-none transition-all rounded-none" placeholder="Enter admin password" type="password" required />
              </div>
            </div>
            <div class="flex items-center justify-between py-1">
              <div class="flex items-center gap-2">
                <input v-model="form.remember" class="w-4 h-4 bg-deep-maroon border-gold/50 text-maroon focus:ring-gold rounded-none" id="remember" type="checkbox" />
                <label class="text-xs text-gold/70 font-medium uppercase tracking-tighter cursor-pointer" for="remember">Remember me</label>
              </div>
              <a class="text-xs font-semibold text-saffron hover:text-gold transition-colors uppercase tracking-tighter" href="#">Forgot Password?</a>
            </div>
            
            <button class="w-full bg-gold hover:bg-saffron text-deep-maroon font-serif-grandeur font-bold text-lg py-4 px-4 transition-all shadow-lg hover:shadow-gold/20 flex items-center justify-center gap-3 active:scale-[0.98]" type="submit" :disabled="form.processing">
              <span class="material-symbols-outlined">shield_person</span>
              <span>Secure Login</span>
            </button>

            <div v-if="form.errors" class="text-red-500 text-xs text-center mt-2">
              {{ Object.values(form.errors)[0] }}
            </div>

            <div class="pt-8 text-center">
              <div class="relative flex items-center justify-center mb-2">
                <div class="absolute w-full h-px bg-gold/20"></div>
                <span class="relative px-4 bg-transparent text-[10px] text-gold/40 uppercase tracking-[0.3em] font-bold">Divine Authority Only</span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.font-serif-grandeur { font-family: 'Cinzel', serif; }
.font-body-serif { font-family: 'Lora', serif; }
.bg-deep-maroon { background-color: #3a0a0a; }
.bg-maroon { background-color: #5d1010; }
.text-gold { color: #d4af37; }
.text-saffron { color: #f4c430; }
.bg-gold { background-color: #d4af37; }
.hover\:bg-saffron:hover { background-color: #f4c430; }
.border-gold\/30 { border-color: rgba(212, 175, 55, 0.3); }

.bg-maroon-pattern {
    background-color: #3a0a0a;
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuA6Vu6WOphpKvzgq4fTuMAhD6dj3k_bwxzn2WOKqZf7BB_y-XTfj9_ilmKQaDi43lYq0zDxS-LVhTb2K9JG9Nv7k7erRo3dHDFcw84QZFnDUBanMAQEgHYxxufGDNAH557r8LZj-llI72po7HCMV5hnJJ4en-__W5WA0agNMJfodc6osvd9ZkKDBVyLrjcjOB05RpIvGrLGVcS_gQQ-jfM5PjbXhVEciExF-MrAfI95H6PeYQZ6gPye2gFZmtyOPZBqXu6kxBDyWDPK);
}

.border-gold-ornate {
    border: 2px solid #d4af37;
    position: relative;
}

.border-gold-ornate::before {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    right: 2px;
    bottom: 2px;
    border: 1px solid #f4c430;
    pointer-events: none;
}
</style>
