import type { IconName } from "@/utils/icons"

export type StatCardSize = 'sm' | 'md' | 'lg'
export type CardSpan = 'full' | 'half' | 'quarter'

export interface ModuleCard {
  value: string | number
  description: string
  size?: StatCardSize
  span?: CardSpan
  icon?: IconName
  showDecoration?: boolean
}

export interface ModuleHeaderProps {
  title: string
  subtitle?: string
}

export interface ModuleGridProps {
  cards: ModuleCard[]
}

export interface ModuleData {
  header: ModuleHeaderProps
  cards: ModuleCard[]
}

export interface StatCardProps {
  value: string | number
  description: string
  size?: StatCardSize
  icon?: IconName
  showDecoration?: boolean
  span?: CardSpan
} 