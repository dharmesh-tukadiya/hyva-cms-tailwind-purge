## Magento2 Hyvä Tailwind CSS Purge For CMS Pages & Blocks

[![Magento2 Hyvä Tailwind CSS Purge For CMS Pages & Blocks](https://github.com/dharmesh-tukadiya/hyva-cms-tailwind-purge/assets/140082778/d647da57-801e-484e-9f46-792f38d4f987)

This module is designed for using custom Hyvä based child theme's tailwind css configurations in the cms pages and blocks.

This extension does nothing but it puts contents of cms blocks and pages into specific folder inside pub directory and those files are included in purge settings of tailwind css.

This way you can use your own variables defined in custom Hyvä based theme's tailwind.config.js file.

You can use this module as alternative to Hyvä's  CMS Tailwind JIT module.

Whenever you save a block or page, it'll replicate the content of that block or page into a file and it'll be available for purging by tailwind css.
