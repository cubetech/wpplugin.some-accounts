# wpplugin.some-accounts

## Description:

Add Social Media Post Type to WordPress

## Usage

Just add shortcode [some-accounts] to your content.

Or within a template:
``` php
<?php echo do_shortcode( '[some-accounts]' ); ?>
```

## Filters

*	Allows you to extend social media options
``` php
function add_kununu( $options ) {
    $options['kununu'] = 'Kununu';
    return $options;
}
add_filter( 'some_options', 'add_kununu' );
```
 
## Version: 1.1.0

## Person Responsible

Christoph S. Ackermann @acki

## Contributors

* Christoph S. Ackermann @acki
* Lucas Schnüriger
* Sven von Arx
* Pascal Knecht

## Changelog

### 1.1.0 2019-01-19

* Added usage section to README
* Added menu-order to Query and removed post limit (was 5)

### 1.0.1 2017-07-12

* Added composer.json

### 1.0.0 2017-03-01

* Added README and filter

### 0.1

* Added filter to add custom some accounts
