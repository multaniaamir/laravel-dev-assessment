<script setup lang="ts">
import Hero from '@/Components/Dashboard/Hero.vue';
import JobCard from '@/Components/Dashboard/JobCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  jobs: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <!-- Hero -->
    <Hero />

    <!-- Job List -->
    <div class="bg-white">
      <div class="container py-5">
        <div v-if="jobs.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <JobCard v-for="job in jobs" :key="job.id" :job="job" />
        </div>
        <div v-else class="text-center text-gray-600">
          No jobs found matching your search criteria.
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>