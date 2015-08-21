# Social Curator Grid Extension

This plugin is under active development.

## Compatibility

**Requires Social Curator v1.0+.**

## Shortcode

To display the grid, use the shortcode ```[social_curator_grid]```. 
**Options:**
* perpage – Number of items to show per page (int)
* allowmore - Whether to display the "Show More" button (true/false)
* loadmoretext – Text to display in the "Load More" button (string)
* loadingtext – Active state text for "Load More" button (string)
* iconprefix – Customize the icon prefix used to display social icons (string, defaults to "social-curator-icon")
* masonry – Whether to display posts in masonry grid (true/false)
* masonrycolumns - Number of masonry columns to display (int)
* completetext – Text to display in load more button when no posts are remaining (string)

## Filters

```social_curator_grid_loading_content```
Customize the loading text/image in the "loading" button state. Returns HTML.