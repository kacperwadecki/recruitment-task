<template>
  <svg
    :style="{ color: '#707070' }"
    :width="size"
    :height="size"
    viewBox="0 0 48 48"
    fill="none"
    v-html="iconPath"
  ></svg>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue'
import { icons, type IconName } from '@/utils/icons'

export interface IconProps {
  name: IconName
  size?: string | number
}

export default defineComponent({
  name: 'Icon',
  props: {
    name: {
      type: String as () => IconName,
      required: true
    },
    size: {
      type: [String, Number],
      default: 48
    },
  },
  computed: {
    iconPath(): string {
      return icons[this.name] || icons.star
    },
  }
})
</script>

