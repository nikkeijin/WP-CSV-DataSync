# Troubleshooting

## Error

PHP Fatal error:  Maximum execution time of 30 seconds exceeded in /var/www/html/wp-includes/functions.php on line XXX       

Add the following code into `wp_config.php`:
```
set_time_limit(3600);
```

# Curiosity

## wp_set_post_terms()

Categories & Tags are very similar, but one major difference is that Categories are hierarchical whereas Tags are not.

If hierarchical is set to true in your custom taxonomy (meaning that it'll be similar to a post category) then the function wp_set_post_terms() needs to receive that term's ID (and not it's name). You can use term_exists() to get the id by the name and then use that id to call wp_set_post_terms()

If hierarchical is set to false in your custom taxonomy (meaning that it'll be similar to a post tag) then the function wp_set_post_terms() will accept a name.
