import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";
import pluginVue from "eslint-plugin-vue";

/** @type {import('eslint').Linter.Config[]} */
export default [
  { files: ["**/*.{js,mjs,cjs,ts,vue}"] },
  { files: ["**/*.js"], languageOptions: { sourceType: "script" } },
  {
    languageOptions: {
      globals: {
        ...globals.browser,
        FileReader: "readonly",
        defineProps: "readonly",
        defineEmits: "readonly",
        defineExpose: "readonly",
        withDefaults: "readonly",
      },
    },
  },
  pluginJs.configs.recommended,
  ...tseslint.configs.recommended,
  ...pluginVue.configs["flat/essential"],
  {
    files: ["**/*.vue"],
    languageOptions: {
      parserOptions: {
        parser: tseslint.parser,
        project: './resources/assets/tsconfig.json',  // Ensure ESLint uses the correct tsconfig file
      }
    }
    // languageOptions: { parserOptions: { parser: tseslint.parser } },
  },
  {
    ignores: [
      "cypress/fixtures",
      "cypress/screenshots",
      "resources/assets/js/tests/__coverage__",
    ],
    rules: {
      quotes: 0,
      camelcase: 0,
      "no-undef": 0,
      "no-unused-vars": 0,
      "no-useless-escape": 0,
      "no-multi-str": 0,
      "no-empty": 0,
      "no-use-before-define": 0,
      "@typescript-eslint/no-var-requires": 0,
      "@typescript-eslint/camelcase": 0,
      "@typescript-eslint/member-delimiter-style": 0,
      "@typescript-eslint/consistent-type-assertions": 0,
      "@typescript-eslint/no-inferrable-types": 0,
      "@typescript-eslint/no-explicit-any": 0,
      "@typescript-eslint/no-non-null-assertion": 0,
      "@typescript-eslint/ban-ts-comment": 0,
      "@typescript-eslint/no-empty-function": 0,
      "@typescript-eslint/explicit-module-boundary-types": 0,
      "@typescript-eslint/no-unused-expressions": 0,
      "@typescript-eslint/no-unused-vars": ["error", { "argsIgnorePattern": "^_", "varsIgnorePattern": "^T" }],
      "standard/no-callback-literal": 0,
      "vue/valid-v-on": 0,
      "vue/no-side-effects-in-computed-properties": 0,
      "vue/max-attributes-per-line": 0,
      "vue/no-v-html": 0,
      "vue/singleline-html-element-content-newline": 0,
      "vue/multi-word-component-names": 0,
    },
  },
];
