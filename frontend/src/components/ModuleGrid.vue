<template>
  <div class="grid grid-cols-4 gap-4 sm:gap-6">
    <StatCard
      v-for="(card, index) in cards"
      :key="index"
      :value="card.value"
      :description="card.description"
      :size="card.size"
      :icon="card.icon"
      :show-decoration="card.showDecoration"
      :class="spanClassMap[card.span || 'quarter']"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import StatCard from './StatCard.vue'
import type { ModuleCard, CardSpan } from '@/types/module'

export default defineComponent({
  name: 'ModuleGrid',
  components: {
    StatCard
  },
  props: {
    cards: {
      type: Array as () => ModuleCard[],
      required: true,
    }
  },
  computed: {
    spanClassMap(): Record<CardSpan, string> {
      return {
        full: 'md:col-span-2 lg:col-span-4',
        half: 'col-span-4 lg:col-span-2',
        quarter: 'col-span-4 sm:col-span-2 lg:col-span-1'
      }
    }
  }
})
</script> 
