import { axiosPlugin } from '@/plugins/axios'
import type { ModuleCard } from '@/types/module'
import sampleData from '@/data/sample-data.json'

export async function fetchWordPressData(): Promise<ModuleCard[]> {
  try {
    const response = await axiosPlugin.instance.get('/wp-json/custom-module/v1/data')
    if (response.status !== 200) {
      throw new Error('Failed to fetch data from API')
    }
    return response.data.cards || []
  } catch (err) {
    console.warn('Failed to fetch WordPress data, using sample data:', err)
    return sampleData.cards as ModuleCard[]
  }
} 