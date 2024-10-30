// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/cms/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/cms/node_modules/laravel-vite-plugin/dist/index.js";
import html from "file:///C:/laragon/www/cms/node_modules/@rollup/plugin-html/dist/es/index.js";
import { glob } from "file:///C:/laragon/www/cms/node_modules/glob/dist/esm/index.js";
function GetFilesArray(query) {
  return glob.sync(query);
}
var pageJsFiles = GetFilesArray("resources/assets/js/*.js");
var vendorJsFiles = GetFilesArray("resources/assets/vendor/js/*.js");
var LibsJsFiles = GetFilesArray("resources/assets/vendor/libs/**/*.js");
var CoreScssFiles = GetFilesArray("resources/assets/vendor/scss/**/!(_)*.scss");
var LibsScssFiles = GetFilesArray("resources/assets/vendor/libs/**/!(_)*.scss");
var LibsCssFiles = GetFilesArray("resources/assets/vendor/libs/**/*.css");
var FontsScssFiles = GetFilesArray("resources/assets/vendor/fonts/**/!(_)*.scss");
function libsWindowAssignment() {
  return {
    name: "libsWindowAssignment",
    transform(src, id) {
      if (id.includes("jkanban.js")) {
        return src.replace("this.jKanban", "window.jKanban");
      } else if (id.includes("vfs_fonts")) {
        return src.replaceAll("this.pdfMake", "window.pdfMake");
      }
    }
  };
}
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/assets/css/demo.css",
        "resources/js/app.js",
        ...pageJsFiles,
        ...vendorJsFiles,
        ...LibsJsFiles,
        "resources/js/laravel-user-management.js",
        // Processing Laravel User Management CRUD JS File
        ...CoreScssFiles,
        ...LibsScssFiles,
        ...LibsCssFiles,
        ...FontsScssFiles
      ],
      refresh: true
    }),
    html(),
    libsWindowAssignment()
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxjbXNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXGxhcmFnb25cXFxcd3d3XFxcXGNtc1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovbGFyYWdvbi93d3cvY21zL3ZpdGUuY29uZmlnLmpzXCI7XG5pbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IGh0bWwgZnJvbSAnQHJvbGx1cC9wbHVnaW4taHRtbCc7XG5pbXBvcnQgeyBnbG9iIH0gZnJvbSAnZ2xvYic7XG5cbi8qKlxuICogR2V0IEZpbGVzIGZyb20gYSBkaXJlY3RvcnlcbiAqIEBwYXJhbSB7c3RyaW5nfSBxdWVyeVxuICogQHJldHVybnMgYXJyYXlcbiAqL1xuZnVuY3Rpb24gR2V0RmlsZXNBcnJheShxdWVyeSkge1xuICByZXR1cm4gZ2xvYi5zeW5jKHF1ZXJ5KTtcbn1cbi8qKlxuICogSnMgRmlsZXNcbiAqL1xuLy8gUGFnZSBKUyBGaWxlc1xuY29uc3QgcGFnZUpzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL2pzLyouanMnKTtcblxuLy8gUHJvY2Vzc2luZyBWZW5kb3IgSlMgRmlsZXNcbmNvbnN0IHZlbmRvckpzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL3ZlbmRvci9qcy8qLmpzJyk7XG5cbi8vIFByb2Nlc3NpbmcgTGlicyBKUyBGaWxlc1xuY29uc3QgTGlic0pzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL3ZlbmRvci9saWJzLyoqLyouanMnKTtcblxuLyoqXG4gKiBTY3NzIEZpbGVzXG4gKi9cbi8vIFByb2Nlc3NpbmcgQ29yZSwgVGhlbWVzICYgUGFnZXMgU2NzcyBGaWxlc1xuY29uc3QgQ29yZVNjc3NGaWxlcyA9IEdldEZpbGVzQXJyYXkoJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL3Njc3MvKiovIShfKSouc2NzcycpO1xuXG4vLyBQcm9jZXNzaW5nIExpYnMgU2NzcyAmIENzcyBGaWxlc1xuY29uc3QgTGlic1Njc3NGaWxlcyA9IEdldEZpbGVzQXJyYXkoJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL2xpYnMvKiovIShfKSouc2NzcycpO1xuY29uc3QgTGlic0Nzc0ZpbGVzID0gR2V0RmlsZXNBcnJheSgncmVzb3VyY2VzL2Fzc2V0cy92ZW5kb3IvbGlicy8qKi8qLmNzcycpO1xuXG4vLyBQcm9jZXNzaW5nIEZvbnRzIFNjc3MgRmlsZXNcbmNvbnN0IEZvbnRzU2Nzc0ZpbGVzID0gR2V0RmlsZXNBcnJheSgncmVzb3VyY2VzL2Fzc2V0cy92ZW5kb3IvZm9udHMvKiovIShfKSouc2NzcycpO1xuXG4vLyBQcm9jZXNzaW5nIFdpbmRvdyBBc3NpZ25tZW50IGZvciBMaWJzIGxpa2UgakthbmJhbiwgcGRmTWFrZVxuZnVuY3Rpb24gbGlic1dpbmRvd0Fzc2lnbm1lbnQoKSB7XG4gIHJldHVybiB7XG4gICAgbmFtZTogJ2xpYnNXaW5kb3dBc3NpZ25tZW50JyxcblxuICAgIHRyYW5zZm9ybShzcmMsIGlkKSB7XG4gICAgICBpZiAoaWQuaW5jbHVkZXMoJ2prYW5iYW4uanMnKSkge1xuICAgICAgICByZXR1cm4gc3JjLnJlcGxhY2UoJ3RoaXMuakthbmJhbicsICd3aW5kb3cuakthbmJhbicpO1xuICAgICAgfSBlbHNlIGlmIChpZC5pbmNsdWRlcygndmZzX2ZvbnRzJykpIHtcbiAgICAgICAgcmV0dXJuIHNyYy5yZXBsYWNlQWxsKCd0aGlzLnBkZk1ha2UnLCAnd2luZG93LnBkZk1ha2UnKTtcbiAgICAgIH1cbiAgICB9XG4gIH07XG59XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gIHBsdWdpbnM6IFtcbiAgICBsYXJhdmVsKHtcbiAgICAgIGlucHV0OiBbXG4gICAgICAgICdyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9jc3MvZGVtby5jc3MnLFxuICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgIC4uLnBhZ2VKc0ZpbGVzLFxuICAgICAgICAuLi52ZW5kb3JKc0ZpbGVzLFxuICAgICAgICAuLi5MaWJzSnNGaWxlcyxcbiAgICAgICAgJ3Jlc291cmNlcy9qcy9sYXJhdmVsLXVzZXItbWFuYWdlbWVudC5qcycsIC8vIFByb2Nlc3NpbmcgTGFyYXZlbCBVc2VyIE1hbmFnZW1lbnQgQ1JVRCBKUyBGaWxlXG4gICAgICAgIC4uLkNvcmVTY3NzRmlsZXMsXG4gICAgICAgIC4uLkxpYnNTY3NzRmlsZXMsXG4gICAgICAgIC4uLkxpYnNDc3NGaWxlcyxcbiAgICAgICAgLi4uRm9udHNTY3NzRmlsZXNcbiAgICAgIF0sXG4gICAgICByZWZyZXNoOiB0cnVlLFxuICAgIH0pLFxuICAgIGh0bWwoKSxcbiAgICBsaWJzV2luZG93QXNzaWdubWVudCgpXG4gIF1cbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUNBLFNBQVMsb0JBQW9CO0FBQzdCLE9BQU8sYUFBYTtBQUNwQixPQUFPLFVBQVU7QUFDakIsU0FBUyxZQUFZO0FBT3JCLFNBQVMsY0FBYyxPQUFPO0FBQzVCLFNBQU8sS0FBSyxLQUFLLEtBQUs7QUFDeEI7QUFLQSxJQUFNLGNBQWMsY0FBYywwQkFBMEI7QUFHNUQsSUFBTSxnQkFBZ0IsY0FBYyxpQ0FBaUM7QUFHckUsSUFBTSxjQUFjLGNBQWMsc0NBQXNDO0FBTXhFLElBQU0sZ0JBQWdCLGNBQWMsNENBQTRDO0FBR2hGLElBQU0sZ0JBQWdCLGNBQWMsNENBQTRDO0FBQ2hGLElBQU0sZUFBZSxjQUFjLHVDQUF1QztBQUcxRSxJQUFNLGlCQUFpQixjQUFjLDZDQUE2QztBQUdsRixTQUFTLHVCQUF1QjtBQUM5QixTQUFPO0FBQUEsSUFDTCxNQUFNO0FBQUEsSUFFTixVQUFVLEtBQUssSUFBSTtBQUNqQixVQUFJLEdBQUcsU0FBUyxZQUFZLEdBQUc7QUFDN0IsZUFBTyxJQUFJLFFBQVEsZ0JBQWdCLGdCQUFnQjtBQUFBLE1BQ3JELFdBQVcsR0FBRyxTQUFTLFdBQVcsR0FBRztBQUNuQyxlQUFPLElBQUksV0FBVyxnQkFBZ0IsZ0JBQWdCO0FBQUEsTUFDeEQ7QUFBQSxJQUNGO0FBQUEsRUFDRjtBQUNGO0FBRUEsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDMUIsU0FBUztBQUFBLElBQ1AsUUFBUTtBQUFBLE1BQ04sT0FBTztBQUFBLFFBQ0w7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0EsR0FBRztBQUFBLFFBQ0gsR0FBRztBQUFBLFFBQ0gsR0FBRztBQUFBLFFBQ0g7QUFBQTtBQUFBLFFBQ0EsR0FBRztBQUFBLFFBQ0gsR0FBRztBQUFBLFFBQ0gsR0FBRztBQUFBLFFBQ0gsR0FBRztBQUFBLE1BQ0w7QUFBQSxNQUNBLFNBQVM7QUFBQSxJQUNYLENBQUM7QUFBQSxJQUNELEtBQUs7QUFBQSxJQUNMLHFCQUFxQjtBQUFBLEVBQ3ZCO0FBQ0YsQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
