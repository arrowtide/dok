---
id: 0435dbae-45a1-46ca-96be-e6685e78247f
blueprint: example_v1
title: Markdown
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1741267736
---
# Markdown

Dok comes with two commonmark extensions pre-installed:
- [Table of Contents](https://commonmark.thephpleague.com/2.6/extensions/table-of-contents/)
- [Heading Permalink](https://commonmark.thephpleague.com/2.6/extensions/heading-permalinks/)

These are initiated inside of `AppServiceProvider.php` and their config is managed at `config/statamic/markdown.php`.

To use the Table of Contents extension, simply write `[TOC]` on the line you want it to be displayed at.