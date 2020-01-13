Views Contextual Filter Validator: Regular Expression
=====================================================

CONTENTS OF THIS FILE
---------------------
   
 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Use
 * Maintainers
 * License

INTRODUCTION
------------

This module adds a Views contextual filter validator that can evaluate an
argument based on user-supplied regular expression pattern.

 * For a full description of the module, visit the project page:
   https://www.drupal.org/project/views_argument_validator_regex
   
 * To submit bug reports and feature suggestions, or to track changes:
   https://www.drupal.org/project/issues/views_argument_validator_regex

REQUIREMENTS
------------

No special requirements.

INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. See:
   https://drupal.org/documentation/install/modules-themes/modules-8
   for further information.

CONFIGURATION
-------------

The module has no menu or modifiable settings. There is no configuration.

USE
---

Add a **Regular express (regex)** validator to a View's contextual filter to use
this module. E.g. --

1. Create a new View with a page display.
1. Add a contextual filter (**Advanced** -> **Contextual Filters** -> **Add**).
1. From the "Add contextual filters" popup:
    - Select "Global" from the **Category** menu.
    - Enable the checkbox for the "Null" filter.
    - Click **Add and configure contextual filters**.
1. Under **When the filter value IS available or a default is provided**, select
*Specify validation criteria* and set the following options:
    - **Validator**: Regular expression (regex)
    - **Regular expression**: /^\d{4}$/
    - **Action to take if filter value does not validate**: Show Page not found
1. Click **Apply**.
1. Click **Save** for the full view.

This example ensure that the first contextual filter is exactly four digits. If
the filters contains any non-digits or is not exactly four characters, the View
page will give a "Page not found" error.

MAINTAINERS
-----------

Current maintainers:
 * Christopher Charbonneau Wells (wells) - https://www.drupal.org/u/wells

This project is sponsored by:
 * [Cascade Public Media](https://www.drupal.org/cascade-public-media) for 
 [KCTS9.org](https://www.kcts9.org/) and [Crosscut.com](https://crosscut.com/).
 
LICENSE
-------

All code in this repository is licensed 
[GPLv2](http://www.gnu.org/licenses/gpl-2.0.html). A LICENSE file is not 
included in this repository per Drupal's module packing specifications.

See [Licensing on Drupal.org](https://www.drupal.org/about/licensing).
