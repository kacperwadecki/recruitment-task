<template>
  <div class="container mx-auto min-h-screen">
    <ModuleHeader 
      title="Headline"
      subtitle="Lorem ipsum dolor sit amet"
    />
    
    <ModuleGrid 
      :cards="moduleCards" 
      class="mt-10 md:mt-15"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import ModuleHeader from '@/components/ModuleHeader.vue'
import ModuleGrid from '@/components/ModuleGrid.vue'
import { fetchWordPressData } from '@/composables/useWordPressData'
import type { ModuleCard } from '@/types/module'

export default defineComponent({
  name: 'ModuleView',
  components: {
    ModuleHeader,
    ModuleGrid
  },
  data() {
    return {
      moduleCards: [] as ModuleCard[]
    }
  },
  async mounted() {
    try {
      this.moduleCards = await fetchWordPressData()
    } catch (err) {
      console.warn('Failed to load module data:', err)
    }
  }
})
</script>
