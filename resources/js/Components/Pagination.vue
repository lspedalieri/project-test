<template>
    <div class="flex items-center justify-center space-x-1">
      <Component
        :is="link.url ? 'a' : 'span'"
        v-for="(link, index) in links"
        :key="index"
        :href="link.url"
        v-html="link.label"
        class="px-3 py-1 rounded-md"
        :class="{
          'text-gray-500 cursor-default': !link.url,
          'text-blue-500 hover:text-blue-700': link.url,
          'bg-blue-500 text-white': link.active
        }"
      />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      links: {
        type: Array,
        required: true,
      },
    },
  };
  </script>