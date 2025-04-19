<script setup>
defineProps({
  job: {
    type: Object,
    required: true,
  },
});

// Compute the full logo URL
const getLogoUrl = (logoPath) => {
  if (!logoPath) return null;
  // Prepend '/storage/' to the logo path
  return `/storage/${logoPath}`;
};
</script>

<template>
  <div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <div class="flex items-center">
      <img
        v-if="getLogoUrl(job.company_logo)"
        :src="getLogoUrl(job.company_logo)"
        :alt="job.company"
        class="h-12 w-12 object-contain mr-4"
      />
      <span v-else class="text-gray-500 mr-4">No Logo</span>
      <div>
        <h2 class="text-xl font-bold">{{ job.title }}</h2>
        <p class="text-gray-600">{{ job.company }} - {{ job.location }}</p>
      </div>
    </div>
    <p class="mt-2 text-gray-700">{{ job.description?.substring(0, 100) }}...</p>
    <div class="mt-2">
      <span
        class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1"
      >
        {{ job.job_type }}
      </span>
      <span
        class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-1"
      >
        {{ job.experience }} years
      </span>
      <span
        class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full mr-1"
      >
        ${{ job.salary?.toFixed(2) }}
      </span>
    </div>
    <div class="mt-2">
      <span
        v-for="skill in job.skills"
        :key="skill.id"
        class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1"
      >
        {{ skill.name }}
      </span>
    </div>
  </div>
</template>