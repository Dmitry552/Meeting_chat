// vite.config.js
import { defineConfig } from "file:///E:/Front-end/Meeting_Chat/node_modules/vite/dist/node/index.js";
import laravel from "file:///E:/Front-end/Meeting_Chat/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///E:/Front-end/Meeting_Chat/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import { resolve, dirname } from "node:path";
import { fileURLToPath } from "url";
import VueI18nPlugin from "file:///E:/Front-end/Meeting_Chat/node_modules/@intlify/unplugin-vue-i18n/lib/vite.mjs";
import Components from "file:///E:/Front-end/Meeting_Chat/node_modules/unplugin-vue-components/dist/vite.mjs";
import { UnpluginVueComponentsResolver } from "file:///E:/Front-end/Meeting_Chat/node_modules/maz-ui/resolvers/index.mjs";
var __vite_injected_original_import_meta_url = "file:///E:/Front-end/Meeting_Chat/vite.config.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.ts"],
      refresh: true
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => tag.endsWith("Layout")
        }
      }
    }),
    VueI18nPlugin({
      include: resolve(dirname(fileURLToPath(__vite_injected_original_import_meta_url)), "./path/to/src/locales/**")
    }),
    Components({
      dts: true,
      resolvers: [
        UnpluginVueComponentsResolver()
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJFOlxcXFxGcm9udC1lbmRcXFxcTWVldGluZ19DaGF0XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJFOlxcXFxGcm9udC1lbmRcXFxcTWVldGluZ19DaGF0XFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9FOi9Gcm9udC1lbmQvTWVldGluZ19DaGF0L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHtkZWZpbmVDb25maWd9IGZyb20gJ3ZpdGUnO1xyXG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xyXG5pbXBvcnQgeyByZXNvbHZlLCBkaXJuYW1lIH0gZnJvbSAnbm9kZTpwYXRoJztcclxuaW1wb3J0IHsgZmlsZVVSTFRvUGF0aCB9IGZyb20gJ3VybCc7XHJcbmltcG9ydCBWdWVJMThuUGx1Z2luIGZyb20gJ0BpbnRsaWZ5L3VucGx1Z2luLXZ1ZS1pMThuL3ZpdGUnXHJcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnO1xyXG5pbXBvcnQgeyBVbnBsdWdpblZ1ZUNvbXBvbmVudHNSZXNvbHZlciB9IGZyb20gJ21hei11aS9yZXNvbHZlcnMnO1xyXG5cclxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcclxuICBwbHVnaW5zOiBbXHJcbiAgICBsYXJhdmVsKHtcclxuICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAudHMnXSxcclxuICAgICAgcmVmcmVzaDogdHJ1ZSxcclxuICAgIH0pLFxyXG4gICAgdnVlKHtcclxuICAgICAgdGVtcGxhdGU6IHtcclxuICAgICAgICBjb21waWxlck9wdGlvbnM6IHtcclxuICAgICAgICAgIGlzQ3VzdG9tRWxlbWVudDogKHRhZykgPT4gdGFnLmVuZHNXaXRoKCdMYXlvdXQnKSxcclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH0pLFxyXG4gICAgVnVlSTE4blBsdWdpbih7XHJcbiAgICAgIGluY2x1ZGU6IHJlc29sdmUoZGlybmFtZShmaWxlVVJMVG9QYXRoKGltcG9ydC5tZXRhLnVybCkpLCAnLi9wYXRoL3RvL3NyYy9sb2NhbGVzLyoqJyksXHJcbiAgICB9KSxcclxuICAgIENvbXBvbmVudHMoe1xyXG4gICAgICBkdHM6IHRydWUsXHJcbiAgICAgIHJlc29sdmVyczogW1xyXG4gICAgICAgIFVucGx1Z2luVnVlQ29tcG9uZW50c1Jlc29sdmVyKCksXHJcbiAgICAgIF0sXHJcbiAgICB9KSxcclxuICBdLFxyXG59KTtcclxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFtUSxTQUFRLG9CQUFtQjtBQUM5UixPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLFNBQVMsU0FBUyxlQUFlO0FBQ2pDLFNBQVMscUJBQXFCO0FBQzlCLE9BQU8sbUJBQW1CO0FBQzFCLE9BQU8sZ0JBQWdCO0FBQ3ZCLFNBQVMscUNBQXFDO0FBUGlILElBQU0sMkNBQTJDO0FBU2hOLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQzFCLFNBQVM7QUFBQSxJQUNQLFFBQVE7QUFBQSxNQUNOLE9BQU8sQ0FBQyx5QkFBeUIscUJBQXFCO0FBQUEsTUFDdEQsU0FBUztBQUFBLElBQ1gsQ0FBQztBQUFBLElBQ0QsSUFBSTtBQUFBLE1BQ0YsVUFBVTtBQUFBLFFBQ1IsaUJBQWlCO0FBQUEsVUFDZixpQkFBaUIsQ0FBQyxRQUFRLElBQUksU0FBUyxRQUFRO0FBQUEsUUFDakQ7QUFBQSxNQUNGO0FBQUEsSUFDRixDQUFDO0FBQUEsSUFDRCxjQUFjO0FBQUEsTUFDWixTQUFTLFFBQVEsUUFBUSxjQUFjLHdDQUFlLENBQUMsR0FBRywwQkFBMEI7QUFBQSxJQUN0RixDQUFDO0FBQUEsSUFDRCxXQUFXO0FBQUEsTUFDVCxLQUFLO0FBQUEsTUFDTCxXQUFXO0FBQUEsUUFDVCw4QkFBOEI7QUFBQSxNQUNoQztBQUFBLElBQ0YsQ0FBQztBQUFBLEVBQ0g7QUFDRixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
