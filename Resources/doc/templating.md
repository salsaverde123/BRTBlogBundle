Templating
============
To theming your blog application you must override default views that offers this bundle. This action can make in `config.yml` file.
This example shows how you can replace the default templates:
```yaml
brt_blog:
    ...
    views:
      list_template: '@BRTBlog/Blog/list_entries.html.twig' #replace this with your template.
      show_template: '@BRTBlog/Blog/show_entries.html.twig' #replace this with your template.
      pagination_template: '@BRTBlog/Templates/pagination.html.twig' #replace this with your template.
```