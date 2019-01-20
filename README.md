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
add_filter( 'cubetech/plugin/some-accounts/options', 'add_kununu' );
```

*Warning!* The filter `some_options` is deprecated! Please replace! Will be removed soon.

## Translations

* German (de_DE) - added by Acki 2019-01-20
* English (en_US) - added by Acki 2019-01-20
 
## Version: 1.2.0

## Person Responsible

Christoph S. Ackermann @acki

## Contributors

* Christoph S. Ackermann @acki
* Lucas Schnüriger
* Sven von Arx
* Pascal Knecht

## Changelog

### 1.2.0 2019-01-20

* Added translation function to all texts
* Created pot template
* Added Vimeo icon
* New text domain
* Configured translation options in file header
* Added de&lowbar;DE and en&lowbar;US
* Added Loco Translate configuration XML -> loco.xml

### 1.1.3 2019-01-20

* Added RSS Feed icon

### 1.1.2 2019-01-19

* Fixed README

### 1.1.1 2019-01-19

* Replaced the filter name and added deprecated warning

### 1.1.0 2019-01-19

* Added usage section to README
* Added menu-order to Query and removed post limit (was 5)

### 1.0.1 2017-07-12

* Added composer.json

### 1.0.0 2017-03-01

* Added README and filter

### 0.1

* Added filter to add custom some accounts
