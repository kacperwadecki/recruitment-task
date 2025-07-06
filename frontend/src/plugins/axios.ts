import axios, { type AxiosInstance, type InternalAxiosRequestConfig } from 'axios'

export interface AxiosPlugin {
  instance: AxiosInstance
  setBaseURL: (url: string) => void
  setHeader: (key: string, value: string) => void
  setHeaders: (headers: Record<string, string>) => void
  removeHeader: (key: string) => void
  setAuthToken: (token: string) => void
  clearAuthToken: () => void
  setTimeout: (timeout: number) => void
  setWithCredentials: (withCredentials: boolean) => void
}

const instance = axios.create({
  baseURL: (import.meta as any).env?.VITE_WORDPRESS_API_URL || 'http://localhost/',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

instance.interceptors.request.use((config) => {
  if (config.method === 'get') {
    config.params = {
      ...config.params,
      _t: Date.now()
    }
  }
  return config
})

instance.interceptors.response.use(
  (response) => response,
  (error) => {
    console.error('Axios error:', error)
    return Promise.reject(error)
  }
)

export const axiosPlugin: AxiosPlugin = {
  instance,
  
  setBaseURL(url: string) {
    instance.defaults.baseURL = url
  },
  
  setHeader(key: string, value: string) {
    instance.defaults.headers.common[key] = value
  },
  
  setHeaders(headers: Record<string, string>) {
    Object.entries(headers).forEach(([key, value]) => {
      instance.defaults.headers.common[key] = value
    })
  },
  
  removeHeader(key: string) {
    delete instance.defaults.headers.common[key]
  },
  
  setAuthToken(token: string) {
    instance.defaults.headers.common['Authorization'] = `Bearer ${token}`
  },
  
  clearAuthToken() {
    delete instance.defaults.headers.common['Authorization']
  },
  
  setTimeout(timeout: number) {
    instance.defaults.timeout = timeout
  },
  
  setWithCredentials(withCredentials: boolean) {
    instance.defaults.withCredentials = withCredentials
  }
}


export default axiosPlugin 