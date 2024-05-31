## Magento2 Hyvä Tailwind CSS Purge For CMS Pages & Blocks

https://github.com/dharmesh-tukadiya/hyva-cms-tailwind-purge/assets/140082778/fa84b7c4-e3c8-45b1-a0f3-9c14c80ae130

This module is designed for using custom Hyvä based child theme's tailwind css configurations in the cms pages and blocks.

This extension does nothing but it puts contents of cms blocks and pages into specific folder inside pub directory and those files are included in purge settings of tailwind css.

This way you can use your own variables defined in custom Hyvä based theme's tailwind.config.js file.

You can use this module as alternative to Hyvä's  CMS Tailwind JIT module.

Whenever you save a block or page, it'll replicate the content of that block or page into a file and it'll be available for purging by tailwind css.

![image](https://github.com/dharmesh-tukadiya/hyva-cms-tailwind-purge/assets/140082778/96f96a33-a665-4249-8107-f7b6be5da254)

The above actions as in image will purge all the blocks and pages at once.
