// vite.config.js
import { defineConfig } from "file:///E:/Front-end/Meeting_Chat/node_modules/vite/dist/node/index.js";
import laravel from "file:///E:/Front-end/Meeting_Chat/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///E:/Front-end/Meeting_Chat/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import { resolve, dirname } from "node:path";
import { fileURLToPath } from "url";
import VueI18nPlugin from "file:///E:/Front-end/Meeting_Chat/node_modules/@intlify/unplugin-vue-i18n/lib/vite.mjs";
import Components from "file:///E:/Front-end/Meeting_Chat/node_modules/unplugin-vue-components/dist/vite.mjs";
import { UnpluginVueComponentsResolver } from "file:///E:/Front-end/Meeting_Chat/node_modules/maz-ui/resolvers/index.mjs";
import { AntDesignVueResolver } from "file:///E:/Front-end/Meeting_Chat/node_modules/unplugin-vue-components/dist/resolvers.mjs";
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
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJFOlxcXFxGcm9udC1lbmRcXFxcTWVldGluZ19DaGF0XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJFOlxcXFxGcm9udC1lbmRcXFxcTWVldGluZ19DaGF0XFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9FOi9Gcm9udC1lbmQvTWVldGluZ19DaGF0L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHtkZWZpbmVDb25maWd9IGZyb20gJ3ZpdGUnO1xyXG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xyXG5pbXBvcnQgeyByZXNvbHZlLCBkaXJuYW1lIH0gZnJvbSAnbm9kZTpwYXRoJztcclxuaW1wb3J0IHsgZmlsZVVSTFRvUGF0aCB9IGZyb20gJ3VybCc7XHJcbmltcG9ydCBWdWVJMThuUGx1Z2luIGZyb20gJ0BpbnRsaWZ5L3VucGx1Z2luLXZ1ZS1pMThuL3ZpdGUnXHJcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnO1xyXG5pbXBvcnQgeyBVbnBsdWdpblZ1ZUNvbXBvbmVudHNSZXNvbHZlciB9IGZyb20gJ21hei11aS9yZXNvbHZlcnMnO1xyXG5pbXBvcnQgeyBBbnREZXNpZ25WdWVSZXNvbHZlciB9IGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3Jlc29sdmVycyc7XHJcblxyXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xyXG4gIHBsdWdpbnM6IFtcclxuICAgIGxhcmF2ZWwoe1xyXG4gICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC50cyddLFxyXG4gICAgICByZWZyZXNoOiB0cnVlLFxyXG4gICAgfSksXHJcbiAgICB2dWUoe1xyXG4gICAgICB0ZW1wbGF0ZToge1xyXG4gICAgICAgIGNvbXBpbGVyT3B0aW9uczoge1xyXG4gICAgICAgICAgaXNDdXN0b21FbGVtZW50OiAodGFnKSA9PiB0YWcuZW5kc1dpdGgoJ0xheW91dCcpLFxyXG4gICAgICAgIH1cclxuICAgICAgfVxyXG4gICAgfSksXHJcbiAgICBWdWVJMThuUGx1Z2luKHtcclxuICAgICAgaW5jbHVkZTogcmVzb2x2ZShkaXJuYW1lKGZpbGVVUkxUb1BhdGgoaW1wb3J0Lm1ldGEudXJsKSksICcuL3BhdGgvdG8vc3JjL2xvY2FsZXMvKionKSxcclxuICAgIH0pLFxyXG4gICAgQ29tcG9uZW50cyh7XHJcbiAgICAgIGR0czogdHJ1ZSxcclxuICAgICAgcmVzb2x2ZXJzOiBbXHJcbiAgICAgICAgVW5wbHVnaW5WdWVDb21wb25lbnRzUmVzb2x2ZXIoKSxcclxuICAgICAgXSxcclxuICAgIH0pLFxyXG4gIF0sXHJcbn0pO1xyXG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQW1RLFNBQVEsb0JBQW1CO0FBQzlSLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFDaEIsU0FBUyxTQUFTLGVBQWU7QUFDakMsU0FBUyxxQkFBcUI7QUFDOUIsT0FBTyxtQkFBbUI7QUFDMUIsT0FBTyxnQkFBZ0I7QUFDdkIsU0FBUyxxQ0FBcUM7QUFDOUMsU0FBUyw0QkFBNEI7QUFSMEgsSUFBTSwyQ0FBMkM7QUFVaE4sSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDMUIsU0FBUztBQUFBLElBQ1AsUUFBUTtBQUFBLE1BQ04sT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUEsSUFDWCxDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsTUFDRixVQUFVO0FBQUEsUUFDUixpQkFBaUI7QUFBQSxVQUNmLGlCQUFpQixDQUFDLFFBQVEsSUFBSSxTQUFTLFFBQVE7QUFBQSxRQUNqRDtBQUFBLE1BQ0Y7QUFBQSxJQUNGLENBQUM7QUFBQSxJQUNELGNBQWM7QUFBQSxNQUNaLFNBQVMsUUFBUSxRQUFRLGNBQWMsd0NBQWUsQ0FBQyxHQUFHLDBCQUEwQjtBQUFBLElBQ3RGLENBQUM7QUFBQSxJQUNELFdBQVc7QUFBQSxNQUNULEtBQUs7QUFBQSxNQUNMLFdBQVc7QUFBQSxRQUNULDhCQUE4QjtBQUFBLE1BQ2hDO0FBQUEsSUFDRixDQUFDO0FBQUEsRUFDSDtBQUNGLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
