# Orphan Command

Stable tag: 1.0.0  
Requires at least: 3.3  
Tested up to: 5.6  
Requires PHP: 7.2  
License: GPL v3 or later  
Contributors: tfrommen, humanmade

WP-CLI command to list and delete orphan WordPress entities and metadata.

----

## Introduction

WordPress offers dedicated APIs that are to be used for CRUD operations on the various core data structures.
When deleting a comment via `wp_delete_comment( $comment_id, true )`, WordPress takes care that all metadata for that comment gets automatically deleted as well.
Great!

However, people not always do what is right, and so it's not a rare situation that you have to face a database that is full of orphaned entries.
Comment metadata for comments that no longer exist, comments for non-existing posts, or revisions of posts that don't exist anymore.

Orphan Command provides a new WP-CLI command, `wp orphan`, that lets you easily spot orphans, and even delete them, if you want.

## Table of Contents

* [Installation](#installation)
  * [Composer](#composer)
  * [Manual](#manual)
* [Requirements](#requirements)
  * [PHP](#php)
  * [WordPress](#wordpress)
  * [WP-CLI](#wp-cli)
* [Commands](#commands)
  * [`wp-orphan-blog-meta`](#wp-orphan-blog-meta)
  * [`wp-orphan-comment`](#wp-orphan-comment)
  * [`wp-orphan-comment-meta`](#wp-orphan-comment-meta)
  * [`wp-orphan-post`](#wp-orphan-post)
  * [`wp-orphan-post-meta`](#wp-orphan-post-meta)
  * [`wp-orphan-term-meta`](#wp-orphan-term-meta)
  * [`wp-orphan-user-meta`](#wp-orphan-user-meta)
* [Extending Orphan Command](#extending-orphan-command)
* [Frequently Asked Questions](#frequently-asked-questions)

## Installation

### Composer

Install with [Composer](https://getcomposer.org):

```shell
composer require humanmade/orphan-command
```

By default, Orphan Command will be installed as WP-CLI package.
However, it **can** also be installed as WordPress plugin, for example, by using [a custom install path](https://github.com/composer/installers#custom-install-paths).

### Manual

In case you're not managing your entire site via Composer, you can also clone this repository into your site's plugins directory.

```shell
cd /path/to/plugins

git clone git@github.com:humanmade/orphan-command.git
```

Then, install and set up PHP auto-loading:

```shell
cd orphan-command

composer install --prefer-dist --no-dev
```

Finally, go to your site's Plugins page, and activate Orphan Command.

## Requirements

### PHP

Orphan Command **requires PHP 7.2 or higher**.

### WordPress

Orphan Command **requires WordPress 3.3 or higher**.

### WP-CLI

Orphan Command **requires WP-CLI 2.5 or higher**.

## Commands

In general, all commands support the following three **sub-commands**:

* **`delete`**: Delete all orphans of the respective entity type.
* **`list`**: List all orphans of the respective entity type.
* **`query`**: Print the MySQL query to list all orphans of the respective entity type.

By default, the output of `list` is a comma-separated list of IDs.
This can be changed by using the `--format` option, which supports the following values:

* **`count`**: The number of orphans.
* **`csv`**: Orphan IDs to be exported into a CSV file.
  * Sample usage: `wp orphan post list --format=csv > orphan-posts.csv`
* **`ids`**: Orphan IDs as a single comma-separated string.
* **`json`**: Orphan IDs to be exported into a JSON file.
	* Sample usage: `wp orphan post list --format=json > orphan-posts.json`
* **`table`**: Orphan IDs printed as a table (with a single column only).
* **`yaml`**: Orphan IDs to be exported into a YAML file.
	* Sample usage: `wp orphan post list --format=yaml > orphan-posts.yaml`

Some commands support additional options that are explained in the following sections.

### `wp orphan blog meta`

The `wp orphan blog meta` command lets you list and delete all **blog metadata** referencing **blogs** that don't exist anymore.

**List all orphan blog metadata:**

```shell
wp orphan blog meta list
```

**Delete all orphan blog metadata:**

```shell
wp orphan blog meta delete
```

### `wp orphan comment`

The `wp orphan comment` command lets you list and delete all **comments** referencing **posts** that don't exist anymore.

In addition to `--format`, the `wp orphan comment` command also supports the following options:

* **`--type`**: Comma-separated list of comment type slugs.
  * Sample usage: `--type=comment` or `--type=comment,reaction`

**List all orphan comments of any comment type:**

```shell
wp orphan comment list
```

**List all orphan reactions:**

```shell
wp orphan comment list --type=reaction
```

**Delete all orphan comments of any comment type:**

```shell
wp orphan comment delete
```

**Delete all orphan default comments only:**

```shell
wp orphan comment delete --type=comment
```

**Note:** Since comments can be nested (i.e., a comment can have a parent comment), an orphan comment _could_ also be a comment referencing another comment that does not exist anymore.
This is **not** what this command does, though.
The main reason is that a comment referencing a non-existing post will usually not be exposed to site visitors.

A future version of Orphan Command might allow to also list/delete comments referencing non-existing parent comments.

### `wp orphan comment meta`

The `wp orphan comment meta` command lets you list and delete all **comment metadata** referencing **comments** that don't exist anymore.

**List all orphan comment metadata:**

```shell
wp orphan comment meta list
```

**Delete all orphan comment metadata:**

```shell
wp orphan comment meta delete
```

### `wp orphan post`

The `wp orphan post` command lets you list and delete all **posts** referencing parent **posts** that don't exist anymore.

In addition to `--format`, the `wp orphan post` command also supports the following options:

* **`--type`**: Comma-separated list of post type slugs.
	* Sample usage: `--type=post` or `--type=post,page`

**List all orphan posts of any post type:**

```shell
wp orphan post list
```

**List all orphan pages:**

```shell
wp orphan post list --type=page
```

**Delete all orphan posts of any post type:**

```shell
wp orphan post delete
```

**Delete all orphan default posts only:**

```shell
wp orphan post delete --type=post
```

### `wp orphan post meta`

The `wp orphan post meta` command lets you list and delete all **post metadata** referencing **posts** that don't exist anymore.

**List all orphan post metadata:**

```shell
wp orphan post meta list
```

**Delete all orphan post metadata:**

```shell
wp orphan post meta delete
```

### `wp orphan term meta`

The `wp orphan term meta` command lets you list and delete all **term metadata** referencing **terms** that don't exist anymore.

**List all orphan term metadata:**

```shell
wp orphan term meta list
```

**Delete all orphan term metadata:**

```shell
wp orphan term meta delete
```

### `wp orphan user meta`

The `wp orphan user meta` command lets you list and delete all **user metadata** referencing **users** that don't exist anymore.

**List all orphan user metadata:**

```shell
wp orphan user meta list
```

**Delete all orphan user metadata:**

```shell
wp orphan user meta delete
```

## Extending Orphan Command

If you want to customize or extend the functionality of Orphan Command, you can either extend any of the actual command classes, or you could write your own based on either the `Orphan_Command` or `Orphan_Meta_Command` class included in Orphan Command.

All relevant class methods are marked `protected` or `public`, so you can redefine or decorate any behavior.
For example, the `Orphan_Post_Command` class enhances the `get_query` method to inject the post type passed to the command, if any.

## Frequently Asked Questions

> **What about terms?**

For terms, there is no clear definition of orphans.
An orphan term could be defined in one of several ways:

* An entry in the `wp_terms` table that is not referenced at all in the `wp_term_taxonomy` table. (This is most likely **not** what you want, most of the time.)
* An entry in the `wp_term_taxonomy` table referencing a non-existing term (i.e., `wp_term_taxonomy.term_id` does not exist in `wp_terms.term_id`).
* An entry in the `wp_term_taxonomy` table referencing a non-existing parent term (i.e., `wp_term_taxonomy.parent` does not exist in `wp_terms.term_id`).
* An entry in the `wp_term_relationships` table referencing a non-existing object. (This would either require the taxonomy, or the object type to then use all registered taxonomies.)

To some extent, this is similar to comments.
However, there it is more of an interpretation issue, which is why Orphan Command, by default, defines orphan comments as comments referencing non-existing posts.

A future version of Orphan Command might allow to also list/delete orphan terms.

> **What about site/network metadata?**

The terminology in WordPress around blog metadata and options, network options, and site metadata and options is quite confusing!

> **What about use case XYZ?**

Yes, there are most certainly several possible use cases around orphan data and metadata missing.
However, this is on purpose.

While it may be a good idea to list all users of a specific role that are not added to any site, or to delete all orphan posts with a specific status, this would be out of scope.

Orphan Command provides easy access to tasks that a lot of people might want to perform a lot of times; not more.

That said, you should be able to use existing WP-CLI commands such as `wp <entity> list|delete` or `wp db query` to accomplish any of the above examples quite easily.

## License

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
