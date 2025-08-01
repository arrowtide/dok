---
id: 0435dbae-45a1-46ca-96be-e6685e78247f
blueprint: example_v1
title: Markdown
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1753356074
---
# Markdown

Dok comes with two commonmark extensions pre-installed:
- [Table of Contents](https://commonmark.thephpleague.com/2.6/extensions/table-of-contents/)
- [Heading Permalink](https://commonmark.thephpleague.com/2.6/extensions/heading-permalinks/)

These are initiated inside of `AppServiceProvider.php` and their config is managed at `config/statamic/markdown.php`.

To use the Table of Contents extension, simply write `[TOC]` on the line you want it to be displayed at.


## Hints Extension
You can use hints (also known as callouts, admonitions, tips etc) in your markdown. Dok comes packaged with a custom version of [this commonmark extension](https://github.com/ueberdosis/commonmark-hint-extension).

```markdown
:::important
This is an important hint
:::
```

You have the following hint type available:
- `note`
- `tip`
- `important`
- `caution`
- `warning`


:::note
This is a note hint
:::

:::tip
This is a tip hint
:::

:::important
This is an important hint
:::

:::caution
This is a caution hint
:::

:::warning
This is a warning hint
:::


You can also use standard markdown inside of a hint:


:::important
Stars are giant balls of super-hot gas that make their own light and heat. Our Sun is a star! Stars come in different colors, which tell us about their temperature. Red stars are the coolest, while blue stars are the hottest. Our Sun is a yellow-white star, sitting right in the middle of the temperature range. Stars also come in many sizes - some are smaller than Earth, while others are so huge they could fit our entire Solar System inside them!

**Fenced Code:**

```javascript
// Example of a simple function in JavaScript
function calculateSum(a, b) {
    let sum = a + b;
    console.log(`The sum of ${a} and ${b} is ${sum}`);
    return sum;
}

// Call the function
calculateSum(5, 10);
```

**Tables:**

| Syntax | Description |
| ----------- | ----------- |
| Header | Title |
| Paragraph | Text |

:::
