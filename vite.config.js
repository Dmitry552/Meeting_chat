import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'url';
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'
import Components from 'unplugin-vue-components/vite';
import { UnpluginVueComponentsResolver } from 'maz-ui/resolvers';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.ts'],
      refresh: true,
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => tag.endsWith('Layout'),
        }
      }
    }),
    VueI18nPlugin({
      include: resolve(dirname(fileURLToPath(import.meta.url)), './path/to/src/locales/**'),
    }),
    Components({
      dts: true,
      resolvers: [
        UnpluginVueComponentsResolver(),
      ],
    }),
  ],
});
