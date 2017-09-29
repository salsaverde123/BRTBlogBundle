Configuration
============

Full bundle configuration 

```yml
brt_blog:
    uploader:
        posts:
            uri_prefix: 'http://localhost/brtblogbundleproject/web/images/posts'
            upload_destination: '%kernel.root_dir%/../web/images/posts'
        

paginator:
    page_range: 5                       # number of links showed in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links to page 4, 5, 6)
    default_options:
        page_name: page                 # page query parameter name
        sort_field_name: sort           # sort field query parameter name
        sort_direction_name: direction  # sort direction query parameter name
        distinct: true                  # ensure distinct results, useful when ORM queries are using GROUP BY statements
        filter_field_name: filterField  # filter field query parameter name
        filter_value_name: filterValue  # filter value query paameter name

views:
    list_template: '@BRTBlog/Resources/Views/Blog/list_entries.html.twig'
    show_template: '@BRTBlog/Resources/Views/Blog/show_entries.html.twig'
    pagination_template: '@BRTBlog/Resources/Views/Templates/pagination.html.twig'
```