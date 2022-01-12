import { createApp } from 'vue'
import App from './App.vue'
import {
  VuesticPluginsWithoutComponents,
  VaDataTable,
  VaModal,
  VaNavbar,
  VaNavbarItem,
  VaButton,
  VaForm,
  VaInput,
  VaFileUpload,
  VaDateInput,
  VaImage
} from 'vuestic-ui'

const app = createApp(App)

app
  .use(VuesticPluginsWithoutComponents)
  .component('VaNavbar', VaNavbar)
  .component('VaNavbarItem', VaNavbarItem)
  .component('VaForm', VaForm)
  .component('VaInput', VaInput)
  .component('VaButton', VaButton)
  .component('VaFileUpload', VaFileUpload)
  .component('VaDateInput', VaDateInput)
  .component('VaDataTable', VaDataTable)
  .component('VaModal', VaModal)
  .component('VaImage', VaImage)
  .mount('#app')