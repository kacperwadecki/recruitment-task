<template>
  <header class="text-center">
    <h2 class="lg:mb-4">
      {{ title }}
    </h2>

    <p class="text-lg font-light">
      {{ subtitle }}
    </p>
  </header>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import type { ModuleHeaderProps } from '@/types/module'

export default defineComponent({
  name: 'ModuleHeader',
  props: {
    title: {
      type: String,
      required: true
    },
    subtitle: {
      type: String,
      required: false
    }
  }
})
</script> 