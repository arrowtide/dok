---
id: 104fca79-1892-4849-bb19-9d9999a8cce3
blueprint: example_v1
title: 'Code Highlighting'
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1740705521
---
# Code Highlighting

[TOC]

## Intro

When installing Dok you'll get the option to choose which code highlighter you want installed. We __strongly recommend__ using [Torchlight Engine](https://github.com/torchlight-api/engine). Infact, the code highlighting you see on this page are using Torchlight Engine! The other option is [Shiki.](https://github.com/spatie/commonmark-shiki-highlighter)


## Performance
Shiki and Torchlight Engine runs every page load, so it's recommended to have some sort of static caching. [Learn more about static caching in Statamic](https://statamic.dev/static-caching). Alternativly you may choose to use the [`{{ cache }}`](https://statamic.dev/tags/cache) tags instead.

It's strongly recommended to use caching for Shiki, as it's a hungry process.


## Theme

You can change your theme by changing the `$highlightTheme` variable inside of your `AppServiceProvider.php`.

[View a list of available themes for Torchlight Engine.](https://github.com/torchlight-api/engine?tab=readme-ov-file#available-themes)
[View a list of available themes for Shiki.](https://github.com/shikijs/textmate-grammars-themes/tree/main/packages/tm-themes)

---

## Examples

### JavaScript

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

### Python

```python
# Example of a class in Python
class Animal:
    def __init__(self, name, species):
        self.name = name
        self.species = species

    def make_sound(self):
        print("Some generic sound")

class Dog(Animal):
    def __init__(self, name, breed):
        super().__init__(name, species="Dog")
        self.breed = breed

    def make_sound(self):
        print("Woof!")

# Create an instance
my_dog = Dog("Rex", "German Shepherd")
my_dog.make_sound()
```

### HTML

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syntax Highlighting Example</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Hello World</h1>
    </header>
    <main>
        <p>This is an example HTML document.</p>
    </main>
    <script src="script.js"></script>
</body>
</html>
```

### CSS

```css
/* CSS styling example */
body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
}

header {
    background: #333;
    color: #fff;
    padding: 1rem;
    text-align: center;
}

h1 {
    margin: 0;
}

@media (max-width: 600px) {
    body {
        padding: 10px;
    }
}
```


### Antlers (Statamic)

```antlers
{{# Antlers template example for Statamic #}}
{{ if show_header }}
    <header class="site-header {{ header_class }}">
        <h1>{{ title }}</h1>

        {{# Navigation #}}
        <nav>
            {{ nav:main include_home="true" }}
                <a href="{{ url }}" class="{{ if is_current }}active{{ /if }}">
                    {{ title }}
                </a>
            {{ /nav:main }}
        </nav>
    </header>
{{ /if }}

{{# Display a collection of items #}}
<div class="items-grid">
    {{ collection:products limit="6" sort="title:asc" }}
        <div class="product-card">
            <h2>{{ title }}</h2>
            {{ if on_sale }}
                <span class="sale-badge">On Sale!</span>
            {{ /if }}
            <p>{{ price | currency }}</p>
            {{ assets:product_image }}
                <img src="{{ url }}" alt="{{ alt }}">
            {{ /assets:product_image }}
        </div>
    {{ /collection:products }}
</div>
```

### SQL

```sql
-- Creating a table and inserting data
CREATE TABLE employees (
    employee_id INT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    hire_date DATE,
    salary DECIMAL(10, 2)
);

-- Insert some data
INSERT INTO employees (employee_id, first_name, last_name, hire_date, salary)
VALUES (1, 'John', 'Doe', '2022-01-15', 75000.00);

-- Query with join
SELECT e.first_name, e.last_name, d.department_name
FROM employees e
JOIN departments d ON e.department_id = d.department_id
WHERE e.salary > 50000
ORDER BY e.last_name ASC;
```

### Java

```java
// Example of a Java class
public class Person {
    private String name;
    private int age;

    public Person(String name, int age) {
        this.name = name;
        this.age = age;
    }

    public void greet() {
        System.out.println("Hello, my name is " + name + " and I am " + age + " years old.");
    }

    public static void main(String[] args) {
        Person person = new Person("Alice", 30);
        person.greet();
    }
}
```

### C#

```csharp
using System;
using System.Collections.Generic;

namespace SyntaxExample
{
    class Program
    {
        static void Main(string[] args)
        {
            // Create a dictionary
            Dictionary<string, int> scores = new Dictionary<string, int>()
            {
                {"Alice", 95},
                {"Bob", 87},
                {"Charlie", 92}
            };

            // Iterate through the dictionary
            foreach (var item in scores)
            {
                Console.WriteLine($"{item.Key} scored {item.Value}");
            }

            // LINQ example
            var highScores = scores.Where(s => s.Value >= 90);
        }
    }
}
```

### Ruby

```ruby
# Example of a Ruby class
class Book
  attr_accessor :title, :author, :pages

  def initialize(title, author, pages)
    @title = title
    @author = author
    @pages = pages
  end

  def to_s
    "#{@title} by #{@author} (#{@pages} pages)"
  end
end

# Create a new book
book = Book.new("The Hobbit", "J.R.R. Tolkien", 295)
puts book

# Array manipulation
books = ["Book A", "Book B", "Book C"]
books.each_with_index do |book, index|
  puts "#{index + 1}: #{book}"
end
```

### PHP

```php
<?php
// Class definition
class User {
    private $name;
    private $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function getInfo() {
        return "Name: {$this->name}, Email: {$this->email}";
    }
}

// Create a new user
$user = new User("John Doe", "john@example.com");
echo $user->getInfo();

// Array handling
$colors = ["red", "green", "blue"];
foreach ($colors as $color) {
    echo "<div style='color: {$color}'>This text is {$color}</div>";
}
?>
```
