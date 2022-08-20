## Blog package for ELF CMS

### Installation

    - composer require elfcms/blog
    - php artisan vendor:publish --provider='Elfcms\Blog\Providers\ElfBlogProvider'
    - php artisan storage:link
    - php artisan migrate
