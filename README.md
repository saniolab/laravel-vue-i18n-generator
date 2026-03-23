## About

[![Tests](https://github.com/saniolab/laravel-vue-i18n-generator/actions/workflows/run-tests.yml/badge.svg)](https://github.com/saniolab/laravel-vue-i18n-generator/actions/workflows/run-tests.yml)

Generates a [vue-i18n](https://vue-i18n.intlify.dev/) compatible bundle from your [Laravel translations](https://laravel.com/docs/13.x/localization), for use with a [Vue](https://vuejs.org/) front end. Optional [vuex-i18n](https://github.com/dkfbasel/vuex-i18n) output is supported via config.

This package is a maintained fork of https://github.com/martinlindhe/laravel-vue-i18n-generator.

### Requirements

- PHP 8.4 or 8.5
- Laravel 13

## Install

```bash
composer require saniolab/laravel-vue-i18n-generator --dev
```

The service provider is registered automatically via `composer.json` `extra.laravel.providers`.

Publish the config when you need to customize paths or the target i18n library:

```bash
php artisan vendor:publish --provider="Saniolab\VueInternationalizationGenerator\GeneratorProvider"
```

Adjust `jsPath`, `jsFile`, and other options in `config/vue-i18n-generator.php` as needed.

## Using vue-i18n

Install the Vue library, then generate the locale file:

```bash
npm i vue-i18n
```

```bash
php artisan vue-i18n:generate
```

The default **es6** output is a module with a **default export** (a locale → messages map). Example with Vue 3 and vue-i18n 9+:

```js
import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import messages from './vue-i18n-locales.generated';

const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang.slice(0, 2),
    messages,
});

createApp(App).use(i18n).mount('#app');
```

## Using vuex-i18n

```bash
npm i vuex-i18n vuex
```

In `config/vue-i18n-generator.php`, set `'i18nLib' => 'vuex-i18n'`, then run `php artisan vue-i18n:generate`.

```js
import Vue from 'vue';
import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import Locales from './vue-i18n-locales.generated.js';

const store = new Vuex.Store();

Vue.use(vuexI18n.plugin, store);

Vue.i18n.add('en', Locales.en);
Vue.i18n.add('de', Locales.de);
Vue.i18n.set(startLocale);
```

## Output formats

Use `--format` with `es6` (default), `umd`, or `json`:

```bash
php artisan vue-i18n:generate --format umd
```

With **umd**, the bundle exposes `window.vuei18nLocales` for use without a bundler.

## Multiple files (lazy loading)

```bash
php artisan vue-i18n:generate --multi
php artisan vue-i18n:generate --multi-locales
```

## Parameters (named placeholders)

Laravel `:name` placeholders are converted to vue-i18n `{name}` style.

`lang/en/message.php`:

```php
return [
    'hello' => 'Hello :name',
];
```

Vue:

```html
<p>{{ $t('message.hello', { name: 'visitor' }) }}</p>
```

## Notices

- Default output is an ES6 module (`export default …`).
- Advanced Laravel pluralization as in the [docs](https://laravel.com/docs/13.x/localization#pluralization) is not fully mirrored in vue-i18n / vuex-i18n in all cases.

## License

[MIT](LICENSE)
