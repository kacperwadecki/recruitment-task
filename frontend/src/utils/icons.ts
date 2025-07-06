import starIcon from '@/assets/icons/star-icon.svg?raw'
import usersThreeIcon from '@/assets/icons/users-three-icon.svg?raw'
import headCircuitIcon from '@/assets/icons/head-circuit-icon.svg?raw'

export const icons = {
  'star': starIcon,
  'users-three': usersThreeIcon,
  'head-circuit': headCircuitIcon,
} as const

export type IconName = keyof typeof icons 