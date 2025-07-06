<template>
  <div 
    :class="[
      'flex bg-container rounded-[3px]',
      heightClasses[size]
    ]"
  >
    <div class="flex flex-col justify-between px-5 lg:px-10 py-5 lg:py-8 flex-1">
      <Icon 
        :name="iconName" 
        :size="48" 
      />
      
      <div class="flex flex-col">
        <div 
          :class="[
            'mb-3 font-medium',
            textSizeClasses[size],
          ]"
        >
          {{ value }}
        </div>
        <p 
          :class="[
            'text-content-secondary text-lg md:text-xl',
          ]"
        >
          {{ description }}
        </p>
      </div>
    </div>
    
    <div 
      v-if="imageSrc"
      class="flex items-center justify-center py-8"
    >
      <img 
        :src="imageSrc"
        alt="decoration"
        class="object-contain h-full w-full"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue'
import type { StatCardSize } from '@/types/module'
import type { IconName } from '@/utils/icons'
import decoration1 from '@/assets/img/decoration-1.webp'

export default defineComponent({
  name: 'StatCard',
  props: {
    value: {
      type: [String, Number],
      required: true
    },
    description: {
      type: String,
      required: true
    },
    size: {
      type: String as () => StatCardSize,
      default: 'md',
    },
    icon: {
      type: String as () => IconName,
      default: 'star'
    },
    showDecoration: {
      type: Boolean,
      default: false
    },
  },
  computed: {
    iconName(): IconName {
      return this.icon
    },
    imageSrc(): string {
      return this.showDecoration ? decoration1 : ''
    },
    heightClasses(): Record<StatCardSize, string> {
      return {
        sm: 'h-70 sm:h-80 xl:h-100',
        md: 'h-60 sm:h-70 lg:h-120 xl:h-146',
        lg: 'h-70 sm:h-80 lg:h-120 xl:h-146',
      }
    },
    textSizeClasses(): Record<StatCardSize, string> {
      return {
        sm: 'text-2xl sm:text-3xl',
        md: 'text-5xl xl:text-6xl',
        lg: 'text-5xl sm:text-7xl xl:text-9xl'
      }
    },
  }
})
</script> 