# wpplugin.some-accounts

## Description:

Add Social Media Post Type to WordPress

## Filters

*	Allows you to extend social media options
``` php
function add_kununu( $options ) {
    $options[] = 'Kununu';
    return $options;
}
add_filter( 'some_options', 'add_kununu' );
```
 
## Version: 0.1

## Person Responsible

Pascal Knecht @pascalknecht

## Contributors

* Pascal Knecht @pascalknecht

## Functionality

## Changelog

### 0.1

* Added filter to add custom some accounts