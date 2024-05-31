## Hyva Tailwind CSS Purge For CMS Pages & Blocks
This module is designed for using custom hyva based child theme's tailwind css configurations in the cms pages and blocks.

This extension does nothing but it puts contents of cms blocks and pages into specific folder inside pub directory and those files are included in purge settings of tailwind css.

This way you can use your own variables defined in custom hyva based theme's tailwind.config.js file.

You can use this module as alternative to Hyvä's  CMS Tailwind JIT module.

Whenever you save a block or page, it'll replicate the content of that block or page into a file and it'll be available for purging by tailwind css.