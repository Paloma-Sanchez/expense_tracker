import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import VueClickAwayPlugin from 'vue3-click-away'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueClickAwayPlugin) 
      .mount(el);

      //App.config.globalProperties.$helpers = helpers;
  },
})
	