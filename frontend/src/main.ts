import { createApp } from 'vue'
import App from './App.vue'
import './style.css'
import router from './router'
import Icon from './components/ui/Icon.vue'

const app = createApp(App)

app.use(router)
app.component('Icon', Icon)

app.mount('#app') 